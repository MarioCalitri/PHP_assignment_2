<?php

    session_start();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>CREW CHIEF PROFILE ADDED</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css?" />
    </head>

    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>CREW CHIEF PROFILE ADDED</h2>

            <p>Profile for <?php echo $_SESSION["fullName"]; ?> has been added successfully.</p>
            <p><a href="profiles.php">View Crew Chief Profiles</a></p>
        
        </main>
        <?php include("footer.php"); ?>
    </body>
</html>