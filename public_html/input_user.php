<?php include 'fetch_data.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input User</title>
    <link rel="stylesheet" href="CSS/formstyle.css">
    <script>
        function toggleCostCenter() {
            const isCostCenterRelevant = document.querySelector('input[name="costcenter_relevant"]:checked').value;
            const costCenterContainer = document.getElementById("costcenter-container");
            costCenterContainer.style.display = isCostCenterRelevant === "yes" ? "block" : "none";
        }
    </script>
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
        <h2>New User Creation:</h2>
        <form action="submit_user.php" method="POST" class="form-style">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="Name" name="Name" required>
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="Email" id="Email" name="Email" required>
            </div>
            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" id="Address" name="Address" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" id="Role" name="Role" required>
            </div>
            <div class="form-group">
                <label for="PermissionsRights">Permissions/Rights:</label>
                <input type="text" id="PermissionsRights" name="PermissionsRights" required>
            </div>
            <div class="form-group">
                <label for="Subsidiary_ID">Select Subsidiary:</label>
                <select id="Subsidiary_ID" name="Subsidiary_ID" required>
                    <option value="">Select</option>
                    <?php echo $subsidiary_options; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="costcenter_relevant">Is the User associated with a Cost Center?</label><br>
                <input type="radio" id="costcenter_yes" name="costcenter_relevant" value="yes" onchange="toggleCostCenter()" required> Yes
                <input type="radio" id="costcenter_no" name="costcenter_relevant" value="no" onchange="toggleCostCenter()" required> No
            </div>
            <div id="costcenter-container" class="form-group" style="display: none;">
                <label for="CostCenter_ID">Select Cost Center:</label>
                <select id="CostCenter_ID" name="Costcenter_ID" required>
                    <option value="">Select</option>
                    <?php echo $costcenter_options; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Submit" class="submit-button">
            </div>
        </form>
    </section>
</body>
</html>
