<style>
    .custom-footer {
        width: 100%;
        background: rgba(255, 255, 255, 0.02);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: #dcdcff;
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        padding: 20px 0;
        position: relative;
        z-index: 10;
        text-align: center;
    }

    .custom-footer p {
        margin: 0;
        background: linear-gradient(to right, #ff6ec4, #7873f5);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
</style>

<footer class="custom-footer">
    <p>&copy; <?= date('Y') ?> TrimTime. All rights reserved.</p>
</footer>

<!-- Bootstrap JS (optional if not already loaded) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
