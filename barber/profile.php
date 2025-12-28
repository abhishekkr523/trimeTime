<?php
include_once __DIR__ . '/../controllers/BarberController.php';
?>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'barber') {
    header("Location: ../auth/login.php");
    exit;
}
require '../config/database.php';

$user_id = $_SESSION['user_id'];

// Fetch current barber profile
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$barber = $stmt->fetch(PDO::FETCH_ASSOC);

include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>


<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">

<style>
    body {
        background: linear-gradient(145deg, #0f021f, #1c0433);
        font-family: 'Outfit', sans-serif;
        color: #e2e2ff;
    }

    .profile-container {
        max-width: 700px;
        margin: 80px auto;
        background: rgba(255, 255, 255, 0.04);
        padding: 40px;
        border-radius: 20px;
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .profile-container h2 {
        text-align: center;
        font-weight: 600;
        font-size: 28px;
        margin-bottom: 30px;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-label {
        font-weight: 500;
        margin-bottom: 6px;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: #fff;
        border-radius: 10px;
        padding: 12px;
        font-size: 15px;
    }

    .form-control::placeholder {
        color: #ccc;
    }

    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 110, 196, 0.3);
        border-color: #ff6ec4;
    }

    .btn-primary {
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 16px;
        border-radius: 12px;
        width: 100%;
        margin-top: 20px;
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 110, 196, 0.3);
    }

    img.profile-preview {
        border-radius: 12px;
        margin-bottom: 12px;
        border: 2px solid #7873f5;
    }
</style>

<div class="profile-container">
    <h2>Barber Profile Setup</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="barber_id" value="<?= $user_id ?>">

        <div class="mb-3">
            <label class="form-label">Shop Name</label>
            <input type="text" class="form-control" name="shop_name" value="<?= htmlspecialchars($barber['shop_name']) ?>" placeholder="Your shop name...">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="3" placeholder="Enter shop address..."><?= htmlspecialchars($barber['address']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" name="contact_number" value="<?= htmlspecialchars($barber['contact_number']) ?>" placeholder="e.g. +91 9876543210">
        </div>

        <div class="mb-3">
            <label class="form-label">Opening Hours</label>
            <input type="text" class="form-control" name="opening_hours" value="<?= htmlspecialchars($barber['opening_hours']) ?>" placeholder="e.g. 10 AM - 8 PM">
        </div>

        <div class="mb-3">
            <label class="form-label">Price Range</label>
            <input type="text" class="form-control" name="price_range" value="<?= htmlspecialchars($barber['price_range']) ?>" placeholder="e.g. ₹200 - ₹500">
        </div>

        <div class="mb-3">
            <label class="form-label">Profile Image</label>
            <?php if (!empty($barber['profile_image'])): ?>
                <div><img src="../uploads/<?= $barber['profile_image'] ?>" width="120" class="profile-preview"></div>
            <?php endif; ?>
            <input type="file" class="form-control" name="profile_image">
        </div>

        <button type="submit" name="update_profile" class="btn btn-primary">Save Profile</button>
    </form>
</div>


<?php include '../views/includes/footer.php'; ?>
