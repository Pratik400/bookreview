<?php include 'navbar.php'; ?>

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
                b.bookId, b.title
                LIMIT 4";

$result = mysqli_query($mysqli, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($mysqli));
}

// Query to get the most rated books
$sql2 = "SELECT 
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
                b.bookId, b.title
            ORDER BY 
                COUNT(r.rating) DESC
            LIMIT 4";

$result2 = mysqli_query($mysqli, $sql2);
if (!$result2) {
    die("Error executing query: " . mysqli_error($mysqli));
}
?>


<section class="intro-section container-fluid" style="background-size: cover ;background-image: url(https://static.showit.co/800/GLLklpZ0SmmwLHf12R1S-g/shared/holographic_background.jpg)">
    <div class="intro-body">
        <img src="https://d3iqwsql9z4qvn.cloudfront.net/wp-content/uploads/2023/02/27124632/audiobook-and-hardcover-web.png" alt="">
        <div class="">
            <p class="">SPECIAL PRICE</p>
            <p class="">The Lord of the Rings</p>
            <p class="">J.R.R. Tolkien</p>
            <p class="">$9.89</p>
            <div class="btn-main">RELEASING SOON</div>
        </div>
    </div>
</section>

<section class="featured-books">
    <div class="container">
        <h1>Our Best Rated Books</h1>
        <div class="custom-row">
            <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
                <div class="book-col">
                    <div class="book-card">
                        <?php if (!empty($row['image_src'])) : ?>
                            <img class="book-card-img" src="<?php echo $row['image_src']; ?>" alt="Book Cover">
                        <?php else : ?>
                            <img class="book-card-img" src="https://voice.global/wp-content/plugins/wbb-publications/public/assets/img/placeholder.jpg" alt="Book Cover">
                        <?php endif; ?>
                        <div class="book-card-body">
                            <h4 title="<?php echo $row['book_title']; ?>"><?php echo $row['book_title']; ?></h4>
                            <p><?php echo number_format($row['average_rating'], 1); ?><small>(<?php echo $row['rating_count']; ?>)</small> <?php echo $row['authors']; ?> </p>
                            <a href="/bookview.php?bookId=<?php echo $row['bookId']; ?>" class="btn-main">SEE MORE</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php mysqli_free_result($result2); ?>
        </div>
</section>

<section class="featured-categories">
    <div class="container">
        <div class="custom-row">
            <div class="category-col">
                <div class="category-card">
                    <img src="https://covers.bookcoverzone.com/slir/w450/png24-front/bookcover0020424.jpg" alt="">
                    <div class="category-card-info">
                        <h3>SCI-FI & FANTASY</h3>
                        <ul class="">
                            <li class=""><a href=".">Historical Sci-Fi</a></li>
                            <li class=""> <a href=".">History</a></li>
                            <li class=""><a href=".">Kid's Sci-Fi & Fantasy</a> </li>
                            <li class=""><a href=".">Older Children's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="category-col">
                <div class="category-card">
                    <img src="https://covers.bookcoverzone.com/slir/w450/png24-front/bookcover0020424.jpg" alt="">
                    <div class="category-card-info">
                        <h3>SCI-FI & FANTASY</h3>
                        <ul class="">
                            <li class=""><a href=".">Historical Sci-Fi</a></li>
                            <li class=""> <a href=".">History</a></li>
                            <li class=""><a href=".">Kid's Sci-Fi & Fantasy</a> </li>
                            <li class=""><a href=".">Older Children's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="category-col">
                <div class="category-card">
                    <img src="https://covers.bookcoverzone.com/slir/w450/png24-front/bookcover0020424.jpg" alt="">
                    <div class="category-card-info">
                        <h3>SCI-FI & FANTASY</h3>
                        <ul class="">
                            <li class=""><a href=".">Historical Sci-Fi</a></li>
                            <li class=""> <a href=".">History</a></li>
                            <li class=""><a href=".">Kid's Sci-Fi & Fantasy</a> </li>
                            <li class=""><a href=".">Older Children's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-books">
    <div class="container">
        <h1>New books</h1>
        <div class="custom-row">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="book-col">
                    <div class="book-card">
                        <?php if (!empty($row['image_src'])) : ?>
                            <img class="book-card-img" src="<?php echo $row['image_src']; ?>" alt="Book Cover">
                        <?php else : ?>
                            <img class="book-card-img" src="https://voice.global/wp-content/plugins/wbb-publications/public/assets/img/placeholder.jpg" alt="Book Cover">
                        <?php endif; ?>
                        <div class="book-card-body">
                            <h4 title="<?php echo $row['book_title']; ?>"><?php echo $row['book_title']; ?></h4>
                            <p><?php echo number_format($row['average_rating'], 1); ?><small>(<?php echo $row['rating_count']; ?>)</small> <?php echo $row['authors']; ?> </p>
                            <a href="/bookview.php?bookId=<?php echo $row['bookId']; ?>" class="btn-main">SEE MORE</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php mysqli_free_result($result); ?>


        </div>
    </div>
</section>

<section class="intro-section-2 container-fluid" style="background-size: cover ;background-image: url(https://www.westernsydney.edu.au/content/dam/digital/images/digital-you/DigiYouBanner.png)">
    <div class="intro-body">
        <div class="">
            <p class="">J.R.R. Tolkien</p>
            <p class="">The Lord of the Rings</p>
            <p class="">SPECIAL PRICE</p>
            <p class="">$9.89</p>
            <div class="btn-main">RELEASING SOON</div>
        </div>
    </div>
</section>



<?php include 'footer.php'; ?>