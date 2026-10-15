<?php
    session_start();
    require_once("database.php");

    $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_VALIDATE_INT);
    if (!$profile_id) {
        $profile_id = filter_input(INPUT_GET, 'profile_id', FILTER_VALIDATE_INT);
    }

    if (!$profile_id) {
        header("Location: profiles.php");
        exit();
    }
    
    $queryProfile = 'SELECT * FROM profiles WHERE profileID = :profile_id';

    $statement = $db->prepare($queryProfile);
    $statement->bindValue(':profile_id', $profile_id);
    $statement->execute();
    $profile = $statement->fetch();
    $statement->closeCursor();

    if (!$profile) {
        header("Location: profiles.php");
        exit();
    }

    // define current car type
    $current_car_type = isset($profile['carType']) ? $profile['carType'] : '';
    
    // initial image filename
    $image_src = !empty($profile['imageName']) ? htmlspecialchars($profile['imageName']) : 'placeholder_100.jpg';
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

            <form action="update_profile.php" method="post" id="update_profile_form" enctype="multipart/form-data">

                <input type="hidden" name="profile_id" value="<?php echo $profile['profileID']; ?>" />

                <label>First Name:</label>
                <input type="text" name="first_name" value="<?php echo htmlspecialchars($profile['firstName']); ?>" /><br />

                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?php echo htmlspecialchars($profile['lastName']); ?>" /><br />

                <label>Team Name:</label>
                <input type="text" name="team_name" value="<?php echo htmlspecialchars($profile['teamName']); ?>" /><br />

                <label>Email Address:</label>
                <input type="text" name="email_address" value="<?php echo htmlspecialchars($profile['emailAddress']); ?>" /><br />

                <label>Car Type:</label>
                <select name="car_type">
                    <option value="Pure Stock" <?php if ($current_car_type == 'Pure Stock') echo 'selected'; ?>>Pure Stock</option>
                    <option value="Mini Stock" <?php if ($current_car_type == 'Mini Stock') echo 'selected'; ?>>Mini Stock</option>
                    <option value="Late Model" <?php if ($current_car_type == 'Late Model') echo 'selected'; ?>>Late Model</option>
                </select><br />

                <div class="form-group">
                    <label>CURRENT IMAGE:</label><br>
                    <img id="currentImage" 
                        src="images/<?php echo $image_src; ?>" 
                        alt="Profile Image" 
                        style="max-width: 100px; height: auto; border-radius: 6px; margin-top: 5px;" 
                        onerror="this.src='images/placeholder_100.jpg';">
                </div>

                <div class="form-group">
                    <label>UPLOAD IMAGE:</label><br>
                    <input type="file" name="file1" accept="image/*" onchange="previewImage(event)">
                </div>

                <input type="submit" value="Update Profile" />
            </form>

            <p><a href="index.php" class="btn-add">Crew Chief Dashboard</a></p>
        </main>

        <?php include("footer.php"); ?>

        <script>
        function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('currentImage');
                    if (img) {
                        img.src = e.target.result;
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        </script>
    </body>
</html>