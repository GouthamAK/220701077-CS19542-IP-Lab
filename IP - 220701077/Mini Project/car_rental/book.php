<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$user_id = mysqli_real_escape_string($conn, $user_id);


$query = "
    SELECT b.id AS booking_id, c.name AS car_name, c.image AS car_image, 
           b.start_date, b.end_date, b.total_price 
    FROM bookings b 
    INNER JOIN cars c ON b.car_id = c.id 
    WHERE b.user_id = '$user_id'
";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rented Cars - History</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <h2 class="text-center mb-4">Your Rental History</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <?php 
                             
                                $car_image = !empty($row['car_image']) ? 'assets/images/'.$row['car_image'] : 'assets/images/default_car.jpg';
                            ?>
                            <img src="<?php echo $car_image; ?>" class="card-img-top" alt="<?php echo $row['car_name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['car_name']; ?></h5>
                                <p class="card-text">Start Date: <?php echo date('F j, Y', strtotime($row['start_date'])); ?></p>
                                <p class="card-text">End Date: <?php echo date('F j, Y', strtotime($row['end_date'])); ?></p>
                                <p class="card-text">Total Price: $<?php echo number_format($row['total_price'], 2); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                You haven't rented any cars yet.
            </div>
        <?php endif; ?>
    </div>

 
</body>
</html>
