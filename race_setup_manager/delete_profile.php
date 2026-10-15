<?php
    session_start();

    $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_VALIDATE_INT);

    if ($profile_id) {
        require_once("database.php");

        // fetch image name for profile
        $queryGet = 'SELECT imageName FROM profiles WHERE profileID = :profile_id';
        $statement = $db->prepare($queryGet);
        $statement->bindValue(':profile_id', $profile_id);
        $statement->execute();
        $profile = $statement->fetch();
        $statement->closeCursor();

        if ($profile && !empty($profile['imageName'])) {
            $image_name = $profile['imageName'];
            $base_dir = 'images/';

            // check if profile uses this same imageName
            $queryCheck = 'SELECT COUNT(*) FROM profiles WHERE imageName = :image_name AND profileID != :profile_id';
            $statementCheck = $db->prepare($queryCheck);
            $statementCheck->bindValue(':image_name', $image_name);
            $statementCheck->bindValue(':profile_id', $profile_id);
            $statementCheck->execute();
            $count = $statementCheck->fetchColumn();
            $statementCheck->closeCursor();

            // only delete files if no other profile shares the image
            if ($count == 0 && strpos($image_name, 'placeholder') === false) {
                $pos_100 = strrpos($image_name, '_100');
                if ($pos_100 !== false) {
                    $base_name = substr($image_name, 0, $pos_100);
                    $ext = substr($image_name, strrpos($image_name, '.'));

                    $file_orig = $base_name . $ext;
                    $file_100  = $base_name . '_100' . $ext;
                    $file_400  = $base_name . '_400' . $ext;

                    foreach ([$file_orig, $file_100, $file_400] as $file) {
                        $file_path = $base_dir . $file;
                        if (file_exists($file_path)) {
                            @unlink($file_path);
                        }
                    }
                }
            }
        }

        // delete profile
        $queryDelete = 'DELETE FROM profiles WHERE profileID = :profile_id';
        $statement = $db->prepare($queryDelete);
        $statement->bindValue(':profile_id', $profile_id);
        $statement->execute();
        $statement->closeCursor();
    }

    header("Location: profiles.php");
    exit();
?>