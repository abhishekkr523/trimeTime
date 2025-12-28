<?php
include_once __DIR__ . '/../controllers/AppointmentController.php';
include_once __DIR__ . '/../controllers/AppointmentController.php';
include_once __DIR__ . '/../controllers/AppointmentController.php';
?>

<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'barber') {
    header("Location: ../auth/login.php");
    exit;
}

require '../config/database.php';

$barber_id = $_SESSION['user_id'];

// Fetch appointments for this barber
$stmt = $pdo->prepare("
    SELECT a.*, s.service_name, s.price, u.name AS client_name
    FROM appointments a
    JOIN services s ON a.service_id = s.id
    JOIN users u ON a.client_id = u.id
    WHERE a.barber_id = ?
    ORDER BY a.appointment_date ASC, a.appointment_time ASC
");
$stmt->execute([$barber_id]);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

include '../views/includes/header.php';
include '../views/includes/navbar.php';
?>

<style>
    body {
        background: linear-gradient(145deg, #0f021f, #1c0433);
        font-family: 'Outfit', sans-serif;
        color: #e4e4ff;
    }

    .appointment-container {
        max-width: 1100px;
        margin: 80px auto;
        background: rgba(255, 255, 255, 0.04);
        padding: 40px;
        border-radius: 20px;
        backdrop-filter: blur(14px);
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .appointment-container h2 {
        text-align: center;
        font-weight: 600;
        font-size: 28px;
        margin-bottom: 30px;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .table {
        background: rgba(255, 255, 255, 0.03);
        color: #fff;
        border-radius: 10px;
        overflow: hidden;
    }

    .table th {
        background: rgba(255, 255, 255, 0.08);
        color: #dcdcff;
        font-weight: 500;
    }

    .table td {
        vertical-align: middle;
        font-size: 15px;
    }

    .badge {
        font-size: 13px;
        padding: 6px 12px;
        border-radius: 12px;
    }

    .btn-sm {
        font-size: 13px;
        border-radius: 10px;
        padding: 6px 12px;
        font-weight: 500;
    }

    .btn-success {
        background: linear-gradient(135deg, #00ffcc, #33cc99);
        border: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #ff5e7e, #ff3f3f);
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6c5ce7, #a29bfe);
        border: none;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
    }

    .table thead th,
    .table-bordered > :not(caption) > * > * {
        border-color: rgba(255, 255, 255, 0.1);
    }
</style>
<div class="appointment-container">
    <h2>Appointment Requests</h2>

    <?php if (count($appointments) > 0): ?>
        <div class="table-responsive mt-4">
            <table class="table table-bordered text-white">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?= htmlspecialchars($appointment['client_name']) ?></td>
                            <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                            <td><?= date('d M Y', strtotime($appointment['appointment_date'])) ?></td>
                            <td><?= date('h:i A', strtotime($appointment['appointment_time'])) ?></td>
                            <td>₹<?= number_format($appointment['price'], 2) ?></td>
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
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                        <button name="approve_appointment" class="btn btn-sm btn-success" onclick="return confirm('Approve this appointment?');">Approve</button>
                                    </form>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                        <button name="cancel_appointment_by_barber" class="btn btn-sm btn-danger" onclick="return confirm('Cancel this appointment?');">Cancel</button>
                                    </form>
                                <?php elseif ($appointment['status'] === 'approved'): ?>
                                    <form action="" method="POST" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?= $appointment['id'] ?>">
                                        <button name="complete_appointment" class="btn btn-sm btn-primary" onclick="return confirm('Mark this appointment as completed?');">Complete</button>
                                    </form>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center mt-4">No appointment requests yet.</p>
    <?php endif; ?>
</div>

<?php include '../views/includes/footer.php'; ?>
