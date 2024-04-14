<?php
// Start session
session_start();

require_once("dbConnection.php");


if (!isset($_SESSION['logged_in'])) {
    // Check if form is submitted
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) { 
                $_SESSION['logged_in'] = true;
                $_SESSION['success_message'] = "Login Successful.";
                header("Location: bookadd.php");
                exit;
            } else {
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
} else {
    header("Location: bookadd.php");
    exit;
}
$mysqli->close();


?>

<?php include 'navbar.php'; ?>
<div class="container">
    <div class="login-contaienr">
        <h2 class="page-header">LOGIN</h2>

        <form class="form" method="post">
            <small>Please Login to Add a book</small>
            <br>
            <br>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" class="button"> Login</button>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>