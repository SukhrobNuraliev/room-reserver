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

<?php include('header.php'); ?>

    <p class="font-bold mt-8 text-2xl text-center">Hello World!</p>
    <div class="flex flex-wrap gap-7 justify-around p-20">
        <?php if ($rooms == null) : ?>
            <a href="migration.php">Migrate Database and Seed</a>
        <?php else : ?>
            <?php foreach ($rooms as $room): ?>
                <div class="bg-white duration-300 flex flex-col font-medium hover:shadow-xl items-center p-20 rounded shadow-lg transition">
                    <span>Room <?= $room['number']; ?></span>
                    <a href="reserve.php?room=<?= $room['number']; ?>" class="bg-gray-200 hover:shadow-md hover:text-gray-800 p-1 px-2 rounded-sm shadow-sm text-gray-600 text-sm transition">Reserve</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php include('footer.php'); ?>