<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Programming Assignment - Harry</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/cards.css">
</head>
<body>
    <header>
        <h1><a href="index.php">Books</a> > Home</h1>
        <?php if (isset($_SESSION['username'])): ?>
            <button id="logout_button" style="background-color: black; color: white; border: none; padding: 10px 20px; cursor: pointer; ">
                <a href="logout.php" style="color: brown; text-decoration: none;">Logout</a>
            </button>
            <a id="profile_button" href="profile.php">
                <img src="assets/profile.png">
            </a> 
        <?php endif; ?>
    </header>
    <div id="content">
        <div id="card-list">
            <?php
            $booksFile = 'data/books.json';
            $books = [];
            if (file_exists($booksFile)) {
                $books = json_decode(file_get_contents($booksFile), true);
            }

            foreach ($books as $bookId => $book) {
                if (strpos($book['title'], '-') !== false) {
                    list($author, $title) = explode(' - ', $book['title'], 2);
                } else {
                    $author = $book['author'];
                    $title = $book['title'];
                }

                echo '<div class="book-card">';
                echo '<div class="image"><img src="'.$book['cover'].'" alt=""></div>';
                echo '<div class="details">';
                echo '<h2><a href="details.php?id='.$bookId.'">' .$author.' - '.$title.'</a></h2>';
                echo '</div>';
                if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                    echo '<div class="edit"><span><a id="edit_text" href="edit.php">Edit</a></span></div>';
                }
                echo '</div>';
            }
            ?>
            <?php if (isset($_SESSION['admin']) && $_SESSION['admin']): ?>
                <div class="book-card">
                    <div class="image">
                        <img src="assets/add.jpg" alt="the image of the empty book for adding">
                    </div>
                    <div class="details">
                        <h2><a href="add_book.php">Create a new book</a></h2>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <footer>
        <p> ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>


