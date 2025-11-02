<?php
include 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } else {
    
        $check = "SELECT * FROM users WHERE username='$username'";
        $result = $conn->query($check);

        if ($result->num_rows > 0) {
            $message = "Username already taken.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed')";
            if ($conn->query($sql) === TRUE) {
                header("Location: login.php");
                exit();
            } else {
                $message = "Error: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sign Up - Hope4Paws</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Hope4Paws</h1>
            <p>Create an account</p>
        </header>

        <?php if ($message): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" class="form">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password (min 6 chars):</label>
            <input type="password" name="password" required>

            <div class="form-buttons">
                <button type="submit" class="btn">Sign Up</button>
                <a href="login.php" class="btn cancel">Login</a>
            </div>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Hope4Paws</p>
    </footer>
</body>
</html>