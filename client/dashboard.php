<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    header("Location: ../auth/login.php");
    exit;
}

require '../config/database.php';

$client_id = $_SESSION['user_id'];

// Fetch all barbers
$stmt = $pdo->prepare("SELECT * FROM users WHERE role = 'barber'");
$stmt->execute();
$barbers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch favorites of the logged-in client
$favStmt = $pdo->prepare("SELECT barber_id FROM favorites WHERE client_id = ?");
$favStmt->execute([$client_id]);
$favResults = $favStmt->fetchAll(PDO::FETCH_COLUMN); // returns array of barber_id
$favBarberIds = array_flip($favResults); // flip for fast lookup

include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>


<style>
    body {
        background: linear-gradient(135deg, #0f021f, #1c0433);
        font-family: 'Outfit', sans-serif;
        color: #eee;
    }

    .page-title {
        font-size: 32px;
        font-weight: 600;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-align: center;
        margin-bottom: 40px;
    }

    .card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(14px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.25);
        color: #fff;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 40px rgba(255, 110, 196, 0.2);
    }

    .card-title {
        font-weight: 600;
        font-size: 20px;
        margin-bottom: 10px;
        color: #ffb5f5;
    }

    .card-text {
        font-size: 14px;
        color: #ccc;
    }

    ul.list-unstyled li {
        color: #ddd;
        font-size: 14px;
    }

    .btn-primary {
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        border: none;
        font-weight: 600;
        border-radius: 12px;
        width: 100%;
        margin-top: 12px;
    }

    .btn-primary:hover {
        box-shadow: 0 8px 16px rgba(255, 110, 196, 0.3);
    }

    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
        font-weight: 500;
        font-size: 14px;
        margin-top: 8px;
        width: 100%;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000;
    }
</style>
<div class="container mt-5">
    <h2>Find Your Barber</h2>
    <div class="row">
        <?php foreach ($barbers as $barber): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($barber['shop_name']) ?></h5>
                        <p class="card-text">
                            <strong>Address:</strong> <?= htmlspecialchars($barber['address']) ?><br>
                            <strong>Contact:</strong> <?= htmlspecialchars($barber['contact']) ?><br>
                        </p>

                        <!-- Services List -->
                        <h6>Services:</h6>
                        <ul class="list-unstyled">
                            <?php
                            $serviceStmt = $pdo->prepare("SELECT * FROM services WHERE barber_id = ?");
                            $serviceStmt->execute([$barber['id']]);
                            $services = $serviceStmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($services as $service):
                            ?>
                                <li>- <?= htmlspecialchars($service['service_name']) ?> (₹<?= $service['price'] ?>)</li>
                            <?php endforeach; ?>
                        </ul>

                        <!-- Favorite Toggle -->
                        <form action="../controllers/FavoriteController.php" method="POST">
                            <input type="hidden" name="barber_id" value="<?= $barber['id'] ?>">
                            <button type="submit" name="toggle_favorite" class="btn btn-outline-warning btn-sm">
                                <?= isset($favBarberIds[$barber['id']]) ? '★ Unfavorite' : '☆ Favorite' ?>
                            </button>
                        </form>

                        <!-- Book Appointment -->
                        <a href="book_appointment.php?barber_id=<?= $barber['id'] ?>" class="btn btn-primary mt-2">Book Appointment</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../views/includes/footer.php'; ?>
