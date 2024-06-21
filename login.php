<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
$usersFile = 'data/users.json';
$users = [];
if (file_exists($usersFile)) {
    $users = json_decode(file_get_contents($usersFile), true);
}
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $errors[] = "Username and password are required.";
    } elseif (!isset($users[$username]) || !password_verify($password, $users[$username]['password'])) {
        $errors[] = "Invalid username or password.";
    } else {
        $_SESSION['username'] = $username;
        $_SESSION['admin'] = $users[$username]['is_admin']; 
        header("Location: index.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>
    <div id="content">
        <?php if (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo  $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br>
            <input type="submit" name="login" value="Login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
    <footer>
        <p>ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>

