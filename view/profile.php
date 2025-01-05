<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Mamaku Vegetarian</title>
    
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="../style/searchpanel.css">
    <link rel="stylesheet" href="../style/footer.css">
</head>
<body>
          
<script src="../script/edit_function.js"></script>
    
<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    include "../model/database_model.php"; 
    include "../include/sidebar.php";
    include "../include/searchpanel.php";
    
    $db = new Database();

    // Check if the user is logged in
    
    // Retrieve user_id from the session
    $user_id = $_SESSION['user_id'];
    

    // Fetch user data from the database
    $sql = "SELECT * FROM user WHERE user_id = " . $db->escape_string($user_id);
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $contact_number = $row['phone_number'];
        $registration_date = $row['created_at'];
    } else {
        echo "User not found.";
    }
?>

<main>
    <div class="main-content">
        <header>
            <h1>Profile</h1>
            <style>
                header h1 {
                    font-family: 'Inter', sans-serif;
                    font-size: 2.5rem;
                    color: #333;
                }
            </style>
            <div class="header-icons">
                <span class="notification"></span>
                <span class="account"></span>
            </div>
        </header>

        <section class="profile-info">
            <h2><b>Personal Info</b></h2>
            <style>
                header h2 {
                    font-family: 'Verdana', sans-serif;
                    font-size: 2.5rem;
                    color: #333;
                }
            </style>
            <div class="personal-details">
                <div>
                    <h1 id="full-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>
                    <p>Registered since <?php echo htmlspecialchars($registration_date); ?></p>
                        
                </div>
                    <button class="edit-btn" onclick="openPopup()">Edit Name</button>
                            </div>
                                <div id="user-id" style="display: none;" data-user-id="<?php echo $user_id; ?>"></div>
                                <div id="user-data"
                                    data-first-name="<?php echo htmlspecialchars($first_name); ?>"
                                    data-last-name="<?php echo htmlspecialchars($last_name); ?>">
                            </div>          

                            <div class="overlay" id="overlay" onclick="closePopup()"></div>
           
                            <div class="popup" id="popup">      
                                    <h2>Edit Name</h2>
                                    <input type="text" id="first-name" placeholder="First Name" />
                                    <input type="text" id="last-name" placeholder="Last Name" />
                                <button onclick="saveName()">Save</button>
                                <button onclick="closePopup()">Cancel</button>
                            </div>
            <div class="contact-info">
            <h2>Contact Information</h2>
                <label>Email:</label>
                <input type="email" id= "email-field" value="<?php echo htmlspecialchars($email); ?>" edit>
                <label>Contact Number:</label>
                <input type="text" id= "phone-field" value="<?php echo htmlspecialchars($contact_number); ?>" edit>
            </div>

            <div id="floating-message" style="display: none;">Email address updated</div>
          
            <div class="advanced-settings">
                <h2>Advanced Settings</h2>
                <!-- Button to trigger the popup -->
                <button class="change-password-btn" onclick="openChangePasswordPopup()">Change Password</button>

            <!-- Popup - Change Password -->
            <div class="overlay" id="change-password-overlay" onclick="closeChangePasswordPopup()"></div>
            <div class="popup" id="change-password-popup">
                <h2>Change Password</h2>
                <form id="change-password-form" method="POST" action="../controller/update_password.php">
                    <label for="current-password">Current Password:</label>
                    <input type="password" id="current-password" name="current-password" required>

                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new-password" required>

                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>

                    <button type="submit">Change Password</button>
                    <button type="button" onclick="closeChangePasswordPopup()">Cancel</button>
                </form>
                <div id="change-password-message"></div> <!-- For success/failure message -->
            </div>

                <button class="delete-account" onclick="confirmDeleteAccount()">Delete Account</button>
            </div>

            <div class="overlay" id="delete-overlay" onclick="closeDeletePopup()"></div>
            <div class="popup" id="delete-popup">
                <h2>Are you sure you want to delete your account?</h2>
                <p>This action cannot be undone.</p>
                <button onclick="deleteAccount()">Confirm</button>
                <button onclick="closeDeletePopup()">Cancel</button>
            </div>

        </section>
    </div>

</main>
<?php include "../include/footer.php"?>
</body>
</html> 