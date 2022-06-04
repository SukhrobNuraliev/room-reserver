<?php

require '../connection.php';

$room_id = $_GET['room'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = date('Y-m-d H:i:s', strtotime($_POST['date']));

    $status = 'Free!';
    $reservations = $pdo->query("SELECT * FROM reservations WHERE room_id = $room_id")->fetchAll();

    foreach ($reservations as $reservation) {
        $from = $reservation['reserved_from'];
        $till = $reservation['reserved_till'];

        if (($date >= $from) && ($date <= $till)) {
            $status = 'Already reserved!';
        }
    }

    $_SESSION['status'] = $status;
}
?>

<?php include('../layouts/header.php'); ?>

<div class="flex flex-col items-center justify-center mt-60">
    <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm">
        <h3 class="font-bold mb-4 text-center text-xl">
            Room <?= $room_id; ?>
        </h3>
        <form method="POST" action="">
            <div class="form-group mb-2">
                <label class="form-label inline-block text-gray-700">Date</label>
                <input class="bg-white block border border-gray-300 border-solid form-control px-3 py-1.5 rounded text-gray-700 transition w-full"
                       type="datetime-local" placeholder="Date" name="date">
            </div>
            <div class="flex flex-col gap-1 items-center text-center mt-4">
                <button type="submit" class="bg-blue-600 font-medium hover:bg-blue-700 hover:shadow-lg px-6 py-2.5 rounded shadow-md text-white text-xs transition uppercase">
                    Check
                </button>
                <a href="reserve.php?room=<?= $room_id; ?>" class="bg-gray-200 font-medium hover:shadow-md hover:text-gray-800 px-6 py-2.5 rounded shadow-md text-gray-500 text-white text-xs transition uppercase">
                    Reserve
                </a>
            </div>
        </form>
    </div>

    <?php if (isset($_SESSION['status'])) : ?>
        <div class="bg-blue-100 shadow-lg rounded-lg py-5 px-6 text-blue-700 mt-4" role="alert">
            <?= $_SESSION['status']; ?>
        </div>
    <?php endif; ?>

</div>

<?php include('../layouts/footer.php'); ?>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

