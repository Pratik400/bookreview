<?php include 'navbar.php'; ?>
<?php
// Include the database connection file
require_once("dbConnection.php");
$bookId = $_GET['bookId'];

// Book details query
$sqlBook = "SELECT 
                b.bookId,
                b.title AS book_title,
                AVG(r.rating) AS average_rating,
                COUNT(r.rating) AS rating_count
            FROM 
                book b
            LEFT JOIN 
                report r ON b.bookId = r.bookId
            WHERE 
                b.bookId = '$bookId'
            GROUP BY 
                b.bookId, b.title";

// Execute the query to fetch book details
$resultBook = mysqli_query($mysqli, $sqlBook);

// Check for errors
if (!$resultBook) {
    die("Error executing book query: " . mysqli_error($mysqli));
}

// Fetch the book details
if (mysqli_num_rows($resultBook) > 0) {
    $rowBook = mysqli_fetch_assoc($resultBook);
    $bookId = $rowBook['bookId'];
    $bookTitle = $rowBook['book_title'];
    $averageRating = number_format($rowBook['average_rating'], 1);
    $ratingCount = $rowBook['rating_count'];
} else {
    die("No book found for the specified book ID.");
}

// Authors query
$sqlAuthors = "SELECT DISTINCT a.authorName
                FROM authorship ash
                INNER JOIN author a ON ash.authorId = a.authorId
                WHERE ash.bookId = '$bookId'";

// Execute the query to fetch distinct authors
$resultAuthors = mysqli_query($mysqli, $sqlAuthors);

// Check for errors
if (!$resultAuthors) {
    die("Error executing authors query: " . mysqli_error($mysqli));
}

// Reviewers query
$sqlReviewers = "SELECT rv.reviewerName, r.rating
                FROM report r
                INNER JOIN reviewer rv ON r.reviewerId = rv.reviewerId
                WHERE r.bookId = '$bookId'";

// Execute the query to fetch reviewers and their ratings
$resultReviewers = mysqli_query($mysqli, $sqlReviewers);

// Check for errors
if (!$resultReviewers) {
    die("Error executing reviewers query: " . mysqli_error($mysqli));
}
?>

<div class="container">



    <div class="bookmark"><a href="/booklist.php">Books</a> <i class="fa-solid fa-chevron-right"></i> <span><?php echo $bookId; ?></span> <i class="fa-solid fa-chevron-right"></i> <span><?php echo $bookTitle; ?></span> </div>
    <section class="book-view-container">
        <div class="book-img">
            <img src="assets/img/bookplaceholder.jpg" alt="">
        </div>
        <div class="book-details">
            <p><?php echo $bookId; ?></p>
            <p><?php echo $bookTitle; ?>

            <section class="author-container">
                <span>By:</span>
                <?php
                // Check if authors found
                if (mysqli_num_rows($resultAuthors) > 0) {
                    // Output authors
                    while ($rowAuthor = mysqli_fetch_assoc($resultAuthors)) {
                        echo "<span>" . $rowAuthor['authorName'] . ", </span>";
                    }
                } else {
                    echo "<span>No authors found for the book.</span>";
                }
                ?>
            </section>
            </p>

            <p><strong><i class="fa-solid fa-star "></i></strong> <?php echo $averageRating; ?><small> (<?php echo $ratingCount; ?>)</small></p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident facere culpa et corrupti, corporis eum necessitatibus quisquam, earum magni aliquam molestias deserunt, suscipit ea architecto repellat. Ea dolorum harum at! Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident facere culpa et corrupti, corporis eum necessitatibus quisquam, earum magni aliquam molestias deserunt, suscipit ea architecto repellat. Ea dolorum harum at! </p>
        </div>
    </section>

    <section class="reviewer-container">
        <h2>Reviews</h2>

        <?php
        // Check if reviewers found
        if (mysqli_num_rows($resultReviewers) > 0) {
            // Output reviewers and their ratings
            while ($rowReviewer = mysqli_fetch_assoc($resultReviewers)) {
                echo "<div class='reviewer'>";
                echo " <img src='assets/img/reviewerplaceholder.jpg' alt=''> ";
                echo "<div><p>" . $rowReviewer['reviewerName'] . "</p>";
                echo "<p><i class='fa-solid fa-star '></i>" . $rowReviewer['rating'] . "/5</p>";
                echo "</div></div>";
            }
        } else {
            echo "<p>No reviewers found for the book.</p>";
        }
        ?>

    </section>

    <div class="bookmark"><a href="#" onclick="goBack()"> Back to List</a></div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</div>

<?php include 'footer.php'; ?>