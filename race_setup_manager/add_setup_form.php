<!DOCTYPE html>
<html>
    <head>
        <title>Add RACE SETUP</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>
    
    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Add New Race Setup</h2>

            <form action="add_setup.php" method="post">

                <label>Track Name:</label>
                <input type="text" name="trackName" required>

                <label>Race Date:</label>
                <input type="date" name="raceDate" required>

                <label>LF Pressure (PSI):</label>
                <input type="text" name="tirePressureLF" required>
                
                <label>RF Pressure (PSI):</label>
                <input type="text" name="tirePressureRF" required>
                
                <label>LR Pressure (PSI):</label>
                <input type="text" name="tirePressureLR" required>
                
                <label>RR Pressure (PSI):</label>
                <input type="text" name="tirePressureRR" required>

                <br>
                <input type="submit" value="Add Setup">
            </form>

            <p><a href="index.php">View Race Setup List</a></p>

        </main>

    </body>
</html>


                
                
