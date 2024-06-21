<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header("Location: index.php");
    exit();
}

include 'books.php';

$addSuccess = false;
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $cover = $_POST['cover'];
    $description = $_POST['description'];
    $publication_date = $_POST['publication_date'];
    $isbn = $_POST['isbn'];
    
    if (empty($title)) {
        $errors[] = "Title is required";
    }
    if (empty($author)) {
        $errors[] = "Author is required";
    }
    if (empty($cover)) {
        $errors[] = "Cover image URL is required";
    }
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    if (empty($publication_date)) {
        $errors[] = "Publication date is required";
    }
    if (empty($isbn)) {
        $errors[] = "ISBN is required";
    }
    if (empty($errors)) {
        $newBookId = 'book' . count($data);
        $data[$newBookId] = [
            'title' => $title,
            'author' => $author,
            'cover' => $cover,
            'description' => $description,
            'publication_date' => $publication_date,
            'isbn' => $isbn
        ];
        file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT));
        $addSuccess = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IK-Library | Add New Book</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/add_book.css">
</head>
<body>
    <header>
        <h1><a href="index.php">Books</a> > Add New Book</h1>
    </header>
    <div id="content">
        <?php
        if ($addSuccess) {
            echo "<p><strong>New book added successfully!</strong></p>";
        } else {
            if (!empty($errors)) {
                echo "<ul>";
                foreach ($errors as $error) {
                    echo "<li>$error</li>";
                }
                echo "</ul>";
            }
        }
        ?>
        <form action="add_book.php" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?=  $title ?? '' ?>">
            <br>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?=  $author ?? '' ?>">
            <br>
            <label for="cover">Cover Image URL:</label>
            <input type="text" id="cover" name="cover" value="<?=  $cover ?? '' ?>">
            <br>
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?=  $description ?? '' ?></textarea>
            <br>
            <label for="publication_date">Publication Date:</label>
            <input type="date" id="publication_date" name="publication_date" value="<?=  $publication_date ?? '' ?>">
            <br>
            <label for="isbn">ISBN:</label>
            <input type="text" id="isbn" name="isbn" value="<?=  $isbn ?? '' ?>">
            <br>
            <input type="submit" value="Add Book">
        </form>
    </div>
    <footer>
        <p>ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>


