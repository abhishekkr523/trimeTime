<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'barber') {
    header("Location: ../auth/login.php");
    exit;
}

require '../config/database.php';

$barber_id = $_SESSION['user_id'];

// Fetch services
$stmt = $pdo->prepare("SELECT * FROM services WHERE barber_id = ?");
$stmt->execute([$barber_id]);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>


<style>
    body {
        background: linear-gradient(145deg, #0f021f, #1c0433);
        font-family: 'Outfit', sans-serif;
        color: #e0e0ff;
    }

    .services-container {
        max-width: 900px;
        margin: 80px auto;
        background: rgba(255, 255, 255, 0.04);
        backdrop-filter: blur(14px);
        -webkit-backdrop-filter: blur(14px);
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 0 40px rgba(0, 0, 0, 0.25);
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .services-container h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        font-size: 28px;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .form-control {
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        padding: 10px 14px;
        font-size: 15px;
    }

    .form-control:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(255, 110, 196, 0.3);
        border-color: #ff6ec4;
    }

    .btn-success, .btn-primary, .btn-danger {
        border: none;
        padding: 10px 18px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        color: #fff;
        transition: 0.3s ease;
    }

    .btn-success {
        background: linear-gradient(to right, #00d2ff, #3a7bd5);
    }

    .btn-primary {
        background: linear-gradient(to right, #7873f5, #a26af8);
    }

    .btn-danger {
        background: linear-gradient(to right, #ff416c, #ff4b2b);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
    }

    .table {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        overflow: hidden;
        color: #fff;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .table th {
        background-color: rgba(255, 255, 255, 0.06);
        color: #e0e0ff;
        font-weight: 500;
    }

    .form-inline-group {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }

    .form-inline-group .form-control {
        flex: 1;
        min-width: 150px;
    }
</style>


<div class="services-container">
    <h2>My Services</h2>

    <!-- Add Service Form -->
    <form action="../controllers/BarberServiceController.php" method="POST" class="form-inline-group">
        <input type="hidden" name="barber_id" value="<?= $barber_id ?>">
        <input type="text" name="service_name" placeholder="Service Name" required class="form-control">
        <input type="number" step="0.01" name="price" placeholder="Price (₹)" required class="form-control">
        <button type="submit" name="add_service" class="btn btn-success">Add</button>
    </form>

    <!-- List Services -->
    <table class="table table-bordered text-white mt-4">
        <thead>
            <tr>
                <th>Service</th>
                <th>Price (₹)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($services as $service): ?>
                <tr>
                    <td><?= htmlspecialchars($service['service_name']) ?></td>
                    <td><?= number_format($service['price'], 2) ?></td>
                    <td>
                        <!-- Update Form -->
                        <form action="../controllers/BarberServiceController.php" method="POST" class="form-inline-group mb-2">
                            <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                            <input type="text" name="service_name" value="<?= $service['service_name'] ?>" class="form-control" required>
                            <input type="number" step="0.01" name="price" value="<?= $service['price'] ?>" class="form-control" required>
                            <button type="submit" name="update_service" class="btn btn-primary btn-sm">Update</button>
                        </form>

                        <!-- Delete Form -->
                        <form action="../controllers/BarberServiceController.php" method="POST" onsubmit="return confirm('Delete this service?')" class="d-inline">
                            <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                            <button type="submit" name="delete_service" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php include '../views/includes/footer.php'; ?>
