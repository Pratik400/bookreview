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

// Initial SQL query to fetch all books
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

<div class="container">
    <h1 class="page-header">BOOK LIST</h1>
    <!-- Search form -->
    <section class="book-container">
        <div id="successMessage" style="display: none; color: green;">
            Book added successfully!
        </div>
        <form id="searchForm">
            <input type="text" id="searchQuery" required placeholder="Search for a book or author...">
            <button type="submit">Search</button>
        </form>
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
            <tbody id="bookTable">
                <?php
                // Displaying initial results
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
    </section>
</div>

<?php include 'footer.php'; ?>

<script>
    // JavaScript to handle form submission and AJAX request
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var searchQuery = document.getElementById('searchQuery').value.trim();

        // AJAX request to fetch search results
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'search.php?query=' + encodeURIComponent(searchQuery), true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Update book list with search results
                document.getElementById('bookTable').innerHTML = xhr.responseText;
            } else {
                console.log('Request failed. Returned status of ' + xhr.status);
            }
        };
        xhr.send();
    });
</script>