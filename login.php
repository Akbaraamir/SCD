<?php
session_start();
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['role'] = $row['role']; // ← Store role
            header("Location: index.php");
            exit();
        }
    }
    $message = "Invalid username or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Hope4Paws</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Hope4Paws</h1>
            <p>Staff Login</p>
        </header>

        <?php if ($message): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" class="form">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <div class="form-buttons">
                <button type="submit" class="btn">Login</button>
                <a href="signup.php" class="btn cancel">Sign Up</a>
            </div>
        </form>
    </div>
    <footer><p>&copy; 2025 Hope4Paws</p></footer>
</body>
</html>