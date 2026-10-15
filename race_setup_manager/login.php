<?php 
    session_start();
    date_default_timezone_set("America/Toronto");

    require_once("database.php");

    $user_name = filter_input(INPUT_POST, 'username');
    $user_password = filter_input(INPUT_POST, 'password');

    $queryUsers = 'SELECT * FROM registrations WHERE userName = :user_name';

    $statement = $db->prepare($queryUsers);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if ($user) 
    {
        $now = new DateTime();

        // check whether the account is currently locked
        if ($user['failedAttempts'] >= 3 && $user['lastFailedLogin'] !== NULL)
        {
            $last_failed = new DateTime($user['lastFailedLogin']);
            $interval = $now->getTimestamp() - $last_failed->getTimestamp();

            if ($interval < 10)
            {
                $remaining = 10 - $interval;
                $_SESSION['login_error'] = "Account locked. Try again in " . ceil($remaining) . " second(s).";
                header("Location: login_form.php");
                exit();
            }
        }

        // verify the password
        if (password_verify($user_password, $user['password'])) 
        {
            // Login successful
            $_SESSION['isLoggedIn'] = TRUE;

            $query = "UPDATE registrations
                      SET failedAttempts = 0,
                          lastFailedLogin = NULL
                      WHERE userName = :userName";

            $statement = $db->prepare($query);
            $statement->bindValue(':userName', $user_name);
            $statement->execute();
            $statement->closeCursor();

            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['user_name'] = $user['userName'];
            $_SESSION['username'] = $user['userName'];

            header("Location: index.php");
            exit();
        }    
        else
        {
            // failed-attempt counter
            $query = "UPDATE registrations
                      SET failedAttempts = COALESCE(failedAttempts, 0) + 1,
                          lastFailedLogin = NOW()
                      WHERE userName = :userName";

            $statement = $db->prepare($query);
            $statement->bindValue(':userName', $user_name);
            $statement->execute();
            $statement->closeCursor();

            // check updated attempts
            $statement = $db->prepare($queryUsers);
            $statement->bindValue(':user_name', $user_name);
            $statement->execute();
            $updatedUser = $statement->fetch();
            $statement->closeCursor();

            if ($updatedUser['failedAttempts'] >= 3)
            {
                $_SESSION['login_error'] = "Account locked. Try again in 300 second(s).";
            }
            else
            {
                $_SESSION['login_error'] = "Incorrect Password";
            }

            header("Location: login_form.php");
            exit();
        }
    }
    else
    {
        $_SESSION['login_error'] = "User not found.";
        header("Location: login_form.php");
        exit();
    }
?>

<?php
    session_start();
    
    $user_name = filter_input(INPUT_POST, 'username');
    $user_password = filter_input(INPUT_POST, 'password');
    $email_address = filter_input(INPUT_POST, 'email_address');

    if ($user_name == null || $user_password == null || $email_address == null) {
        $_SESSION["user_error"] = "Invalid user data, check all fields and try again.";
        $url = "user_error.php";
        header("Location: " . $url);
        die();
    }

    $hash = password_hash($user_password, PASSWORD_DEFAULT);

    require_once("database.php");

    $queryUsers = 'SELECT * FROM registrations';
    $statement = $db->prepare($queryUsers);
    $statement->execute();
    $users = $statement->fetchAll();
    $statement->closeCursor(); 

    foreach ($users as $user) {
        if ($user_name == $user["userName"]) {
            $_SESSION["user_error"] = "Invalid data, duplicate Username. Try again.";
            $url = "user_error.php";
            header("Location: " . $url);
            die();
        }
    }

    // add Registration
    $query = 'INSERT INTO registrations (userName, password, emailAddress)
        VALUES (:userName, :password, :emailAddress)';

    $statement = $db->prepare($query);
    $statement->bindValue(':userName', $user_name);
    $statement->bindValue(':password', $hash);
    $statement->bindValue(':emailAddress', $email_address);    

    $statement->execute();    
    $statement->closeCursor();

    $_SESSION["username"] = $user_name; 
    $_SESSION["isLoggedIn"] = 1;

    $url = "register_user_confirmation.php";
    header("Location: " . $url);
    die();
?>
