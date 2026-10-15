<?php
    session_start();
    require_once("database.php");

    $setup_id = filter_input(INPUT_POST, 'setup_id', FILTER_VALIDATE_INT);

    if ($setup_id) {
        $query = 'DELETE FROM setups WHERE setupID = :setup_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':setup_id', $setup_id);
        $statement->execute();
        $statement->closeCursor();
    }

    header("Location: index.php");
    exit();
?>