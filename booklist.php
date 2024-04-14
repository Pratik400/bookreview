<?php include 'navbar.php'; ?>

<?php
session_start();

// Check if success message is set and display it
if (isset($_SESSION['success_message'])) {
    echo "<div class='message success' id='successMessage'>" . $_SESSION['success_message'] . "</div>";
    unset($_SESSION['success_message']);
}
?>

<?php
require_once("dbConnection.php");

// SQL query to fetch all books
$sql = "SELECT 
            b.bookId,
            b.title AS book_title,
            AVG(r.rating) AS average_rating,
            COUNT(r.rating) AS rating_count,
            GROUP_CONCAT(DISTINCT a.authorName ORDER BY a.authorName) AS authors
        FROM 
            book b
        LEFT JOIN 
            authorship ash ON b.bookId = ash.bookId
        LEFT JOIN 
            author a ON ash.authorId = a.authorId
        LEFT JOIN 
            report r ON b.bookId = r.bookId
        GROUP BY 
            b.bookId, b.title";

$result = mysqli_query($mysqli, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($mysqli));
}
?>

<div class="container">
    <h1 class="page-header">BOOK LIST</h1>
    <section class="book-container">
        <div id="successMessage" style="display: none; color: green;">
            Book added successfully!
        </div>
        <form id="searchForm">
            <input type="text" id="searchQuery" required placeholder="Search for a Book, Book ID or Author/s ...">
            <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
        <div style="overflow-x: auto; overflow-y: hidden;">
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
</div>

<?php include 'footer.php'; ?>

<script>
    // JavaScript to handle form submission and AJAX request
    document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var searchQuery = document.getElementById('searchQuery').value.trim();

        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'search.php?query=' + encodeURIComponent(searchQuery), true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('bookTable').innerHTML = xhr.responseText;
            } else {
                console.log('Request failed. Returned status of ' + xhr.status);
            }
        };
        xhr.send();
    });


    setTimeout(function() {
        var element = document.getElementById('successMessage');
        element.style.display = 'none';
    }, 3000); // 3 seconds
</script>