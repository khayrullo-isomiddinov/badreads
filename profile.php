<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$userStorage = 'data/users.json';
$reviewStorage = 'data/reviews.json';
$users = [];
$reviews = [];
$theReviews = [];

if (file_exists($userStorage)) {
    $users = json_decode(file_get_contents($userStorage), true);
}
if (file_exists($reviewStorage)) {
    $reviews = json_decode(file_get_contents($reviewStorage), true);
}

$username = $_SESSION['username'];
$user = $users[$username];
$lastLoginDate = isset($user['last_login']) ? $user['last_login'] : 'N/A';
$users[$username]['last_login'] = date('Y-m-d H:i:s');
file_put_contents($userStorage, json_encode($users));
foreach ($reviews as $bookId => $revs) {
    foreach ($revs as $review) {
        if ($review['username'] === $username) {
            $theReviews[] = $review;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/profile.css">
</head>
<body>
    <header>
        <h1>User Profile</h1>
    </header>
    <div id="content">
        <h2>Profile Information</h2>
        <p><strong>Username:</strong> <?php echo $username; ?></p>
        <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
        <p><strong>Admin:</strong> <?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></p>
        <p><strong>Last Login:</strong> <?php echo $lastLoginDate; ?></p>
        <h2>Reviews by <?php echo $username; ?></h2>
        <ul>
            <?php if (!empty($theReviews)): ?>
                <?php foreach ($theReviews as $review): ?>
                    <li>
                        <p>Book ID: <?php echo $review['book_id']; ?></p>
                        <p>Rating: <?php echo $review['rating']; ?> / 5</p>
                        <p>Review: <?php echo  ($review['review']); ?></p>
                        <p>Timestamp: <?php echo $review['timestamp']; ?></p>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No reviews were writtem by <?php echo  ($username); ?></li>
            <?php endif; ?>
        </ul>
        <button class="back-button"><a href="index.php">Back to Home</a></button>
    </div>
    <footer>
        <p> ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>


