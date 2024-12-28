<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Maintenance</title>
    <link rel="stylesheet" href="CSS/maintenance.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo-container">
                <img src="logo.png" alt="SHMACK Logo" class="logo">
                <h1>SHMACK</h1>
            </div>
            <nav class="navbar">
                <ul class="navbar-list">
                    <li class="navbar-item"><a href="index.html" class="navbar-link">Home</a></li>
                    <li class="navbar-item"><a href="imprint.html" class="navbar-link">Imprint</a></li>
                    <li class="navbar-item"><a href="services.html" class="navbar-link">Services</a></li>
                    <li class="navbar-item"><a href="contact.html" class="navbar-link">Contact Us</a></li>
                    <li class="navbar-item"><a href="logout.php" class="navbar-link">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <section class="maintenance">
        <h2>Data Maintenance</h2>
        <div class="cards-container">
            <div class="card">
                <h3>Cost Center</h3>
                <p>Manage cost center data for the company.</p>
                <a href="input_costcenter.html" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>Subsidiary</h3>
                <p>Manage subsidiary data.</p>
                <a href="input_subsidiary.html" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>Lease</h3>
                <p>Manage lease contracts and details.</p>
                <a href="input_lease.php" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>User</h3>
                <p>Manage user information.</p>
                <a href="input_user.php" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>Vehicle</h3>
                <p>Manage vehicle lease information.</p>
                <a href="input_vehicle.php" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>Apartment</h3>
                <p>Manage apartment lease data.</p>
                <a href="input_apartment.php" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>Office</h3>
                <p>Manage office lease details.</p>
                <a href="input_office.php" class="btn">Go to Form</a>
            </div>
            <div class="card">
                <h3>Land</h3>
                <p>Manage land lease records.</p>
                <a href="input_land.php" class="btn">Go to Form</a>
            </div>
        </div>
    </section>

    <!-- Query Sections with Autocomplete -->
    <section class="query-section">
        <h2>Search Subsidiaries</h2>
        <form action="ResultsSubsidiary.php" method="POST">
            <label for="Subsidiary_Name">Subsidiary Name:</label>
            <input type="text" id="Subsidiary_Name" name="Subsidiary_Name" required>
            <input type="submit" value="Search">
        </form>
    </section>

    <section class="query-section">
        <h2>Search Apartments by City</h2>
        <form action="ResultsApartment.php" method="POST">
            <label for="City">City:</label>
            <input type="text" id="Apartment_location" name="Apartment_location" required>
            <input type="submit" value="Search">
        </form>
    </section>

    <section class="query-section">
        <h2>Search Leases</h2>
        <form action="ResultsLease.php" method="POST">
            <label for="CostCenter_Name">Cost Center Name:</label>
            <input type="text" id="CostCenter_Name" name="CostCenter_Name" required>
            <label for="Lease_start_date">Start Date (From):</label>
            <input type="date" name="Lease_start_date">
            <label for="Lease_termination_date">End Date (To):</label>
            <input type="date" name="Lease_termination_date">
            <input type="submit" value="Search">
        </form>
    </section>

    <section class="query-section">
        <h2>Search Vehicles by Lease Status and Subsidiary</h2>
        <form action="ResultsVehicle.php" method="POST">
            <label for="Subsidiary_Name">Subsidiary Name:</label>
            <input type="text" id="Vehicle_Subsidiary_Name" name="Subsidiary_Name" required>
            <label for="Lease_Status">Lease Status:</label>
            <select name="Lease_Status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
            <input type="submit" value="Search">
        </form>
    </section>

    <section class="query-section">
        <h2>View Maximum Budget Allocated</h2>
        <form action="ResultsMaxBudget.php" method="GET">
            <button type="submit">Show Maximum Budget</button>
        </form>
    </section>

    <section class="query-section">
        <h2>View Leases Above Average Monthly Cost</h2>
        <form action="Results_leases_above_avg.php" method="GET">
            <button type="submit">Show Leases Above Average</button>
        </form>
    </section>

    <script>
        $(document).ready(function() {
            // Autocomplete for Subsidiary Name
            $("#Subsidiary_Name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete_data.php",
                        method: "GET",
                        data: { term: request.term, type: "subsidiary" },
                        success: function(data) {
                            response(JSON.parse(data));
                        }
                    });
                }
            });

            // Autocomplete for Apartment Location (City)
            $("#Apartment_location").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete_data.php",
                        method: "GET",
                        data: { term: request.term, type: "apartment" },
                        success: function(data) {
                            response(JSON.parse(data));
                        }
                    });
                }
            });

            // Autocomplete for Cost Center Name
            $("#CostCenter_Name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete_data.php",
                        method: "GET",
                        data: { term: request.term, type: "costcenter" },
                        success: function(data) {
                            response(JSON.parse(data));
                        }
                    });
                }
            });
        });
    </script>

    <footer>
        <p>&copy; 2024 SHMACK. All rights reserved.</p>
        <a href="imprint.html">Imprint</a>
    </footer>
</body>
</html>
