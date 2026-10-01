<?php session_start(); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add New Crew Chief Profile</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>
    
    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Add New Crew Chief Profile</h2>

            <form action="add_profile.php" method="post">
                <label>First Name:</label>
                <input type="text" name="first_name" required>

                <label>Last Name:</label>
                <input type="text" name="last_name" required>

                <label>Team Name:</label>
                <input type="text" name="team_name" required>

                <label>Email Address:</label>
                <input type="email" name="email_address" required>

                <input type="submit" value="Save Profile">
            </form>

            <p><a href="index.php" class="btn-add">Crew Chief Dashboard</a></p>
        
        </main>

        <?php include("footer.php"); ?>

    </body>
</html>