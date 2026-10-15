<?php
    session_start();
    require_once("database.php");

    $setup_id = filter_input(INPUT_POST, 'setup_id', FILTER_VALIDATE_INT);
    $track_name = filter_input(INPUT_POST, 'trackName');
    $race_date = filter_input(INPUT_POST, 'raceDate');
    $tire_lf = filter_input(INPUT_POST, 'tirePressureLF');
    $tire_rf = filter_input(INPUT_POST, 'tirePressureRF');
    $tire_lr = filter_input(INPUT_POST, 'tirePressureLR');
    $tire_rr = filter_input(INPUT_POST, 'tirePressureRR');

    if (!$setup_id || $track_name == null || $race_date == null || $tire_lf == null || $tire_rf == null || $tire_lr == null || $tire_rr == null) {
        $_SESSION["error"] = "Invalid setup data. Check all fields and try again.";
        header("Location: index.php");
        exit();
    }

    $query = 'UPDATE setups
              SET trackName = :track_name,
                  raceDate = :race_date,
                  tirePressureLF = :tire_lf,
                  tirePressureRF = :tire_rf,
                  tirePressureLR = :tire_lr,
                  tirePressureRR = :tire_rr
              WHERE setupID = :setup_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':track_name', $track_name);
    $statement->bindValue(':race_date', $race_date);
    $statement->bindValue(':tire_lf', $tire_lf);
    $statement->bindValue(':tire_rf', $tire_rf);
    $statement->bindValue(':tire_lr', $tire_lr);
    $statement->bindValue(':tire_rr', $tire_rr);
    $statement->bindValue(':setup_id', $setup_id);

    $statement->execute();
    $statement->closeCursor();

    header("Location: index.php");
    exit();
?>