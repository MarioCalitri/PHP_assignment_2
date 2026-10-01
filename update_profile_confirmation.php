<?php

    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update Crew Chief Profile</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head> 

    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Update Crew Chief Profile</h2>

            <p>Profile for <?php echo $_SESSION["fullName"]; ?> has been updated successfully.</p>
            <p><a href="profiles.php">View Crew Chief Profiles</a></p>
        
        </main>

        <?php include("footer.php"); ?>
    </body>
</html>
