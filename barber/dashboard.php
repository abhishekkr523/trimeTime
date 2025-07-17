<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'barber') {
    header("Location: ../auth/login.php");
    exit;
}
include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>

<div class="container mt-5">
    <h2>Welcome, <?php echo $_SESSION['user_name']; ?>!</h2>
    <p>This is your barber dashboard.</p>
</div>

<?php include '../views/includes/footer.php'; ?>
