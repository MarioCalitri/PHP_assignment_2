<?php
    session_start();
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Crew Chief - Update ERROR</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>
    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Crew Chief - Update ERROR</h2>

            <p>Error Message: <?php echo $_SESSION["update_error"]; ?></p>
            <p><a href="profiles.php">View Profile List</a></p>
        </main>

        <?php include("footer.php"); ?>
    </body>
</html>