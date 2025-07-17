<?php
require '../config/database.php';

// Add Service
if (isset($_POST['add_service'])) {
    $barber_id = $_POST['barber_id'];
    $service_name = trim($_POST['service_name']);
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO services (barber_id, service_name, price) VALUES (?, ?, ?)");
    $stmt->execute([$barber_id, $service_name, $price]);

    header("Location: ../barber/services.php");
    exit;
}

// Update Service
if (isset($_POST['update_service'])) {
    $service_id = $_POST['service_id'];
    $service_name = trim($_POST['service_name']);
    $price = $_POST['price'];

    $stmt = $pdo->prepare("UPDATE services SET service_name = ?, price = ? WHERE id = ?");
    $stmt->execute([$service_name, $price, $service_id]);

    header("Location: ../barber/services.php");
    exit;
}

// Delete Service
if (isset($_POST['delete_service'])) {
    $service_id = $_POST['service_id'];
    $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    $stmt->execute([$service_id]);

    header("Location: ../barber/services.php");
    exit;
}
