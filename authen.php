<?php
// Start session
session_start();

// Predefined username and password
$expected_username = "wt";
$expected_password = "cdms";

// Check if user is already logged in
if (!isset($_SESSION['logged_in'])) {
    // Check if form is submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validate credentials
        if ($username === $expected_username && $password === $expected_password) {
            // Set session variable to mark user as logged in
            $_SESSION['logged_in'] = true;
            // Redirect user to the desired page
            header("Location: bookadd.php");
            exit;
        } else {
            // Credentials are incorrect, show alert
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
} else {
    // User is already logged in, redirect to the desired page
    header("Location: bookadd.php");
    exit;
}
?>

<?php include 'navbar.php'; ?>
<div class="container">
    <div class="login-contaienr">
        <h2 class="page-header">LOGIN</h2>
        <form class="form" method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="button"> Login</button>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>