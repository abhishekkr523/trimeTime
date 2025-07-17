<?php
session_start();
require '../config/database.php';

// Registration
if (isset($_POST['register'])) {
    $name     = htmlspecialchars(trim($_POST['name']));
    $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role'];

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo "Email already registered.";
        exit;
    }

    // Insert user
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $email, $password, $role]);

    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['user_role'] = $role;
    $_SESSION['user_name'] = $name;

    // Redirect
    if ($role === 'barber') {
        header("Location: ../barber/dashboard.php");
    } else {
        header("Location: ../client/dashboard.php");
    }
    exit;
}

// Login
if (isset($_POST['login'])) {
    $email    = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_name'] = $user['name'];

        if ($user['role'] === 'barber') {
            header("Location: ../barber/dashboard.php");
        } else {
            header("Location: ../client/dashboard.php");
        }
    } else {
        echo "Invalid credentials.";
    }

    exit;
}
?>
