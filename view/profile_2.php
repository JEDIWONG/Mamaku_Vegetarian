<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Mamaku Vegetarian</title>
    
    <!-- External CSS Files -->
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/searchpanel.css">
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="../style/footer.css">

    <!-- External JavaScript Files -->
    <script src="../script/edit_name.js" defer></script>
    <script src="../script/update_email.js" defer></script>
</head>
<body>
    <?php include "../include/sidebar.php" ?>
    <main>
        <?php include "../include/searchpanel.php" ?>
        <section class="main-content">

            
            <section class="profile-info">

             <h2>Personal Info</h2>
                
                <div class="personal-details">
                    <div>
                        <h1 id="full-name">John Doe</h1>
                        <p>Registered since January 1, 2023</p>
                    </div>
                    <button class="edit-btn" id="edit-name-btn">Edit Name</button>
                </div>

                <!-- Popup for Editing Name -->
                <div class="overlay" id="overlay"></div>
                <div class="popup" id="popup">
                    <h2>Edit Name</h2>
                    <input type="text" id="first-name" placeholder="First Name" />
                    <input type="text" id="last-name" placeholder="Last Name" />
                    <button id="save-name-btn">Save</button>
                    <button id="cancel-name-btn">Cancel</button>
                </div>
                
                <h2>Contact Information</h2>    
                <div class="contact-info">
                    <label>Email:</label>
                    <input type="email" id="email-field" value="johndoe@example.com" />
                </div>

                <div class="contact-info">
                    <label>Contact Number:</label>
                    <input type="text" value="+1234567890" />
                </div>

                <!-- Floating Message -->
                <div id="floating-message">Email address updated</div>

                <div class="advanced-settings">
                    <h2>Advanced Settings</h2>
                    <button class="change-password">Change Password</button>
                    <button class="delete-account">Delete Account</button>
                </div>
            </section>
        </section>
    </main>
</body>
</html>