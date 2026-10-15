<?php
    session_start();
    require_once("database.php");

    if (!isset($_SESSION['isLoggedIn']) || $_SESSION['isLoggedIn'] !== TRUE) {
        header("Location: login_form.php");
        exit();
    }

    $querySetups = 'SELECT * FROM setups';
    $statementSetups = $db->prepare($querySetups);
    $statementSetups->execute();
    $setups = $statementSetups->fetchAll();
    $statementSetups->closeCursor();

    // fetch profiles
    $queryProfiles = 'SELECT * FROM profiles';
    $statementProfiles = $db->prepare($queryProfiles);
    $statementProfiles->execute();
    $profiles = $statementProfiles->fetchAll();
    $statementProfiles->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Crew Chief Race Setup Log</title>
    <link rel="stylesheet" type="text/css" href="css/setup.css" />
</head>
<body>

    <?php include("header.php"); ?>

    <main>
        <!-- CREW CHIEF PROFILES TABLE -->
        <h2>DASHBOARD</h2>

        <p>Current Logged In User: <?php echo htmlspecialchars($_SESSION["user_name"] ?? $_SESSION["username"] ?? 'Guest'); ?></p>

        <h3>Driver Profiles</h3>

        <table>
            <tr>
                <th>Image</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Team Name</th>
                <th>Email Address</th>
                <th>Car Type</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Details</th>
            </tr>

        <?php foreach ($profiles as $profile) : 
            $emailVal = isset($profile['emailAddress']) ? $profile['emailAddress'] : (isset($profile['email']) ? $profile['email'] : '');
        ?>
            <tr>
                <td>
                    <?php if (!empty($profile['imageName'])) : ?>
                        <img src="images/<?php echo htmlspecialchars($profile['imageName']); ?>" 
                            alt="Profile" 
                            onerror="this.src='images/placeholder_100.jpg';">
                    <?php endif; ?>
                </td>

                <td><?php echo htmlspecialchars($profile['firstName']); ?></td>
                <td><?php echo htmlspecialchars($profile['lastName']); ?></td>
                <td><?php echo htmlspecialchars($profile['teamName']); ?></td>
                <td><?php echo htmlspecialchars($emailVal); ?></td>
                <td><?php echo htmlspecialchars($profile['carType']); ?></td>
                <td>
                    <form action="update_profile_form.php" method="post">
                        <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>">
                        <input type="submit" value="EDIT" class="btn-action">
                    </form>
                </td>
                <td>
                    <form action="delete_profile.php" method="post">
                        <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>">
                        <input type="submit" value="DELETE" class="btn-delete">
                    </form>
                </td>
                <td>
                    <form action="profile_details.php" method="post">
                        <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>">
                        <input type="submit" value="DETAILS" class="btn-action">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        
        </table>

        <p><a href="add_profile_form.php" class="btn-add">Add New Profile</a></p>

        <hr style="margin: 30px 0; border: 0; border-top: 1px solid #E0E0E0;">

        <!-- RACE SETUP LOGS TABLE -->
        <h2>🛞 Air Pressure Logs 🛞</h2><br>

        <table>
            <tr>
                <th>Track Name</th>
                <th>Race Date</th>
                <th>LF PSI</th>
                <th>RF PSI</th>
                <th>LR PSI</th>
                <th>RR PSI</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php foreach ($setups as $setup) : ?>
            <tr>
                <td><?php echo htmlspecialchars($setup['trackName']); ?></td>
                <td><?php echo htmlspecialchars($setup['raceDate']); ?></td>
                <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureLF'])) . ' PSI'; ?></td>
                <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureRF'])) . ' PSI'; ?></td>
                <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureLR'])) . ' PSI'; ?></td>
                <td><?php echo htmlspecialchars(str_replace(' PSI', '', $setup['tirePressureRR'])) . ' PSI'; ?></td>
                <td>
                    <form action="update_setup_form.php" method="post">
                        <input type="hidden" name="setup_id" value="<?php echo $setup['setupID']; ?>">
                        <input type="submit" value="EDIT" class="btn-action">
                    </form>
                </td>
                <td>
                    <form action="delete_setup.php" method="post">
                        <input type="hidden" name="setup_id" value="<?php echo $setup['setupID']; ?>">
                        <input type="submit" value="DELETE" class="btn-delete">
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>

        <p><a href="add_setup_form.php" class="btn-add">Add New Air Pressure Log</a></p>

        <p><a href="logout.php" class="btn-add">Logout</a></p>

    </main>
    
    <?php include("footer.php"); ?>

</body>
</html>