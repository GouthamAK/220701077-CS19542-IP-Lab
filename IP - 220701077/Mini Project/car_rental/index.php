<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Include Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container text-center mt-5">
        <h1 class="mb-3">Welcome to Car Rental</h1>
        <p>Find your perfect ride today!</p>
        <form action="search.php" method="GET" class="form-inline justify-content-center mt-4">
            <input type="text" name="location" class="form-control mr-2" placeholder="Location" required>
            <input type="date" name="start_date" class="form-control mr-2" required>
            <input type="date" name="end_date" class="form-control mr-2" required>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    
</body>
</html>
