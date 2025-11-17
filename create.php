<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO animals (name, type, breed, age, description, user_id)
            VALUES ('$name', '$type', '$breed', '$age', '$description', '$user_id')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New animal added successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Animal - Hope4Paws</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header><h1>Add New Animal</h1></header>
        <form method="post" class="form">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Type:</label>
            <select name="type" required>
                <option value="">Select Type</option>
                <option value="Dog">Dog</option>
                <option value="Cat">Cat</option>
                <option value="Rabbit">Rabbit</option>
                <option value="Bird">Bird</option>
                <option value="Other">Other</option>
            </select>
            <label>Breed:</label>
            <input type="text" name="breed" required>
            <label>Age (months):</label>
            <input type="number" name="age" min="1" required>

            <label>Description:</label>
            <textarea name="description" rows="4" required></textarea>
            <div class="form-buttons">
                <button type="submit" class="btn">Add Animal</button>
                <a href="index.php" class="btn cancel">Cancel</a>
            </div>
        </form>
    </div>
    <footer><p>&copy; 2023 Hope4Paws</p></footer>
</body>
</html>
<?php $conn->close(); ?>