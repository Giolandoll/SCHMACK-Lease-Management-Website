<?php
session_start();
include 'config.php'; // Ensure database configuration is included

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
    <title>Data Maintenance with Autocomplete</title>
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

    <section class="query-section">
        <h2>Search Subsidiaries</h2>
        <form action="ResultsSubsidiary.php" method="POST">
            <label for="Subsidiary_Name">Subsidiary Name:</label>
            <input type="text" id="Subsidiary_Name" name="Subsidiary_Name" required>
            <input type="submit" value="Search">
        </form>
    </section>

    <script>
        $(document).ready(function() {
            // Initialize autocomplete for Subsidiary Name field
            $("#Subsidiary_Name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "autocomplete_data.php", // Link to server-side script for data
                        method: "GET",
                        data: { term: request.term },
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
