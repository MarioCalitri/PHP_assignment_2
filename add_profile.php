<?php
    session_start();

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $team_name = filter_input(INPUT_POST, 'team_name');
    $email_address = filter_input(INPUT_POST, 'email_address');

    require_once("database.php");

    $queryProfiles = 'SELECT * FROM profiles';

    $statement = $db->prepare($queryProfiles);
    $statement->execute();
    $profiles = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($profiles as $profile) {
        if ($profile['emailAddress'] === $email_address) {
            $_SESSION['add_error'] = "Email address already exists. Please use a different email address.";
            $url = "add_error.php";
            header("Location: " . $url);
            die();
        }
    }

    if ($first_name == null || $last_name == null || $team_name == null || $email_address == null) {
        $_SESSION['add_error'] = "Invalid profile data. Check all fields and try again.";
        $url = "add_error.php";
        header("Location: " . $url);
        die();
    }

    $query = 'INSERT INTO profiles (firstName, lastName, teamName, emailAddress) 
              VALUES (:firstName, :lastName, :teamName, :emailAddress)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $first_name);
    $statement->bindValue(':lastName', $last_name);
    $statement->bindValue(':teamName', $team_name);
    $statement->bindValue(':emailAddress', $email_address);

    $statement->execute();
    $statement->closeCursor();

    $_SESSION["fullName"] = $first_name . " " . $last_name;
    $url = "index.php";
    header("Location: " . $url);
    die();
?>