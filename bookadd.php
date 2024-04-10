<?php include 'navbar.php'; ?>



<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    // User is not logged in, redirect to login page
    header("Location: bookadd.php"); // Redirect to your login page
    exit;
}

// Include the database connection file
require_once("dbConnection.php");

$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    // Collect form data
    $bookId = trim($_POST["bookId"]);
    $title = trim($_POST["title"]);

    // Validate book ID
    if (empty($bookId) || strlen($bookId) > 4) {
        $errors[] = "Book ID must not be empty and should not exceed 4 characters.";
    }

    // Validate title
    if (empty($title) || strlen($title) > 200) {
        $errors[] = "Title must not be empty and should not exceed 200 characters.";
    }

    // If there are no validation errors, proceed to insert into the database
    if (empty($errors)) {
        // SQL query to insert book details into the database
        $sql = "INSERT INTO Book (bookId, title) VALUES ('$bookId', '$title')";

        // Execute the query
        if (mysqli_query($mysqli, $sql)) {
            // Set success message in session variable
            $_SESSION['success_message'] = "Book added successfully.";
            // Redirect to the booklist.php page to avoid resubmission
            header("Location: booklist.php");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($mysqli);
        }
    }

    // Set error messages in session variable
    $_SESSION['errors'] = $errors;

    // Redirect back to the add_book.php page to display errors
    header("Location: bookadd.php");
    exit();
}
?>


<div class="container">
    <h2>Add Book</h2>
    <?php
    // Display validation errors, if any
    if (!empty($errors)) {
        echo "<div style='color: red;'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    } elseif (isset($_GET["success"]) && $_GET["success"] === "true") {
        echo "<p style='color: green;'>Book added successfully.</p>";
    }
    ?>

    <form method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="bookId">Book ID:</label>
        <input type="text" id="bookId" name="bookId" maxlength="4"><br><br>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" maxlength="200"><br><br>

        <button type="submit" name="submit">Submit</button>
    </form>
</div>

<?php include 'footer.php'; ?>