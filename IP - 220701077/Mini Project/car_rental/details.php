<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Car Details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <?php
        $car_id = $_GET['car_id'];
        $start_date = $_GET['start_date'];
        $end_date = $_GET['end_date'];

        $query = "SELECT * FROM cars WHERE id=$car_id";
        $result = mysqli_query($conn, $query);
        $car = mysqli_fetch_assoc($result);
        ?>
        <h2><?php echo $car['name']; ?></h2>
        <img src="assets/images/<?php echo $car['image']; ?>" alt="<?php echo $car['name']; ?>" class="img-fluid">
        <p>Price per day: $<?php echo $car['price_per_day']; ?></p>
        <form action="book.php" method="POST">
            <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
            <input type="hidden" name="start_date" value="<?php echo $start_date; ?>">
            <input type="hidden" name="end_date" value="<?php echo $end_date; ?>">
            <button type="submit" class="btn btn-success">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
