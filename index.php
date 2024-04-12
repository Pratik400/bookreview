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
        <img src="https://www.ft.com/__origami/service/image/v2/images/raw/http%3A%2F%2Fft-ig-images-prod.s3-website-eu-west-1.amazonaws.com%2Fv1%2F8340457253-ndbcf.jpg?source=ft_ig_business_book_award&width=400&compression=best" alt="">
        <div class="">
            <p class="">SPECIAL PRICE</p>
            <p class="">Chip War: The Fight for the World's Most Critical Technology (4.5)</p>
            <p class="">By Chris Miller (Author)</p>
            <p class="">$37.89</p>
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
        <h1>Browse by Category</h1>
        <div class="custom-row">
            <div class="category-col">
                <div class="category-card">
                    <img src="https://novapublishers.com/wp-content/uploads/2022/02/9781685076153_2-1000x1585.jpg" alt="">
                    <div class="category-card-info">
                        <h3>Technical Infrastructure</h3>
                        <ul class="">
                            <li class=""><a href=".">Cloud Computing</a></li>
                            <li class=""> <a href=".">Networking</a></li>
                            <li class=""><a href=".">DevOps</a> </li>
                            <li class=""><a href=".">Mobile Development</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="category-col">
                <div class="category-card">
                    <img src="https://www.worldscientific.com/action/showCoverImage?doi=10.1142/11921" alt="">
                    <div class="category-card-info">
                        <h3>Technical Infrastructure</h3>
                        <ul class="">
                            <li class=""><a href=".">Cloud Computing</a></li>
                            <li class=""> <a href=".">Networking</a></li>
                            <li class=""><a href=".">DevOps</a> </li>
                            <li class=""><a href=".">Mobile Development</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="category-col">
                <div class="category-card">
                    <img src="https://i5.walmartimages.com/seo/IOT-Internet-Of-Things-Architecture-Raspberry-Pi-Introduction-Installation-Arduino-vs-Windows-10-IoT-Core-kit-Paperback-9798683263737_120d7c3e-b545-486e-a2c6-a3ecc8e9b1ef.6806b796716bd16428868043be1f5358.jpeg" alt="">
                    <div class="category-card-info">
                        <h3>Emerging Tech & UX</h3>
                        <ul class="">
                            <li class=""><a href=".">Internet of Things</a></li>
                            <li class=""> <a href=".">Quantum Computing</a></li>
                            <li class=""><a href=".">User Experience</a> </li>
                            <li class=""><a href=".">Software Development</a></li>
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