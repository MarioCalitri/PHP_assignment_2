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
            
            <div id="buttons">
                <label>&nbsp;</label>
                <form action="index.php" method="get" style="display: inline;">
                    <input type="submit" value="View Crew Chief Profiles" />
                </form>
            </div>
        
        </main>

        <?php include("footer.php"); ?>
    </body>
</html>
