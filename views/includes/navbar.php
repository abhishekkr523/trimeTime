<?php
require_once __DIR__ . '/../../config/constants.php';

?>

<!-- Font + Optional Icon CDN -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600&display=swap" rel="stylesheet">

<style>
    .custom-navbar {
      width: 100%;
        background: linear-gradient(120deg, #1e0033, #2b004d);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        font-family: 'Outfit', sans-serif;
        padding: 12px 30px;
    }

    .navbar-brand {
        font-weight: 600;
        font-size: 24px;
        color: #ffffff;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .navbar-nav .nav-link {
        color: #e0dfff;
        margin-left: 18px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        color: #ff7ce5;
    }

    .navbar-toggler {
        border-color: #aaa;
    }

    .navbar-toggler-icon {
        filter: brightness(0) invert(1);
    }

    @media (max-width: 768px) {
        .navbar-nav .nav-link {
            margin-left: 0;
            margin-bottom: 12px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= BASE_URL ?>/index.php">TrimTime</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto align-items-lg-center text-center">
        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'barber'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/barber/dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/barber/profile.php">My Profile</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/barber/services.php">My Services</a></li>

          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/barber/appointments.php">Appointments</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/logout.php">Logout</a></li>

        <?php elseif (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'client'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/client/book_appointment.php">Book Appointment</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/client/appointments.php">My Appointments</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/logout.php">Logout</a></li>

        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/login.php">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/auth/register.php">Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
