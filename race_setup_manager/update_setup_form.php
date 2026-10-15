<?php
    session_start();
    require_once("database.php");

    $setup_id = filter_input(INPUT_POST, 'setup_id', FILTER_VALIDATE_INT);
    if (!$setup_id) {
        $setup_id = filter_input(INPUT_GET, 'setup_id', FILTER_VALIDATE_INT);
    }

    if (!$setup_id) {
        header("Location: index.php");
        exit();
    }

    $query = 'SELECT * FROM setups WHERE setupID = :setup_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':setup_id', $setup_id);
    $statement->execute();
    $setup = $statement->fetch();
    $statement->closeCursor();

    if (!$setup) {
        header("Location: index.php");
        exit();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Update Race Setup</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>
    
    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Update Race Setup</h2>

            <p>Current Logged In User: <?php echo htmlspecialchars($_SESSION["user_name"] ?? $_SESSION["username"] ?? 'Guest'); ?></p>

            <form action="update_setup.php" method="post">
                <input type="hidden" name="setup_id" value="<?php echo $setup['setupID']; ?>">

                <label>Track Name:</label>
                <input type="text" name="trackName" value="<?php echo htmlspecialchars($setup['trackName']); ?>" required>

                <label>Race Date:</label>
                <input type="date" name="raceDate" value="<?php echo htmlspecialchars($setup['raceDate']); ?>" required>

                <label>LF Pressure (PSI):</label>
                <input type="text" name="tirePressureLF" value="<?php echo htmlspecialchars($setup['tirePressureLF']); ?>" required>
                
                <label>RF Pressure (PSI):</label>
                <input type="text" name="tirePressureRF" value="<?php echo htmlspecialchars($setup['tirePressureRF']); ?>" required>
                
                <label>LR Pressure (PSI):</label>
                <input type="text" name="tirePressureLR" value="<?php echo htmlspecialchars($setup['tirePressureLR']); ?>" required>
                
                <label>RR Pressure (PSI):</label>
                <input type="text" name="tirePressureRR" value="<?php echo htmlspecialchars($setup['tirePressureRR']); ?>" required>

                <br>
                <input type="submit" value="Update Setup">
            </form>

            <p><a href="index.php" class="btn-add">Dashboard</a></p>
        </main>
        <?php include("footer.php"); ?>
    </body>
</html>