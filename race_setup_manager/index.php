<?php

    require("database.php");

    $querySetups = 'SELECT * FROM setups';

    $statementSetups = $db->prepare($querySetups);
    $statementSetups->execute();
    $setups = $statementSetups->fetchAll();
    $statementSetups->closeCursor();

?>

<!DOCTYPE html>

<html>

<head>
    <title>Crew Chief Race Setup Log</title>
    <link rel="stylesheet" type="text/css" href="css/setup.css?v=99" />
</head>

    <body>

        <?php include("header.php"); ?>

        <main>
            <h2>Race Setup Logs</h2>

            <table>
                <tr>
                    <th>Track Name</th>
                    <th>Race Date</th>
                    <th>LF PSI</th>
                    <th>RF PSI</th>
                    <th>LR PSI</th>
                    <th>RR PSI</th>
                </tr>

            <?php foreach ($setups as $setup) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($setup['trackName']); ?></td>
                    <td><?php echo htmlspecialchars($setup['raceDate']); ?></td>
                    <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureLF'])) . ' PSI'; ?></td>
                    <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureRF'])) . ' PSI'; ?></td>
                    <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureLR'])) . ' PSI'; ?></td>
                    <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureRR'])) . ' PSI'; ?></td>
                </tr>

                <?php endforeach; ?>
            
            </table>

                <p><a href="add_setup_form.php">Add New Race Setup</a></p>

        </main>
        
        <?php include("footer.php"); ?>


    </body>

