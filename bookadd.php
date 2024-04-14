<?php include 'navbar.php'; ?>



<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header("Location: bookadd.php"); 
    exit;
}

// Check if success message is set and display it
if (isset($_SESSION['success_message'])) {
    echo "<div class='message success' id='successMessage'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}


require_once("dbConnection.php");

$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $bookId = trim($_POST["bookId"]);
    $title = trim($_POST["title"]);

    if (empty($bookId) || strlen($bookId) > 4) {
        $errors[] = "Book ID must not be empty and should not exceed 4 characters.";
    }
    if (empty($title) || strlen($title) > 200) {
        $errors[] = "Title must not be empty and should not exceed 200 characters.";
    }
    if (empty($errors)) {
        $sql = "INSERT INTO book (bookId, title) VALUES ('$bookId', '$title')";

        if (mysqli_query($mysqli, $sql)) {
            $_SESSION['success_message'] = "Book added successfully.";
            header("Location: booklist.php");
            exit();
        } else {
            $errors[] = "Error: " . mysqli_error($mysqli);
        }
    }
    $_SESSION['errors'] = $errors;
    header("Location: bookadd.php");
    exit();
}
?>


<div class="container">
    <?php

    if (!empty($errors)) {
        echo "<div style='color: red;'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    } elseif (isset($_GET["success"]) && $_GET["success"] === "true") {
        echo "<p class='message success' id='successMessage'>Book added successfully.</p>";
    }
    ?>

    <div class="book-add-container">
        <h2 class="page-header">Add Book</h2>

        <form class="form" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="bookId">Book ID:</label> <br>
            <input type="text" id="bookId" name="bookId" maxlength="4" style="width: 200px;" required>
            <br>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" maxlength="200" required>

            <button class="btn" type="submit" name="submit">Submit</button>
            <button class="rst" type="reset" name="reset">Reset</button>
        </form>
    </div>
</div>

<script>
    setTimeout(function() {
        var element = document.getElementById('successMessage');
        element.style.display = 'none';
    }, 3000);
</script>

<?php include 'footer.php'; ?>