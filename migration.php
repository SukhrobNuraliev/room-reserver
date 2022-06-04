<?php

require 'connection.php';

/* create tables */
$sql = "CREATE TABLE IF NOT EXISTS tenants (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(30) NOT NULL,
        email VARCHAR(50) UNIQUE,
        phone VARCHAR(30) NOT NULL UNIQUE
    );
    CREATE TABLE IF NOT EXISTS rooms (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        number INTEGER NOT NULL UNIQUE
    );
    CREATE TABLE IF NOT EXISTS reservations (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        room_id INT(11) UNSIGNED NOT NULL,
        FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
        tenant_id INT(11) UNSIGNED NOT NULL,
        FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE,
        reserved_from DATETIME NOT NULL,
        reserved_till DATETIME NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
$pdo->exec($sql);


/* create 5 rooms */
foreach (range(1, 5) as $number) {
    /* if room does not already exist */
    if ($pdo->query("SELECT number FROM rooms WHERE number = $number")->fetch() == null) {
        $pdo->exec("INSERT INTO rooms (number) VALUES ($number)");
    }
}

header("Location: /");
exit();

