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
                Book b
            LEFT JOIN 
                Report r ON b.bookId = r.bookId
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
                FROM Authorship ash
                INNER JOIN Author a ON ash.authorId = a.authorId
                WHERE ash.bookId = '$bookId'";

// Execute the query to fetch distinct authors
$resultAuthors = mysqli_query($mysqli, $sqlAuthors);

// Check for errors
if (!$resultAuthors) {
    die("Error executing authors query: " . mysqli_error($mysqli));
}

// Reviewers query
$sqlReviewers = "SELECT rv.reviewerName, r.rating
                FROM Report r
                INNER JOIN Reviewer rv ON r.reviewerId = rv.reviewerId
                WHERE r.bookId = '$bookId'";

// Execute the query to fetch reviewers and their ratings
$resultReviewers = mysqli_query($mysqli, $sqlReviewers);

// Check for errors
if (!$resultReviewers) {
    die("Error executing reviewers query: " . mysqli_error($mysqli));
}
?>

<!-- HTML section to display book details -->
<section class="book-container">
    <div class="container">
        <div class="book-details">
            <p><strong>Book ID:</strong> <?php echo $bookId; ?></p>
            <p><strong>Title:</strong> <?php echo $bookTitle; ?></p>
            <p><strong>Average Rating:</strong> <?php echo $averageRating; ?></p>
            <p><strong>Rating Count:</strong> <?php echo $ratingCount; ?></p>
        </div>
    </div>
</section>
<!-- HTML section to display authors -->
<section class="author-container">
    <div class="container">
        <h2>Authors:</h2>
        <?php
        // Check if authors found
        if (mysqli_num_rows($resultAuthors) > 0) {
            // Output authors
            while ($rowAuthor = mysqli_fetch_assoc($resultAuthors)) {
                echo "<p>" . $rowAuthor['authorName'] . "</p>";
            }
        } else {
            echo "<p>No authors found for the book.</p>";
        }
        ?>
    </div>
</section>

<!-- HTML section to display reviewers and their ratings -->
<section class="reviewer-container">
    <div class="container">
        <h2>Reviewers and their Ratings:</h2>
        <?php
        // Check if reviewers found
        if (mysqli_num_rows($resultReviewers) > 0) {
            // Output reviewers and their ratings
            while ($rowReviewer = mysqli_fetch_assoc($resultReviewers)) {
                echo "<p><strong>Reviewer Name:</strong> " . $rowReviewer['reviewerName'] . "</p>";
                echo "<p><strong>Rating:</strong> " . $rowReviewer['rating'] . "</p>";
            }
        } else {
            echo "<p>No reviewers found for the book.</p>";
        }
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>