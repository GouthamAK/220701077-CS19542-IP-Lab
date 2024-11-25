<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'db_connect.php';


$location = isset($_GET['location']) ? mysqli_real_escape_string($conn, $_GET['location']) : '';
$start_date = isset($_GET['start_date']) ? mysqli_real_escape_string($conn, $_GET['start_date']) : '';
$end_date = isset($_GET['end_date']) ? mysqli_real_escape_string($conn, $_GET['end_date']) : '';


if (empty($location) || empty($start_date) || empty($end_date)) {
    header('Location: search.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="text-center">Available Cars for Your Trip</h2>

        <div class="row">
        <?php
     
        $query = "SELECT * FROM cars WHERE location='$location' AND availability='yes'";
        $result = mysqli_query($conn, $query);

        if ($result) {
           
            if (mysqli_num_rows($result) > 0) {
                
                while ($row = mysqli_fetch_assoc($result)) {
                    $car_id = $row['id'];
                    $car_name = $row['name'];
                    $car_image = $row['image'];
                    $price_per_day = $row['price_per_day'];

                    
                    echo "
                    <div class='col-md-4 mb-4'>
                        <div class='card'>
                            <img src='style/images/{$car_image}' class='card-img-top img-fluid' alt='{$car_name}'>
                            <div class='card-body'>
                                <h5 class='card-title'>{$car_name}</h5>
                                <p class='card-text'>Price per day: $ {$price_per_day}</p>
                                <a href='details.php?car_id={$car_id}&start_date={$start_date}&end_date={$end_date}' class='btn btn-primary'>Rent Now</a>
                            </div>
                        </div>
                    </div>";
                }
            } else {
                
                echo "<p class='text-center text-warning'>No cars available for the selected location.</p>";
            }
        } else {
            
            echo "<p class='text-center text-danger'>There was an error fetching the data. Please try again later.</p>";
        }
        ?>
        </div>
    </div>


    
</body>
</html>
