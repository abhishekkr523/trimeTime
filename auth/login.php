<?php
require_once __DIR__ . '/../controllers/AuthController.php';
?>
<?php include '../views/includes/header.php'; ?>
<?php include '../views/includes/navbar.php'; ?>

<!-- Font + Styling -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">

<style>

    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        box-shadow: 0 0 25px rgba(144, 55, 255, 0.2);
        border-radius: 20px;
        padding: 40px 30px;
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    .glass-card h2 {
        font-size: 28px;
        font-weight: 600;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 30px;
    }

    .form-label {
        text-align: left;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
        color: #cfcfcf;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.08);
        border: none;
        color: white;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .form-control::placeholder {
        color: #ccc;
    }

    .form-control:focus {
        border: 1px solid #9f65ff;
        box-shadow: 0 0 8px #9f65ff;
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    .btn-login {
        background: linear-gradient(to right, #9d50bb, #6e48aa);
        border: none;
        padding: 12px 20px;
        width: 100%;
        border-radius: 50px;
        font-weight: 600;
        font-size: 16px;
        color: white;
        transition: 0.3s ease;
    }

    .btn-login:hover {
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        box-shadow: 0 0 15px #9d50bb;
    }
</style>

<!-- 💫 Glassmorphism Login Card -->
<div class="glass-card">
    <h2>Login to Celebigo</h2>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" placeholder="••••••••" required>
        </div>

        <button type="submit" name="login" class="btn-login">Login</button>
    </form>
</div>

<?php include '../views/includes/footer.php'; ?>
