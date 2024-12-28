<?php include 'fetch_leasedata.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Land</title>
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
        <h2>Input Land</h2>
        <form action="submit_land.php" method="POST">
            <label for="land_name">Land Name:</label>
            <input type="text" id="land_name" name="land_name" required>

            <label for="land_size">Land Size (sqm):</label>
            <input type="number" id="land_size" name="land_size" step="0.01" required>

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