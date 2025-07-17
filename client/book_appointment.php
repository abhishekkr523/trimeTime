<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    header("Location: ../auth/login.php");
    exit;
}
require '../config/database.php';

// Fetch all barbers
$barbers = $pdo->query("SELECT id, shop_name FROM users WHERE role = 'barber'")->fetchAll(PDO::FETCH_ASSOC);

// When barber is selected via dropdown, show services
$services = [];
if (isset($_GET['barber_id'])) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE barber_id = ?");
    $stmt->execute([$_GET['barber_id']]);
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>


<style>
    body {
        background: linear-gradient(135deg, #0f021f, #1a0e2d);
        font-family: 'Outfit', sans-serif;
        color: #e5e5ff;
    }

    .appointment-container {
        max-width: 720px;
        margin: 80px auto;
        padding: 40px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 0 25px rgba(255, 255, 255, 0.03);
    }

    .appointment-container h2 {
        text-align: center;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 30px;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    label {
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.05);
        color: #fff;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(120, 115, 245, 0.3);
        border-color: #7873f5;
        outline: none;
    }

    select.form-control {
        cursor: pointer;
    }

    .btn-primary {
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        border: none;
        font-size: 16px;
        font-weight: 600;
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        margin-top: 20px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(120, 115, 245, 0.3);
    }

    .mb-3 {
        margin-bottom: 24px;
    }

    .mb-4 {
        margin-bottom: 30px;
    }
</style>

<div class="appointment-container">
    <h2>Book an Appointment</h2>

    <form method="GET" class="mb-4">
        <label>Select Barber</label>
        <select name="barber_id" class="form-control" onchange="this.form.submit()">
            <option value="">-- Select Barber --</option>
            <?php foreach ($barbers as $barber): ?>
                <option value="<?= $barber['id'] ?>" <?= isset($_GET['barber_id']) && $_GET['barber_id'] == $barber['id'] ? 'selected' : '' ?>>
                    <?= $barber['shop_name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($services)): ?>
        <form action="../controllers/AppointmentController.php" method="POST">
            <input type="hidden" name="barber_id" value="<?= $_GET['barber_id'] ?>">
            <input type="hidden" name="client_id" value="<?= $_SESSION['user_id'] ?>">

            <div class="mb-3">
                <label>Choose Service</label>
                <select name="service_id" class="form-control" required>
                    <?php foreach ($services as $service): ?>
                        <option value="<?= $service['id'] ?>"><?= $service['service_name'] ?> (₹<?= $service['price'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label>Select Date</label>
                <input type="date" name="appointment_date" class="form-control" required min="<?= date('Y-m-d') ?>">
            </div>

            <div class="mb-3">
                <label>Select Time</label>
                <select name="appointment_time" class="form-control" required>
                    <?php
                    $start = strtotime('10:00');
                    $end = strtotime('19:00');
                    for ($time = $start; $time <= $end; $time += 1800):
                        $slot = date('H:i', $time);
                        echo "<option value='$slot'>$slot</option>";
                    endfor;
                    ?>
                </select>
            </div>

            <button type="submit" name="book_appointment" class="btn btn-primary">Book</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../views/includes/footer.php'; ?>