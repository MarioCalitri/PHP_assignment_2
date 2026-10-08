<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();

    $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_VALIDATE_INT);
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');
    $team_name = filter_input(INPUT_POST, 'team_name');
    $email_address = filter_input(INPUT_POST, 'email_address');
    $car_type = filter_input(INPUT_POST, 'car_type');
    $image = isset($_FILES['file1']) ? $_FILES['file1'] : null;

    require_once("database.php");
    require_once(__DIR__ . '/image_util.php');

    $queryCurrent = 'SELECT * FROM profiles WHERE profileID = :profile_id';
    $statement = $db->prepare($queryCurrent);
    $statement->bindValue(':profile_id', $profile_id);
    $statement->execute();
    $current_profile = $statement->fetch();
    $statement->closeCursor();

    $old_image_name = isset($current_profile['imageName']) ? $current_profile['imageName'] : 'placeholder_100.jpg';
    $base_dir = 'images/';
    $image_name = $old_image_name; // keeps existing image if no new file uploaded

    $queryProfiles = 'SELECT * FROM profiles';
    $statement = $db->prepare($queryProfiles);
    $statement->execute();
    $profiles = $statement->fetchAll();
    $statement->closeCursor();

    foreach ($profiles as $profile) {
        if (isset($profile['emailAddress']) && $profile['emailAddress'] === $email_address && $profile_id != $profile['profileID']) {
            $_SESSION['update_error'] = "Email address already exists. Please use a different email address.";
            header("Location: update_error.php");
            die();
        }
    }

    if ($first_name == null || $last_name == null || $team_name == null || $email_address == null || $car_type == null) {
        $_SESSION["update_error"] = "Invalid profile data. Check all fields and try again.";
        header("Location: update_error.php");
        die();
    }

    // updated image upload if a new file was actually selected
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

            // clean up previous custom images if not placeholder
            if (!empty($old_image_name) && strpos($old_image_name, 'placeholder') === false) {    
                $pos_100 = strpos($old_image_name, '_100');
                if ($pos_100 !== false) {
                    $old_base = substr($old_image_name, 0, $pos_100);
                    $old_ext = substr($old_image_name, strrpos($old_image_name, '.'));
                    
                    $original = $old_base . $old_ext;
                    $img100 = $old_base . '_100' . $old_ext;
                    $img400 = $old_base . '_400' . $old_ext;    
                    
                    foreach ([$original, $img100, $img400] as $file) {
                        $path = $base_dir . $file;
                        if (file_exists($path)) {
                            @unlink($path);
                        }
                    }
                }
            }
        }
    }

    // update profile in database
    $query = 'UPDATE profiles
              SET firstName = :first_name,
                  lastName = :last_name,
                  teamName = :team_name,
                  emailAddress = :email_address,
                  carType = :car_type,
                  imageName = :image_name
              WHERE profileID = :profile_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':team_name', $team_name);
    $statement->bindValue(':email_address', $email_address);
    $statement->bindValue(':car_type', $car_type);
    $statement->bindValue(':image_name', $image_name);
    $statement->bindValue(':profile_id', $profile_id);

    $statement->execute();
    $statement->closeCursor();

    $_SESSION["fullName"] = $first_name . " " . $last_name;
    header("Location: update_profile_confirmation.php");
    die();
?>