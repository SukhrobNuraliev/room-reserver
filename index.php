<?php
require 'connection.php';

try {
    /* check if database tables exist */
    $pdo->query("SELECT 1 FROM rooms");
    $rooms = $pdo->query("SELECT id, number FROM rooms")->fetchAll();
} catch (PDOException $e) {
    $rooms = null;
}

?>

<?php include('layouts/header.php'); ?>

    <p class="font-bold mt-8 text-2xl text-center">Reserve a Room</p>
    <div class="flex flex-wrap gap-7 justify-around p-20">
        <?php if ($rooms == null) : ?>
            <a href="migration.php" class="bg-blue-600 font-medium hover:bg-blue-700 hover:shadow-lg px-6 py-2.5 rounded shadow-md text-white text-xs transition uppercase">
                Migrate Database and Seed
            </a>
        <?php else : ?>
            <?php foreach ($rooms as $room): ?>
                <div class="bg-white duration-300 flex flex-col font-medium hover:shadow-xl items-center p-20 rounded shadow-lg transition">
                    <span>Room <?= $room['number']; ?></span>
                    <a href="pages/check.php?room=<?= $room['number']; ?>" class="bg-gray-200 hover:shadow-md hover:text-gray-800 p-1 px-2 rounded-sm shadow-sm text-gray-600 text-sm transition mb-1">
                        Check
                    </a>
                    <a href="pages/reserve.php?room=<?= $room['number']; ?>" class="bg-gray-200 hover:shadow-md hover:text-gray-800 p-1 px-2 rounded-sm shadow-sm text-gray-600 text-sm transition">
                        Reserve
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php include('layouts/footer.php'); ?>