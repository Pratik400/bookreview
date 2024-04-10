<?php include 'navbar.php'; ?>

<?php
// Start the session
session_start();

// Check if success message is set and display it
if (isset($_SESSION['success_message'])) {
    echo "<div style='color: green;'>" . $_SESSION['success_message'] . "</div>";
    // Unset the session variable to clear the message
    unset($_SESSION['success_message']);
}
?>

<?php
require_once("dbConnection.php");

$sql = "SELECT 
            b.bookId,
            b.title AS book_title,
            AVG(r.rating) AS average_rating,
            COUNT(r.rating) AS rating_count,
            GROUP_CONCAT(DISTINCT a.authorName ORDER BY a.authorName) AS authors
        FROM 
            Book b
        LEFT JOIN 
            Authorship ash ON b.bookId = ash.bookId
        LEFT JOIN 
            Author a ON ash.authorId = a.authorId
        LEFT JOIN 
            Report r ON b.bookId = r.bookId
        GROUP BY 
            b.bookId, b.title";

$result = mysqli_query($mysqli, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($mysqli));
}
?>

<section class="book-container">


    <div id="successMessage" style="display: none; color: green;">
        Book added successfully!
    </div>


    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Rating</th>
                    <th>Authors</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Assuming $mysqli is your database connection and $result contains the fetched data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['bookId'] . "</td>";
                    echo "<td>" . $row['book_title'] . "</td>";
                    echo "<td>" . number_format($row['average_rating'], 1) . " <small>(" . $row['rating_count']   . ")</small>"  . "</td>";
                    echo "<td>" . $row['authors'] . "</td>";
                    echo "<td><a href=\"bookview.php?bookId=" . $row['bookId'] . "\">View</a></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

    </div>
</section>

<?php include 'footer.php'; ?>