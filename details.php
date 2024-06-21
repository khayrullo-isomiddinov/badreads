<?php
include 'books.php';
session_start();
$reviewsFile = 'data/reviews.json';
$reviewsData = [];
if (file_exists($reviewsFile)) {
    $reviewsData = json_decode(file_get_contents($reviewsFile), true);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_review'])) {
    $bookId = $_POST['book_id'];
    $username = $_SESSION['username'] ?? 'Guest';
    $rating = $_POST['rating'];
    $review = $_POST['review'];
    if (!isset($reviewsData[$bookId])) {
        $reviewsData[$bookId] = [];
    }
    $reviewsData[$bookId][] = [
        'username' => $username,
        'rating' => $rating,
        'review' => $review,
        'timestamp' => date('Y-m-d H:i:s')
    ];
    file_put_contents($reviewsFile, json_encode($reviewsData));
}
$bookId = $_GET['id'];
$books = $data;
$bookReviews = $reviewsData[$bookId] ?? [];
$averageRating = 0;
if (count($bookReviews) > 0) {
    $totalRating = array_sum(array_column($bookReviews, 'rating'));
    $averageRating = $totalRating / count($bookReviews);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Book Details</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/details.css">
</head>
<body>
    <header>
        <h1><a href="index.php">Books</a> > Book Details</h1>
    </header>
    <div id="content">
        <?php if (array_key_exists($bookId, $books)): ?>
            <?php $book = $books[$bookId]; ?>
            <div class="book-details">
                <div class='image'>
                    <img src='<?php echo $book['cover']; ?>' alt='<?php echo $book['title']; ?>'>
                </div>
                <div class='details'>
                    <h2><?php echo $book['title']; ?></h2>
                    <p><strong>Author:</strong> <?php echo $book['author']; ?></p>
                    <p><strong>Publication Date:</strong> <?php echo $book['publication_date']; ?></p>
                    <p><strong>ISBN:</strong> <?php echo $book['isbn']; ?></p>
                    <p><strong>Description:</strong> <?php echo $book['description']; ?></p>
                    <p><strong>Average Rating:</strong> <?php echo number_format($averageRating, 2); ?> / 5</p>
                </div>
            </div>
            <div class="reviews-section">
                <h3>Reviews</h3>
                <div class="reviews-container">
                    <?php if (!empty($bookReviews)): ?>
                        <?php foreach ($bookReviews as $review): ?>
                            <div class="review">
                                <div class="review-header">
                                    <p><strong><?php echo  $review['username']; ?></strong> (<?php echo $review['rating']; ?> / 5)</p>
                                    <p class="timestamp"><?php echo $review['timestamp']; ?></p>
                                </div>
                                <p class="review-content"><?php echo  $review['review']; ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No reviews yet. Do you want to be the first one? 😊 </p>
                    <?php endif; ?>
                </div>
                <form action="details.php?id=<?php echo $bookId; ?>" method="post" class="review-form">
                    <h3>Leave a Review</h3>
                    <input type="hidden" name="book_id" value="<?php echo $bookId; ?>">
                    <div class="rating">
                        <label>Rating:</label>
                        <div class="stars">
                            <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                            <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                            <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                            <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                            <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                        </div>
                    </div>
                    <label for="review">Review:</label>
                    <textarea name="review" id="review" rows="4" required></textarea>
                    <input type="submit" name="submit_review" value="Submit Review">
                </form>
            </div>
        <?php else: ?>
            <p><strong>Sorry, the book has been removed from our storage.</strong></p>
        <?php endif; ?>
    </div>
    <footer>
        <p>ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>
