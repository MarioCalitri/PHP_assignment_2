<?php
    require_once("database.php");

    $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_VALIDATE_INT);

    $queryProfile = 'SELECT * FROM profiles WHERE profileID = :profile_id';

    $statement = $db->prepare($queryProfile);
    $statement->bindValue(':profile_id', $profile_id);
    $statement->execute();
    $profile = $statement->fetch();
    $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Edit Crew Chief Profile</title>
        <link rel="stylesheet" type="text/css" href="css/setup.css" />
    </head>

    <body>
        <?php include("header.php"); ?>

        <main>
            <h2>Edit Crew Chief Profile</h2>

            <form action="update_profile.php" method="post" id="update_profile_form">

                <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>" />

                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($profile['firstName']); ?>" /><br />

                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($profile['lastName']); ?>" /><br />

                <label>Team Name:</label>
                <input type="text" name="team_name" value="<?php echo htmlspecialchars($profile['teamName']); ?>" /><br />

                <label>Email Address:</label>
                <input type="text" name="email_address" value="<?php echo htmlspecialchars($profile['emailAddress']); ?>" /><br />

                <br>
                <input type="submit" value="Update Profile" /><br />

            </form>

            <p><a href="profiles.php">View Crew Chief Profiles</a></p>
        
        </main>

        <?php include("footer.php"); ?>
    </body>
</html>