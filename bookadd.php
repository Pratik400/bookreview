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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $bookId = trim($_POST["bookId"]);
    $title = trim($_POST["title"]);
    $authorNames = $_POST["authorName"];
    echo "<p>bookId = $bookId</p>";
    echo "<p>title = $title</p>";

    // Check for errors
    $errors = array();
    if (empty($bookId) || strlen($bookId) > 4) {
        $errors[] = "Book ID must not be empty and should not exceed 4 characters.";
    }
    if (empty($title) || strlen($title) > 200) {
        $errors[] = "Title must not be empty and should not exceed 200 characters.";
    }

    if (empty($errors)) {
        // Insert into book table
        $insertBookSql = "INSERT INTO book (bookId, title) VALUES ('$bookId', '$title')";

        if (mysqli_query($mysqli, $insertBookSql)) {
            $lastBookId = trim($_POST["bookId"]);
            echo "<p>lastBookId = $lastBookId</p>";

            // Insert authors into author table
            foreach ($authorNames as $authorName) {
                $authorId = mysqli_real_escape_string($mysqli, md5(uniqid())); // Generate unique ID for author
                $escapedAuthorName = mysqli_real_escape_string($mysqli, $authorName);
                $insertAuthorSql = "INSERT INTO author (authorId, authorName) VALUES ('$authorId', '$escapedAuthorName')";
                if (mysqli_query($mysqli, $insertAuthorSql)) {
                } else {
                    $errors[] = "Error inserting author: " . mysqli_error($mysqli);
                }
            }

            // Now that book is inserted, insert mapping into authorship table
            foreach ($authorNames as $authorName) {
                $selectAuthorIdSql = "SELECT authorId FROM author WHERE authorName = '$authorName'";
                $selectAuthorIdResult = mysqli_query($mysqli, $selectAuthorIdSql);
                echo "<p>selectAuthorIdSql = $selectAuthorIdSql</p>";
                if ($selectAuthorIdResult) {
                    $authorIdRow = mysqli_fetch_assoc($selectAuthorIdResult);
                    $authorId = $authorIdRow['authorId'];
                    $insertAuthorshipSql = "INSERT INTO authorship (bookId, authorId) VALUES ('$lastBookId', '$authorId')";
                    mysqli_query($mysqli, $insertAuthorshipSql);
                } else {
                    $errors[] = "Error selecting authorId: " . mysqli_error($mysqli);
                }
            }

            $_SESSION['success_message'] = "Book added successfully.";
            header("Location: booklist.php");
            exit();
        } else {
            $errors[] = "Error inserting book: " . mysqli_error($mysqli);
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

            <div id="authorFields">
                <div class="author-field">
                    <label for="authorName">Author Name:</label>
                    <input type="text" name="authorName[]" maxlength="100" required>
                    <button type="button" class="remove-author" title="Add an Author for this book"> <i class="fa fa-trash"></i></button>
                </div>
            </div>
            <button type="button" id="addAuthor" class="add-author" title="Add an Author for this book"> <i class="fa fa-plus"></i> Add Author</button><br>
            <button class="btn" type="submit" name="submit">Submit</button>
            <button class="rst" type="reset" name="reset">Reset</button>
        </form>
    </div>
</div>





<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addAuthor').addEventListener('click', function() {
            var authorFields = document.getElementById('authorFields');
            var authorField = document.createElement('div');
            authorField.classList.add('author-field');
            authorField.innerHTML = `
                <label for="authorName">Author Name:</label>
                <input type="text" name="authorName[]" maxlength="100" required>
                <button type="button" class="remove-author" title="Add an Author for this book"> <i class="fa fa-trash"></i></button>`;
            authorFields.appendChild(authorField);
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-author')) {
                event.target.parentNode.remove();
            }
        });
    });
</script>

<script>
    setTimeout(function() {
        var element = document.getElementById('successMessage');
        element.style.display = 'none';
    }, 3000);
</script>

<?php include 'footer.php'; ?>