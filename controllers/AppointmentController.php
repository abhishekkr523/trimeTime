<?php
require '../config/database.php';

if (isset($_POST['book_appointment'])) {
    $client_id = $_POST['client_id'];
    $barber_id = $_POST['barber_id'];
    $service_id = $_POST['service_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    // Check for double booking
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE barber_id = ? AND appointment_date = ? AND appointment_time = ?");
    $stmt->execute([$barber_id, $date, $time]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Time slot already booked. Please choose another time.'); window.history.back();</script>";
        exit;
    }

    // Insert appointment
    $stmt = $pdo->prepare("INSERT INTO appointments (client_id, barber_id, service_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$client_id, $barber_id, $service_id, $date, $time]);

    header("Location: ../client/appointments.php");
    exit;
}

if (isset($_POST['cancel_appointment'])) {
    $appointment_id = $_POST['appointment_id'];

    // Ensure appointment belongs to the logged-in client
    session_start();
    $client_id = $_SESSION['user_id'] ?? 0;

    $stmt = $pdo->prepare("UPDATE appointments 
                           SET status = 'cancelled' 
                           WHERE id = ? AND client_id = ? AND status = 'pending'");
    $stmt->execute([$appointment_id, $client_id]);

    header("Location: ../client/appointments.php");
    exit;
}



// Approve appointment
if (isset($_POST['approve_appointment'])) {
    $appointment_id = $_POST['appointment_id'];

    session_start();
    $barber_id = $_SESSION['user_id'] ?? 0;

    $stmt = $pdo->prepare("UPDATE appointments 
                           SET status = 'approved' 
                           WHERE id = ? AND barber_id = ? AND status = 'pending'");
    $stmt->execute([$appointment_id, $barber_id]);

    header("Location: ../barber/appointments.php");
    exit;
}

// Cancel appointment (barber side)
if (isset($_POST['cancel_appointment_by_barber'])) {
    $appointment_id = $_POST['appointment_id'];

    session_start();
    $barber_id = $_SESSION['user_id'] ?? 0;

    $stmt = $pdo->prepare("UPDATE appointments 
                           SET status = 'cancelled' 
                           WHERE id = ? AND barber_id = ? AND status = 'pending'");
    $stmt->execute([$appointment_id, $barber_id]);

    header("Location: ../barber/appointments.php");
    exit;
}



if (isset($_POST['complete_appointment'])) {
    $appointment_id = $_POST['appointment_id'];

    session_start();
    $barber_id = $_SESSION['user_id'] ?? 0;

    $stmt = $pdo->prepare("UPDATE appointments 
                           SET status = 'completed' 
                           WHERE id = ? AND barber_id = ? AND status = 'approved'");
    $stmt->execute([$appointment_id, $barber_id]);

    header("Location: ../barber/appointments.php");
    exit;
}

