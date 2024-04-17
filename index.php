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
                book b
            LEFT JOIN 
                authorship ash ON b.bookId = ash.bookId
            LEFT JOIN 
                author a ON ash.authorId = a.authorId
            LEFT JOIN 
                report r ON b.bookId = r.bookId
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
                book b
            LEFT JOIN 
                authorship ash ON b.bookId = ash.bookId
            LEFT JOIN 
                author a ON ash.authorId = a.authorId
            LEFT JOIN 
                report r ON b.bookId = r.bookId
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


<section class="intro-section container-fluid" style="background-size: cover ;background-image: url(assets/img/introbg1.jpg)">
    <div class="intro-body">
        <img src="assets/img/introbook.avif" alt="">
        <div class="">
            <p class="">SPECIAL PRICE</p>
            <p class="">Chip War: The Fight for the World's Most Critical Technology (4.5)</p>
            <p class="">By Chris Miller (Author)</p>
            <p class="">$37.89</p>
            <button class="btn-main coming-soon">RELEASING SOON</button>
        </div>
    </div>
</section>

<section class="featured-books">
    <div class="container">
        <h1 class="section-header">Our Best Rated Books</h1>
        <div class="custom-row">
            <?php while ($row = mysqli_fetch_assoc($result2)) : ?>
                <div class="book-col">
                    <div class="book-card">
                        <?php if (!empty($row['image_src'])) : ?>
                            <img class="book-card-img" src="<?php echo $row['image_src']; ?>" alt="Book Cover">
                        <?php else : ?>
                            <img class="book-card-img" src="assets/img/bookplaceholder.jpg" alt="Book Cover">
                        <?php endif; ?>
                        <div class="book-card-body">
                            <h4 title="<?php echo $row['book_title']; ?>">
                                <?php echo $row['book_title']; ?>
                            </h4>
                            <p>
                                <?php if (!empty($row['authors'])) : ?>
                                    By
                                <?php endif; ?>
                                <?php echo $row['authors']; ?>
                            </p>
                            <p>
                                <small><?php echo number_format($row['average_rating'], 1); ?>(<?php echo $row['rating_count']; ?>)</small>
                            </p>
                            <a href="bookview.php?bookId=<?php echo $row['bookId']; ?>" class="btn-main">
                                SEE MORE
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php mysqli_free_result($result2); ?>
        </div>
</section>

<section class="featured-categories">
    <div class="container">
        <h1 class="section-header">Browse by Category</h1>
        <div class="custom-row">
            <div class="category-col">
                <div class="category-card">
                    <img src="assets/img/cat1.jpg" alt="">
                    <div class="category-card-info">
                        <h3>Tech Infrastructure</h3>
                        <ul class="">
                            <li class=""><a href="" class="coming-soon">Cloud Computing</a></li>
                            <li class=""> <a href="" class="coming-soon">Networking</a></li>
                            <li class=""><a href="" class="coming-soon">DevOps</a> </li>
                            <li class=""><a href="" class="coming-soon">Mobile Development</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="category-col">
                <div class="category-card">
                    <img src="assets/img/cat2.jpg" alt="">
                    <div class="category-card-info">
                        <h3>Cybersecurity</h3>
                        <ul class="">
                            <li class=""><a href="" class="coming-soon">Blockchain</a></li>
                            <li class=""> <a href="" class="coming-soon">Data Privacy</a></li>
                            <li class=""><a href="" class="coming-soon">Cryptography</a> </li>
                            <li class=""><a href="" class="coming-soon">Social Engineering</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="category-col">
                <div class="category-card">
                    <img src="assets/img/cat3.webp" alt="">
                    <div class="category-card-info">
                        <h3>Emerging Tech & UX</h3>
                        <ul class="">
                            <li class=""><a href="" class="coming-soon">Internet of Things</a></li>
                            <li class=""> <a href="" class="coming-soon">Quantum Computing</a></li>
                            <li class=""><a href="" class="coming-soon">User Experience</a> </li>
                            <li class=""><a href="" class="coming-soon">Software Development</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="featured-books">
    <div class="container">
        <h1 class="section-header">New books</h1>
        <div class="custom-row">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="book-col">
                    <div class="book-card">
                        <?php if (!empty($row['image_src'])) : ?>
                            <img class="book-card-img" src="<?php echo $row['image_src']; ?>" alt="Book Cover">
                        <?php else : ?>
                            <img class="book-card-img" src="assets/img/bookplaceholder.jpg" alt="Book Cover">
                        <?php endif; ?>
                        <div class="book-card-body">
                            <h4 title="<?php echo $row['book_title']; ?>">
                                <?php echo $row['book_title']; ?>
                            </h4>
                            <p>
                                <?php if (!empty($row['authors'])) : ?>
                                    By
                                <?php endif; ?>
                                <?php echo $row['authors']; ?>
                            </p>
                            <p>
                                <small><?php echo number_format($row['average_rating'], 1); ?>(<?php echo $row['rating_count']; ?>)</small>
                            </p>
                            <a href="bookview.php?bookId=<?php echo $row['bookId']; ?>" class="btn-main">
                                SEE MORE
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php mysqli_free_result($result); ?>


        </div>
    </div>
</section>

<section class="intro-section-2 container-fluid" style="background-size: cover ;background-image: url(assets/img/introbg2.png)">
    <div class="intro-body">
        <div class="">
            <p class="">SPECIAL EDITION</p>
            <p class="">Technology & Society: Second Edition (4.5)</p>
            <p class="">Edited by Deborah G. Johnson</p>
            <p class="">$37.89</p>
            <div class="btn-main coming-soon">RELEASING SOON</div>
        </div>
    </div>
</section>



<?php include 'footer.php'; ?>