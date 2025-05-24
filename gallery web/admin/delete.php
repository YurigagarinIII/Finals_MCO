<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
$conn = new mysqli("localhost", "root", "", "gallery_db");

$id = intval($_GET['id']);
$result = $conn->query("SELECT image_path FROM images WHERE id = $id");

if ($row = $result->fetch_assoc()) {
    unlink($row['image_path']); // delete image file
}

$conn->query("DELETE FROM images WHERE id = $id");
header("Location: index.php");
