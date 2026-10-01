<?php
    session_start();

    $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_VALIDATE_INT);
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
        if ($profile['emailAddress'] === $email_address && $profile_id != $profile['profileID']) {
            $_SESSION['update_error'] = "Email address already exists. Please use a different email address.";
            $url = "update_error.php";
            header("Location: " . $url);
            die();
        }
    }

    if ($first_name == null || $last_name == null || $team_name == null || $email_address == null) {
        $_SESSION["update_error"] = "Invalid profile data. Check all fields and try again.";
        $url = "update_error.php";
        header("Location: " . $url);
        die();
    }

    $query = 'UPDATE profiles
              SET firstName = :first_name,
                  lastName = :last_name,
                  teamName = :team_name,
                  emailAddress = :email_address
              WHERE profileID = :profile_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':team_name', $team_name);
    $statement->bindValue(':email_address', $email_address);
    $statement->bindValue(':profile_id', $profile_id);

    $statement->execute();
    $statement->closeCursor();

    $_SESSION["fullName"] = $first_name . " " . $last_name;
    $url = "update_profile_confirmation.php";
    header("Location: " . $url);
    die();
?>