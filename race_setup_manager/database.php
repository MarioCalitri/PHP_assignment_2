<?php
    session_start();
    $dsn = 'mysql:host=localhost;dbname=race_setup_2026';
    $username = 'root';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    }
    catch (PDOException $e) {
        $_SESSION["database error"] = $e->getMessage();
        $url = "database_error.php";
        header("Location: ". $url);
        exit();
    }
?>
