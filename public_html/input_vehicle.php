<?php include 'fetch_leasedata.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Vehicle</title>
    <link rel="stylesheet" href="CSS/formstyle.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="SHMACK Logo" class="logo">
            <h1>SHMACK</h1>
        </div>
        <nav class="navbar">
            <ul class="navbar-list">
                <li class="navbar-item"><a href="index.html" class="navbar-link">Home</a></li>
                <li class="navbar-item"><a href="imprint.html" class="navbar-link">Imprint</a></li>
                <li class="navbar-item"><a href="services.html" class="navbar-link">Services</a></li>
                <li class="navbar-item"><a href="contact.html" class="navbar-link">Contact Us</a></li>
                <li class="navbar-item"><a href="login.html" class="navbar-link">Maintenance</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="entity-input">
        <h2>Input Vehicle</h2>
        <form action="submit_vehicle.php" method="POST">
            <label for="vehicle_model">Vehicle Model:</label>
            <input type="text" id="vehicle_model" name="vehicle_model" required>

            <label for="vehicle_name">Vehicle Name:</label>
            <input type="text" id="vehicle_name" name="vehicle_name" required>

            <label for="Lease_ID">Select Lease:</label>
            <select id="Lease_ID" name="Lease_ID" required>
                <option value="">Select a lease</option>
                <?php echo $lease_options; // Echo the options generated by fetch_leasedata.php ?>
            </select>

            <input type="submit" value="Submit">
        </form>
    </section>
</body>
</html>
