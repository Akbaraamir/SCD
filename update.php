<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM animals WHERE id=$id AND user_id=$user_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Access denied: You can only edit your own animals.");
}
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];
    
    $sql = "UPDATE animals SET name='$name', type='$type', breed='$breed', 
            age='$age', gender='$gender', description='$description' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Animal updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Animal - Hope4Paws</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header><h1>Edit Animal</h1></header>
        <form method="post" class="form">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $row['name']; ?>" required>
            <label>Type:</label>
            <select name="type" required>
                <option value="">Select Type</option>
                <option value="Dog" <?php if($row['type']=='Dog') echo 'selected'; ?>>Dog</option>
                <option value="Cat" <?php if($row['type']=='Cat') echo 'selected'; ?>>Cat</option>
                <option value="Rabbit" <?php if($row['type']=='Rabbit') echo 'selected'; ?>>Rabbit</option>
                <option value="Bird" <?php if($row['type']=='Bird') echo 'selected'; ?>>Bird</option>
                <option value="Other" <?php if($row['type']=='Other') echo 'selected'; ?>>Other</option>
            </select>
            <label>Breed:</label>
            <input type="text" name="breed" value="<?php echo $row['breed']; ?>" required>
            <label>Age (months):</label>
            <input type="number" name="age" min="1" value="<?php echo $row['age']; ?>" required>
            <label>Description:</label>
            <textarea name="description" rows="4" required><?php echo $row['description']; ?></textarea>
            <div class="form-buttons">
                <button type="submit" class="btn">Update Animal</button>
                <a href="index.php" class="btn cancel">Cancel</a>
            </div>
        </form>
    </div>
    <footer><p>&copy; 2023 Hope4Paws</p></footer>
</body>
</html>
<?php $conn->close(); ?>