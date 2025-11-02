<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}
include 'config.php';

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Verify ownership
$sql = "SELECT id FROM animals WHERE id=$id AND user_id=$user_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Access denied: You can only delete your own animals.");
}

// Delete
$sql = "DELETE FROM animals WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Animal deleted successfully!'); window.location.href='index.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>