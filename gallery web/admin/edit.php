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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // If a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "uploads/";
        $target_file = $target_dir . time() . "_" . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $stmt = $conn->prepare("UPDATE images SET title = ?, description = ?, image_path = ? WHERE id = ?");
            $stmt->bind_param("sssi", $title, $description, $target_file, $id);
        } else {
            echo "Failed to upload new image.";
            exit;
        }
    } else {
        // Update without changing the image
        $stmt = $conn->prepare("UPDATE images SET title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $title, $description, $id);
    }

    if ($stmt->execute()) {
        header("Location: index.php");
        exit;
    } else {
        echo "Update failed.";
    }
}

// Fetch current image data
$stmt = $conn->prepare("SELECT * FROM images WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$image = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #f4f4f4;
        }
        form {
            background: white;
            padding: 30px;
            max-width: 500px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        img {
            max-width: 100%;
            margin-top: 15px;
            border-radius: 5px;
        }
        a.back-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <a href="index.php" class="back-link">&larr; Back to Admin Gallery</a>
    <form action="" method="POST" enctype="multipart/form-data">
        <h2>Edit Image</h2>
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($image['title']) ?>" required>

        <label>Description:</label>
        <textarea name="description" rows="5" required><?= htmlspecialchars($image['description']) ?></textarea>

        <label>Current Image:</label><br>
        <img src="<?= htmlspecialchars($image['image_path']) ?>" alt="Current Image"><br>

        <label>Replace Image (optional):</label>
        <input type="file" name="image">

        <button type="submit">Update</button>
    </form>
</body>
</html>
