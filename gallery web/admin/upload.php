<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "gallery_db");

$title = $_POST['title'];
$description = $_POST['description'];

$targetDir = "../uploads/"; // go up one level if 'uploads' is outside 'admin'
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$imageName = basename($_FILES["image"]["name"]);
$targetFile = $targetDir . time() . "_" . $imageName;

if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
    $relativePath = "uploads/" . time() . "_" . $imageName;
    $stmt = $conn->prepare("INSERT INTO images (title, description, image_path) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $relativePath);
    $stmt->execute();
}

header("Location: index.php");
exit;
