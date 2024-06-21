<?php
session_start();
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$userStorage = 'data/users.json';
$users = [];
$errors = [];
$registeredOk = false;

if (file_exists($userStorage)) {
    $users = json_decode(file_get_contents($userStorage), true);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    } elseif (isset($users[$username])) {
        $errors[] = "Username already taken.";
    } else {
        $hashedP = password_hash($password, PASSWORD_DEFAULT);
        $users[$username] = [
            'email' => $email,
            'password' => $hashedP,
            'is_admin' => false 
        ];
        file_put_contents($userStorage, json_encode($users, JSON_PRETTY_PRINT));
        $registeredOk = true;
        $_SESSION['username'] = $username;
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
    <title>Register</title>
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/register.css">
</head>
<body>
    <header>
        <h1>Register</h1>
    </header>
    <div id="content">
        <?php if ($registeredOk): ?>
            <p><strong>Registration has been successful! Redirecting you to home page...</strong></p>
        <?php elseif (!empty($errors)): ?>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= $username ?? '' ?>">
            <br>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" value="<?= $email ?? '' ?>">
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password">
            <br>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password">
            <br>
            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
    <footer>
        <p>ELTE IK Webprogramming | &copy; Khayrullo Isomiddinov</p>
    </footer>
</body>
</html>
