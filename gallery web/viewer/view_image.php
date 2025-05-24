<?php
$conn = new mysqli("localhost", "root", "", "gallery_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "No image selected.";
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT title, description, image_path FROM images WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Image not found.";
    exit;
}

$image = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($image['title']) ?></title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 40px;
    display: flex;
    gap: 40px;
    align-items: flex-start;
  }
  .image-container img {
    max-width: 600px;
    max-height: 80vh;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.2);
  }
  .info-container {
    max-width: 400px;
  }
  .info-container h1 {
    margin-top: 0;
  }
  .info-container p {
    font-size: 16px;
    line-height: 1.5;
  }
  .back-link {
    position: absolute;
    top: 20px;
    left: 20px;
    text-decoration: none;
    color: #444;
    font-weight: bold;
  }
</style>
</head>
<body>
  <a href="galleryview.php" class="back-link">&larr; Back to Gallery</a>
  <div class="image-container">
    <img src="../<?= htmlspecialchars($image['image_path']) ?>" alt="<?= htmlspecialchars($image['title']) ?>">
  </div>
  <div class="info-container">
    <h1><?= htmlspecialchars($image['title']) ?></h1>
    <p><?= nl2br(htmlspecialchars($image['description'])) ?></p>
  </div>
</body>
</html>
