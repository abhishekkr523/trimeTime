<?php
session_start();
require '../config/database.php';

if (isset($_POST['toggle_favorite'])) {
    $client_id = $_SESSION['user_id'];
    $barber_id = $_POST['barber_id'];

    // Check if already favorite
    $check = $pdo->prepare("SELECT * FROM favorites WHERE client_id = ? AND barber_id = ?");
    $check->execute([$client_id, $barber_id]);

    if ($check->rowCount() > 0) {
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE client_id = ? AND barber_id = ?");
        $stmt->execute([$client_id, $barber_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO favorites (client_id, barber_id) VALUES (?, ?)");
        $stmt->execute([$client_id, $barber_id]);
    }

    header("Location: ../client/dashboard.php");
    exit;
}
