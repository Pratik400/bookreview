<?php
ob_start();
session_start();

require_once("dbConnection.php");

if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // SQL query to search for books based on title, book ID or author
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
            WHERE 
                 b.title LIKE '%$searchQuery%' OR 
                a.authorName LIKE '%$searchQuery%' OR 
                b.bookId LIKE '%$searchQuery%'
            GROUP BY 
                b.bookId, b.title";

    $result = mysqli_query($mysqli, $sql);

    if (!$result) {
        die("Error executing query: " . mysqli_error($mysqli));
    }

    // HTML for the updated book list table
    $output = '';
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= "<tr>";
            $output .= "<td>" . $row['bookId'] . "</td>";
            $output .= "<td>" . $row['book_title'] . "</td>";
            $output .= "<td>" . number_format($row['average_rating'], 1) . " <small>(" . $row['rating_count'] . ")</small>" . "</td>";
            $output .= "<td>" . $row['authors'] . "</td>";
            $output .= "<td><a href=\"bookview.php?bookId=" . $row['bookId'] . "\">View</a></td>";
            $output .= "</tr>";
        }
    } else {
        $output = "<tr><td colspan='5'>No books found</td></tr>";
    }

    // Return the HTML
    echo $output;
} else {
    echo "No search query provided";
}

ob_end_flush();
