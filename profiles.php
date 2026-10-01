<?php 
    require_once("database.php");

    $queryProfiles = 'SELECT * FROM profiles';

    $statementProfiles = $db->prepare($queryProfiles);
    $statementProfiles->execute();
    $profiles = $statementProfiles->fetchAll();
    $statementProfiles->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>CREW CHIEF PROFILE LOG</title>
    <link rel="stylesheet" type="text/css" href="css/setup.css" />
</head>
<body>

    <?php include("header.php"); ?>

    <main>
        <h2>PROFILE LOG</h2>

        <table>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Team Name</th>
                <th>Email Address</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

        <?php foreach ($profiles as $profile) :
            $emailVal = isset($profile['email']) ? $profile['email'] : (isset($profile['emailAddress']) ? $profile['emailAddress'] : '');
        ?>
            <tr>
                <td><?php echo htmlspecialchars($profile['firstName']); ?></td>
                <td><?php echo htmlspecialchars($profile['lastName']); ?></td>
                <td><?php echo htmlspecialchars($profile['teamName']); ?></td>
                <td><?php echo htmlspecialchars($emailVal); ?></td>
                <td>
                    <form action="update_profile_form.php" method="post">
                        <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>">
                        <input type="submit" value="EDIT" class="btn-action">
                    </form>
                </td>
                <td>
                    <form action="delete_profile.php" method="post">
                        <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        
        </table>

        <p><a href="add_profile_form.php">Add New Crew Chief Profile</a></p>

    </main>

    <?php include("footer.php"); ?>
</body>
</html>