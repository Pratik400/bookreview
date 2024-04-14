<footer>
    <div class="container">
        <p class="">
            <a href="#">Back to top</a>
        </p>

        <?php
        // session_start();
        if (isset($_POST['logout'])) {
            session_unset();
            session_destroy();
            echo "<script>window.location.href = 'authen.php';</script>";
            exit;
        }
        ?>

        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) : ?>
            <form method="post" style="display: inline;">
                <button type="submit" name="logout" class="button">Logout</button>
            </form>
        <?php endif; ?>

    </div>
</footer>

<script src="scripts.js"></script>

</body>

</html>