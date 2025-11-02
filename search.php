<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$search_name = $_GET['name'];
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'admin') {
    $sql = "SELECT * FROM animals WHERE name LIKE '%$search_name%'";
} else {
    $sql = "SELECT * FROM animals WHERE name LIKE '%$search_name%' AND user_id = $user_id";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results - Hope4Paws</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-paw"></i> Hope4Paws</h1>
            <p>Search Results for "<?php echo htmlspecialchars($search_name); ?>"</p>
        </header>

        <form action="search.php" method="GET" class="search-box">
            <input type="text" name="name" value="<?php echo htmlspecialchars($search_name); ?>" required>
            <button type="submit">Search</button>
        </form>

        <div class="add-button">
            <a href="index.php" class="btn">Back to Animals</a>
        </div>

        <div class="animals-list">
            <h2>Search Results <?php if ($role !== 'admin'): ?>(Your Animals)<?php endif; ?></h2>
            
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                <div class="animal-card">
                    <h3><?php echo $row["name"]; ?></h3>
                    <p><strong>Type:</strong> <?php echo $row["type"]; ?></p>
                    <p><strong>Breed:</strong> <?php echo $row["breed"]; ?></p>
                    <p><strong>Age:</strong> <?php echo $row["age"]; ?> months</p>
                    <p><strong>Description:</strong> <?php echo $row["description"]; ?></p>
                    <div class="actions">
                        <a href="update.php?id=<?php echo $row["id"]; ?>" class="btn edit">Edit</a>
                        <a href="delete.php?id=<?php echo $row["id"]; ?>" class="btn delete" 
                           onclick="return confirm('Are you sure you want to delete this animal?')">Delete</a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No animals found with name containing "<?php echo htmlspecialchars($search_name); ?>"</p>
            <?php endif; ?>
        </div>
    </div>
    <footer><p>&copy; 2023 Hope4Paws</p></footer>
</body>
</html>
<?php $conn->close(); ?>