<footer>
    <div class="container">
        <p class="">
            <a href="#">Back to top</a>
        </p>

        <?php
        // Start session
        // session_start();

        // Check if user is logged in
        if (isset($_SESSION['logged_in'])) {
            // User is logged in, display logout button
            echo '<form method="post">
            <button type="submit" name="logout">Logout</button>
          </form>';
        }

        // Logout logic
        if (isset($_POST['logout'])) {
            // Destroy the session
            session_destroy();
            // Redirect to login page or any other page
            header("Location: index.php");
            exit;
        }
        ?>

    </div>
</footer>

<script src="scripts.js"></script>

</body>

</html>