<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
if (!$_SESSION['admin']) {
    echo "You don't have permission to access this page.";
    exit();
}   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/admin.css"> 
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['username']; ?> (Admin)</h1>
        <a id="logout_button" href="logout.php">Logout</a>
    </header>
    <div>
        <p id="username">username: admin</p>
    </div>
    <footer>
        <p>ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>
