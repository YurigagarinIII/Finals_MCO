<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}
?>
<?php
$conn = new mysqli("localhost", "root", "", "gallery_db");
$images = $conn->query("SELECT * FROM images ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <div class="header-container">
        <h1 class="center-title">Image Gallery Admin</h1>
        <div class="nav-buttons">
            <a href="../viewer/frontpage.php" class="viewer-btn">View Gallery</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</header>
<div class="container">
    <h2>Upload Image</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="image" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Image Gallery</h2>
    <div class="gallery">
        <?php while($row = $images->fetch_assoc()): ?>
            <div class="item">
    <img src="../<?= htmlspecialchars($row['image_path']) ?>" alt="image">
    <h3><?= htmlspecialchars($row['title']) ?></h3>
    <p><?= htmlspecialchars($row['description']) ?></p>
    <div class="admin-actions">
        <a class="edit-btn" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
        <a class="delete-btn" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this image?')">Delete</a>
    </div>
</div>

        <?php endwhile; ?>
    </div>
</div>
</body>
