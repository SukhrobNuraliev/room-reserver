<?php

require '../connection.php';

$room_id = $_GET['room'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $from = date('Y-m-d H:i:s', strtotime($_POST['from']));
    $till = date('Y-m-d H:i:s', strtotime($_POST['till']));

    /* check if reservation already exists */
    $reservations = $pdo->query("SELECT * FROM reservations WHERE room_id = $room_id")->fetchAll();
    $status = '';
    $existingReservation = [];
    $tenant = [];
    foreach ($reservations as $reservation) {
        $reserved_from = $reservation['reserved_from'];
        $reserved_till = $reservation['reserved_till'];

        if (
            (($from >= $reserved_from) && ($till <= $reserved_till)) ||
            (($from <= $reserved_from) && ($till >= $reserved_till)) ||
            (($from <= $reserved_from) && ($till >= $reserved_from)) ||
            (($from <= $reserved_till) && ($till >= $reserved_till))
        ) {
            $status = 'reserved';
            $existingReservation = $reservation;
            $tenant_id = $reservation['tenant_id'];
            $tenant = $pdo->query("SELECT * FROM tenants WHERE id = $tenant_id LIMIT 1")->fetch();
            break;
        } else {
            $status = 'free';
        }
    }

    if (empty($reservations) || $status == 'free') {
        /* create tenant */
        $tenant_data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ];
        $pdo->prepare("INSERT INTO tenants (name, email, phone) VALUES (:name, :email, :phone)")->execute($tenant_data);

        $tenant_id = $pdo->lastInsertId();

        /* reserve a room */
        $reservation_data = [
            'room_id' => $room_id,
            'tenant_id' => $tenant_id,
            'reserved_from' => $from,
            'reserved_till' => $till,
        ];
        $pdo->prepare("INSERT INTO reservations (room_id, tenant_id, reserved_from, reserved_till) VALUES (:room_id, :tenant_id, :reserved_from, :reserved_till)")->execute($reservation_data);

        $_SESSION['success'] = 'Successfully Reserved!';


        /* send an email */
        $subject = "Room reservation";
        $message = "You have reserved room" . $room_id . " from " . $from . " till " . $till;
        mail ($email, $subject, $message, 'my@email.com');

    } else {
        $_SESSION['tenant'] = $tenant;
        $_SESSION['reservation'] = $existingReservation;
    }
}

?>

<?php include('../layouts/header.php'); ?>

<div class="flex flex-col items-center justify-center mt-60">
    <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm">
        <h3 class="font-bold mb-4 text-center text-xl">
            Room <?= $room_id; ?>
        </h3>
        <form method="POST" action="">
            <input type="text" placeholder="Name" name="name" required class="bg-white block border border-gray-300 border-solid form-control px-3 py-1.5 rounded text-gray-700 transition w-full mb-2">
            <input type="email" placeholder="Email" name="email" required class="bg-white block border border-gray-300 border-solid form-control px-3 py-1.5 rounded text-gray-700 transition w-full mb-2">
            <input type="text" placeholder="Phone" name="phone" required class="bg-white block border border-gray-300 border-solid form-control px-3 py-1.5 rounded text-gray-700 transition w-full mb-2">
            <label>From</label>
            <input type="datetime-local" placeholder="From" name="from" required class="bg-white block border border-gray-300 border-solid form-control px-3 py-1.5 rounded text-gray-700 transition w-full">
            <label>Till</label>
            <input type="datetime-local" placeholder="From" name="till" required class="bg-white block border border-gray-300 border-solid form-control px-3 py-1.5 rounded text-gray-700 transition w-full">
            <div class="text-center">
                <button type="submit" class="bg-blue-600 font-medium hover:bg-blue-700 hover:shadow-lg px-6 py-2.5 rounded shadow-md text-white text-xs transition uppercase">
                    Reserve
                </button>
            </div>
        </form>
    </div>

        <?php if (isset($_SESSION['success'])) : ?>
            <div class="bg-green-100 shadow-lg rounded-lg py-5 px-6 text-green-700 mt-4" role="alert">
                <div><?= $_SESSION['success']; ?></div>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['reservation'])) : ?>
            <div class="bg-green-100 shadow-lg rounded-lg py-5 px-6 text-green-700 mt-4" role="alert">
                <div>Already Reserved!</div>
                <div>By: <?= $_SESSION['tenant']['name']; ?></div>
                <div>From: <?= $_SESSION['reservation']['reserved_from']; ?></div>
                <div>Till: <?= $_SESSION['reservation']['reserved_till']; ?></div>
            </div>
        <?php endif; ?>

</div>

<?php include('../layouts/footer.php'); ?>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
