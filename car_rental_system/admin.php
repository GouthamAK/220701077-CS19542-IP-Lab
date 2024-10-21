<?php
session_start();
include 'db.php'; // Include the database connection

// Check if user is an admin
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs to prevent XSS attacks
    $car_name = htmlspecialchars($_POST['car_name']);
    $car_price = floatval($_POST['car_price']);
    $car_model = htmlspecialchars($_POST['car_model']);
    $car_description = htmlspecialchars($_POST['car_description']);

    // Handle file upload (car_image)
    if (isset($_FILES['car_image']) && $_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['car_image']['tmp_name'];
        $fileName = $_FILES['car_image']['name'];
        $fileSize = $_FILES['car_image']['size'];
        $fileType = $_FILES['car_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Specify allowed file types for images
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Generate a new file name to avoid overwriting
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Directory where the file should be saved
            $uploadFileDir = './uploaded_images/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Prepare and execute the SQL statement to insert car details with image
                $stmt = $db->prepare("INSERT INTO cars (name, price_per_day, image, model, description) VALUES (:name, :price, :image, :model, :description)");
                $stmt->execute([
                    ':name' => $car_name,
                    ':price' => $car_price,
                    ':image' => $newFileName, // Save the uploaded image filename
                    ':model' => $car_model,
                    ':description' => $car_description
                ]);
                echo "<div class='alert alert-success'>Car Added: $car_name</div>";
            } else {
                echo "<div class='alert alert-danger'>Error moving the uploaded file.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Only image files (jpg, jpeg, png, gif) are allowed.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>No image uploaded or an error occurred during upload.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Car Rental</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Admin Panel - Add Car</h1>
        <form action="admin.php" method="POST" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="car_name" class="form-label">Car Name:</label>
                <input type="text" class="form-control" id="car_name" name="car_name" required>
            </div>
            <div class="mb-3">
                <label for="car_price" class="form-label">Car Price (per day):</label>
                <input type="number" class="form-control" id="car_price" name="car_price" required>
            </div>
            <div class="mb-3">
                <label for="car_model" class="form-label">Car Model:</label>
                <input type="text" class="form-control" id="car_model" name="car_model" required>
            </div>
            <div class="mb-3">
                <label for="car_image" class="form-label">Car Image:</label>
                <input type="file" class="form-control" id="car_image" name="car_image" required>
            </div>
            <div class="mb-3">
                <label for="car_description" class="form-label">Car Description:</label>
                <textarea class="form-control" id="car_description" name="car_description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Car</button>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3" style="position: fixed; width: 100%; bottom: 0;">
        <p>&copy; 2024 Car Rental Service</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
