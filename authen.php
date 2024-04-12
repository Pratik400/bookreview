<?php
// Start session
session_start();

require_once("dbConnection.php");


if (!isset($_SESSION['logged_in'])) {
    // Check if form is submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get username and password from the form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare a statement to select user from the database
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists and password is correct
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) { // Assuming passwords are stored securely hashed
                // Set session variable to mark user as logged in
                $_SESSION['logged_in'] = true;
                // Redirect user to the desired page
                header("Location: bookadd.php");
                exit;
            } else {
                // Password is incorrect, show alert
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            // Username not found, show alert
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
} else {
    // User is already logged in, redirect to the desired page
    header("Location: bookadd.php");
    exit;
}

// Close connection
$mysqli->close();


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