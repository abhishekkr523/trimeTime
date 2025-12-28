<?php
session_start();
// require_once __DIR__ . '/config/constants.php';
// require_once __DIR__ . '/config/database.php';
?>

<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>

<div class="container mt-5 text-center">
    <h1 class="display-5">Welcome to TrimTime</h1>
    <p class="lead">Book your haircut at your convenience, avoid the queue!</p>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="auth/register.php" class="btn btn-primary">Sign Up</a>
            <a href="auth/login.php" class="btn btn-outline-success">Login</a>
        </div>
    <?php else: ?>
        <div class="mt-4">
            <p>You are logged in as <strong><?= $_SESSION['user_name']; ?></strong></p>
            <a href="<?php echo ($_SESSION['user_role'] === 'barber') ? 'barber/dashboard.php' : 'client/dashboard.php'; ?>" class="btn btn-success">Go to Dashboard</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'views/includes/footer.php'; ?>
