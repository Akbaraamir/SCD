<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

if ($role === 'admin') {
    $sql = "SELECT * FROM animals ORDER BY name";
} else {
    $sql = "SELECT * FROM animals WHERE user_id = $user_id ORDER BY name";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hope4Paws - Animal Adoption</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-paw"></i> Hope4Paws</h1>
            <p>Find your perfect furry friend!</p>
            <?php if (isset($_SESSION['loggedin'])): ?> 
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! 
                <a href="logout.php" style="color:#f4b3c2;">Logout</a>
                </p>
            <?php endif; ?>
        </header>

        <form action="search.php" method="GET" class="search-box">
            <input type="text" name="name" placeholder="Search by animal name..." required>
            <button type="submit">Search</button>
        </form>

        <div class="add-button">
            <a href="create.php" class="btn">Add New Animal</a>
        </div>

        <div class="animals-list">
            <h2><?php echo ($role === 'admin') ? 'All Animals' : 'Your Animals'; ?></h2>
            
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
                <p><?php echo ($role === 'admin') ? 'No animals available.' : 'You haven\'t added any animals yet.'; ?></p>
            <?php endif; ?>
        </div>
    </div>
    <footer><p>&copy; 2023 Hope4Paws</p></footer>
</body>
</html>
<?php $conn->close(); ?>