<?php

require("database.php");

$trackName = filter_input(INPUT_POST, 'trackName');
$tirePressureLF = filter_input(INPUT_POST, 'tirePressureLF');
$tirePressureRF = filter_input(INPUT_POST, 'tirePressureRF');
$tirePressureLR = filter_input(INPUT_POST, 'tirePressureLR');
$tirePressureRR = filter_input(INPUT_POST, 'tirePressureRR');
$raceDate = filter_input(INPUT_POST, 'raceDate');

if ($trackName == NULL || $tirePressureLF == NULL || $tirePressureRF == NULL || $tirePressureLR == NULL || $tirePressureRR == NULL || $raceDate == NULL) {
    $error = "Invalid data. Check all fields and try again.";
    echo $error;
} else {
    $query = 'INSERT INTO setups (trackName, tirePressureLF, tirePressureRF, tirePressureLR, tirePressureRR, raceDate)
              VALUES (:trackName, :tirePressureLF, :tirePressureRF, :tirePressureLR, :tirePressureRR, :raceDate)'; 

    $statement = $db->prepare($query);
    $statement->bindValue(':trackName', $trackName);
    $statement->bindValue(':tirePressureLF', $tirePressureLF);
    $statement->bindValue(':tirePressureRF', $tirePressureRF);
    $statement->bindValue(':tirePressureLR', $tirePressureLR);
    $statement->bindValue(':tirePressureRR', $tirePressureRR);
    $statement->bindValue(':raceDate', $raceDate);
    $statement->execute();
    $statement->closeCursor();

    header("Location: index.php");

}
?>