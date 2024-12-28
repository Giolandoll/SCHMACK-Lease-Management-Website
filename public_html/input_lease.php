<?php include 'fetch_data.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Lease</title>
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
        <h2>Input Lease</h2>
        <form action="submit_lease.php" method="POST">
            <label for="lease_start_date">Start Date:</label>
            <input type="date" id="lease_start_date" name="lease_start_date" required>

            <label for="lease_termination_date">Termination Date:</label>
            <input type="date" id="lease_termination_date" name="lease_termination_date">

            <label for="yearly_cost">Yearly Cost:</label>
            <input type="number" id="yearly_cost" name="yearly_cost" step="0.01" required>

            <label for="monthly_cost">Monthly Cost:</label>
            <input type="number" id="monthly_cost" name="monthly_cost" step="0.01" required>

            <label for="terminated_lease">Terminated Lease:</label>
            <input type="checkbox" id="terminated_lease" name="terminated_lease">

            <!-- Dropdown for Cost Center -->
            <div class="form-group">
                <label for="costcenter_id">Select Cost Center:</label>
                <select id="costcenter_id" name="costcenter_id" required>
                    <option value="">Select</option>
                    <?php echo $costcenter_options; ?>
                </select>
            </div>

            <!-- Dropdown for Subsidiary -->
            <div class="form-group">
                <label for="subsidiary_id">Select Subsidiary:</label>
                <select id="subsidiary_id" name="subsidiary_id" required>
                    <option value="">Select</option>
                    <?php echo $subsidiary_options; ?>
                </select>
            </div>

            <input type="submit" value="Submit">
        </form>
    </section>
</body>
</html>
