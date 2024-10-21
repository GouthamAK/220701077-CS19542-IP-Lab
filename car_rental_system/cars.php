<?php
include 'db.php';
session_start();

$cars = $db->query("SELECT * FROM cars")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Cars</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Car Rental</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Available Cars</h1>
        <div class="row">
            <?php foreach ($cars as $car): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="images/<?php echo $car['image']; ?>" class="card-img-top" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $car['name']; ?></h5>
                            <p class="card-text"><?php echo $car['description']; ?></p>
                            <p><strong>Price per day:</strong> $<?php echo $car['price_per_day']; ?></p>
                            <a href="booking.php?car_id=<?php echo $car['id']; ?>" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
