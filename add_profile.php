<?php
    session_start();

    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $team_name = filter_input(INPUT_POST, 'team_name');
    $email_address = filter_input(INPUT_POST, 'email_address');
    $car_type = filter_input(INPUT_POST, 'car_type');
    $image = isset($_FILES['file1']) ? $_FILES['file1'] : null;

    require_once("database.php");
    require_once(__DIR__ . '/image_util.php');

    $base_dir = 'images/';

    $queryProfiles = 'SELECT * FROM profiles';
    $statement = $db->prepare($queryProfiles);
    $statement->execute();
    $profiles = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($profiles as $profile) {
        if ($profile['emailAddress'] === $email_address) {
            $_SESSION['add_error'] = "Email address already exists. Please use a different email address.";
            header("Location: add_error.php");
            die();
        }
    }

    if ($first_name == null || $last_name == null || $team_name == null || $email_address == null || $car_type == null) {
        $_SESSION['add_error'] = "Invalid profile data. Check all fields and try again.";
        header("Location: add_error.php");
        die();
    }

    $image_name = 'placeholder_100.jpg'; // default

    if ($image && isset($image['error']) && $image['error'] === UPLOAD_ERR_OK && !empty($image['name'])) {
        $original_filename = basename($image['name']);
        $upload_path = $base_dir . $original_filename;
        
        if (move_uploaded_file($image['tmp_name'], $upload_path)) {
            process_image($base_dir, $original_filename);

            $dot_pos = strrpos($original_filename, '.');
            if ($dot_pos !== false) {
                $name = substr($original_filename, 0, $dot_pos);
                $ext = substr($original_filename, $dot_pos);
                $image_name = $name . '_100' . $ext;
            } else {
                $image_name = $original_filename . '_100';
            }
        }
    }

    // insert statement
    $query = 'INSERT INTO profiles (firstName, lastName, teamName, emailAddress, carType, imageName) 
              VALUES (:firstName, :lastName, :teamName, :emailAddress, :carType, :imageName)';
    
    $statement = $db->prepare($query);
    $statement->bindValue(':firstName', $first_name);
    $statement->bindValue(':lastName', $last_name);
    $statement->bindValue(':teamName', $team_name);
    $statement->bindValue(':emailAddress', $email_address);
    $statement->bindValue(':carType', $car_type);
    $statement->bindValue(':imageName', $image_name);

    $statement->execute();
    $statement->closeCursor();

    $_SESSION["fullName"] = $first_name . " " . $last_name;
    header("Location: add_profile_confirmation.php");
    die();
?>