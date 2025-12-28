<?php
session_start();
?>

<?php include 'views/includes/header.php'; ?>
<?php include 'views/includes/navbar.php'; ?>
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .hero {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        text-align: center;
        padding: 20px;
        background-size: cover;
        background-position: center;
        transition: background-image 1s ease-in-out;
        position: relative;
    }

    /* overlay to make text readable */
    .hero::after {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.5rem;
    }

    .btn-custom {
        min-width: 120px;
    }

    @media (max-width: 768px) {
        .hero h1 { font-size: 2.2rem; }
        .hero p { font-size: 1.2rem; }
    }
</style>

<div class="hero" id="hero">
    <div class="hero-content">
        <h1 class="display-5">Welcome to TrimTime</h1>
        <p class="lead">Book your haircut at your convenience, avoid the queue!</p>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
                <a href="auth/register.php" class="btn btn-primary btn-custom">Sign Up</a>
                <a href="auth/login.php" class="btn btn-outline-success btn-custom">Login</a>
            </div>
        <?php else: ?>
            <div class="mt-4">
                <p>You are logged in as <strong><?= $_SESSION['user_name']; ?></strong></p>
                <a href="<?= ($_SESSION['user_role'] === 'barber') ? 'barber/dashboard.php' : 'client/dashboard.php'; ?>" class="btn btn-success btn-custom">Go to Dashboard</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    const hero = document.getElementById('hero');

    // List of random background images from the internet
    const backgrounds = [
        'https://source.unsplash.com/1600x900/?barber,hairstyle',
        'https://source.unsplash.com/1600x900/?haircut,style',
        'https://source.unsplash.com/1600x900/?salon,barber',
        'https://source.unsplash.com/1600x900/?men,haircut',
        'https://source.unsplash.com/1600x900/?women,haircut'
    ];

    function changeBackground() {
        const randomIndex = Math.floor(Math.random() * backgrounds.length);
        hero.style.backgroundImage = `url('${backgrounds[randomIndex]}')`;
    }

    // Initial background
    changeBackground();

    // Change background every 10 seconds
    setInterval(changeBackground, 10000);
</script>

<?php include 'views/includes/footer.php'; ?>
