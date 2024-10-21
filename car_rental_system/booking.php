<?php
include 'db.php';
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    $stmt = $db->prepare("SELECT * FROM cars WHERE id = :id");
    $stmt->execute([':id' => $car_id]);
    $car = $stmt->fetch();

    if (!$car) {
        echo "Car not found!";
        exit;
    }
} else {
    echo "Invalid request!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_date = $_POST['booking_date'];
    $username = $_SESSION['username'];  

    $stmt = $db->prepare("INSERT INTO bookings (car_id, username, booking_date) VALUES (:car_id, :username, :booking_date)");
    $stmt->execute([
        ':car_id' => $car_id,
        ':username' => $username,
        ':booking_date' => $booking_date
    ]);

    $success_message = "Booking confirmed for " . $car['name'] . " on " . $booking_date . "!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Car</title>
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
        <h1 class="text-center">Book <?php echo $car['name']; ?></h1>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success text-center">
                <?php echo $success_message; ?>
            </div>
        <?php else: ?>
            <form action="booking.php?car_id=<?php echo $car_id; ?>" method="POST" class="mt-4">
                <div class="mb-3">
                    <label for="booking_date" class="form-label">Booking Date:</label>
                    <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                </div>
                <button type="submit" class="btn btn-primary">Confirm Booking</button>
            </form>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white text-center py-3" style="position: fixed; width: 100%; bottom: 0;">
        <p>&copy; 2024 Car Rental Service</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
