<?php
$conn = new mysqli("localhost", "root", "", "gallery_db");
$images = $conn->query("SELECT * FROM images ORDER BY uploaded_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="frontpagestyle.css">
</head>
<body>
<header>
    <div class="viewer-header">
        <h1>Art Gallery</h1>
        <a href="../admin/login.php" class="admin-btn">Admin</a>
    </div>
</header>
    <div class="gallery">
    <?php while($row = $images->fetch_assoc()): ?>
    <div class="item">
        <a href="../<?= htmlspecialchars($row['image_path']) ?>" target="_blank">
            <img src="../<?= htmlspecialchars($row['image_path']) ?>" alt="image">
        </a>
        <h3><?= htmlspecialchars($row['title']) ?></h3>
        <p><?= htmlspecialchars($row['description']) ?></p>
    </div>
<?php endwhile; ?>
</div>
</body>
</html>
