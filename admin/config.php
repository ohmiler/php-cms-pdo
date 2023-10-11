<?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=basiccms", "root", "root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Failed to connect to database: " . $e->getMessage());
    }
?>
