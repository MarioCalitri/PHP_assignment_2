<?php 

    session_start(); 
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title>CREW CHIEF - Add error</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>
    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>CREW CHIEF - Add error</h2>

            <p>Error Message: <?php echo $_SESSION["add_error"]; ?></p>
            <p><a href="profiles.php">Return to Add Profile Form</a></p>
        
        </main>

        <?php include("footer.php"); ?> 
     </body>
</html>
   