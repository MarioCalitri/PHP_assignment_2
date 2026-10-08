<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add New Driver Profile</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>
    
    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Add New DriverProfile</h2>

            <form action="add_profile.php" method="post" enctype="multipart/form-data">
                <label>First Name:</label>
                <input type="text" name="first_name" required><br>

                <label>Last Name:</label>
                <input type="text" name="last_name" required><br>

                <label>Team Name:</label>
                <input type="text" name="team_name" required><br>

                <label>Email Address:</label>
                <input type="email" name="email_address" required><br>

                <label>Car Type:</label>
                <select name="car_type" required>
                    <option value="Pure Stock">Pure Stock</option>
                    <option value="Mini Stock">Mini Stock</option>
                    <option value="Late Model">Late Model</option>
                </select><br>

                <div class="form-group">
                    <label>IMAGE:</label><br>
                    <img id="currentImage" 
                        src="images/placeholder_100.jpg" 
                        alt="Profile Image" 
                        style="max-width: 100px; height: auto; border-radius: 6px; margin-top: 5px;" 
                        onerror="this.src='images/placeholder_100.jpg';">
                </div>

                <div class="form-group">
                    <label>UPLOAD IMAGE:</label><br>
                    <input type="file" name="file1" accept="image/*" onchange="previewImage(event)">
                </div>

                <input type="submit" value="Save Profile">
            </form>

            <p><a href="index.php" class="btn-add">Crew Chief - Dashboard</a></p>
        
        </main>

        <?php include("footer.php"); ?>

        <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('currentImage');
                    if (img) {
                        img.src = e.target.result;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>
    </body>
</html>