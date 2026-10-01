<?php
    require_once("database.php");

    $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_VALIDATE_INT);

    if ($profile_id != NULL && $profile_id != FALSE) {
        $queryDelete = 'DELETE FROM profiles WHERE profileID = :profile_id';

        $statement = $db->prepare($queryDelete);
        $statement->bindValue(':profile_id', $profile_id);
        $statement->execute();
        $statement->closeCursor();
    }

    $url = "profiles.php";
    header("Location: " . $url);
    die();  
?>