<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to the Art Gallery</title>
    <link rel="stylesheet" href="viewer/frontpagestyle.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        .welcome-box {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 30px;
            font-size: 16px;
            color: #555;
        }

        .enter-btn {
            background-color:rgb(32, 159, 245);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .enter-btn:hover {
            background-color:rgb(2, 58, 96);
        }
    </style>
</head>
<body>
    <div class="welcome-box">
        <h1>Welcome to the Art Gallery</h1>
        <p>Explore a collection of curated images uploaded by our admin. Click below to enter the gallery.</p>
        <a href="galleryview.php" class="enter-btn">Enter Gallery</a>
    </div>
</body>
</html>
