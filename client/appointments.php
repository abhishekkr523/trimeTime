<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'client') {
    header("Location: ../auth/login.php");
    exit;
}

require '../config/database.php';

$client_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT a.*, s.service_name, s.price, b.shop_name, b.address, b.contact_number
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN users b ON a.barber_id = b.id
    WHERE a.client_id = ?
    ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$stmt->execute([$client_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>


<style>
    body {
        background: linear-gradient(135deg, #0f021f, #1c0433);
        color: #e2e2ff;
        font-family: 'Outfit', sans-serif;
    }

    .container {
        margin-top: 80px;
    }

    h2 {
        text-align: center;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 600;
        margin-bottom: 30px;
    }

    table {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 15px;
        overflow: hidden;
        color: #e2e2ff;
    }

    table th, table td {
        vertical-align: middle !important;
        background: transparent;
        padding: 15px;
        border-color: rgba(255, 255, 255, 0.08);
    }

    table th {
        color: #b4b4ff;
        font-weight: 600;
        font-size: 14px;
    }

    .badge {
        padding: 8px 12px;
        font-size: 13px;
        border-radius: 20px;
        font-weight: 500;
        text-transform: capitalize;
    }

    .btn-danger {
        background: #ff4e70;
        border: none;
        padding: 6px 14px;
        font-size: 13px;
        border-radius: 8px;
        transition: 0.2s ease;
    }

    .btn-danger:hover {
        background: #ff6c8c;
        transform: scale(1.03);
    }

    .table-responsive {
        border-radius: 15px;
        overflow: auto;
    }

    p {
        text-align: center;
        color: #aaaaff;
        margin-top: 30px;
    }
</style>
<div class="container">
    <h2>My Appointments</h2>

    <?php if (count($appointments) > 0): ?>
        <div class="table-responsive">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th>Barber</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price (₹)</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($appointment['shop_name']) ?><br>
                                <small><?= htmlspecialchars($appointment['contact_number']) ?></small><br>
                                <small><?= htmlspecialchars($appointment['address']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                            <td><?= date('d M Y', strtotime($appointment['appointment_date'])) ?></td>
                            <td><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
                            <td><?= number_format($appointment['price'], 2) ?></td>
                            <td>
                                <span class="badge bg-<?= match($appointment['status']) {
                                    'pending' => 'warning',
                                    'approved' => 'success',
                                    'completed' => 'primary',
                                    'cancelled' => 'secondary',
                                    default => 'light'
                                } ?>">
                                    <?= ucfirst($appointment['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($appointment['status'] === 'pending'): ?>
                                    <form method="POST" action="../controllers/AppointmentController.php" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                        <button type="submit" name="cancel_appointment" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                            Cancel
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>You have not booked any appointments yet.</p>
    <?php endif; ?>
</div>

<?php include '../views/includes/footer.php'; ?>
