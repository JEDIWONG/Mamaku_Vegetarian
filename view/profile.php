<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Mamaku Vegetarian</title>
    
    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/profile.css">
    <link rel="stylesheet" href="../style/footer.css">
  


</head>
<body>

    <script>
   document.addEventListener("DOMContentLoaded", function () {
    const currentPage = window.location.profile; // e.g., "/profile"
    const navLinks = document.querySelectorAll(".sidebar-nav a");

    navLinks.forEach((link) => {
        if (link.getAttribute("href") === currentPage) {
            link.parentElement.classList.add("active"); // Add class to the <li> element
        }
    });
});

</script>
    
    <?php

    include "../model/database_model.php";

    $conn = new Database();
    // Fetch user data from the database
    $sql = "SELECT * FROM user WHERE user_id = 3"; // Replace '1' with the dynamic user ID if applicable
    $result = $conn->query($sql);

  


    if ($result->num_rows > 0) {
        // Fetch associative array
        $row = $result->fetch_assoc();
        $first_name = $row['first_name'] ;
        $last_name = $row['last_name'];
        $email = $row['email'];
        $contact_number = $row['phone_number'];
        $registration_date = $row['created_at'];
    } else {
        echo "No user found.";
    }
    ?>


    <?php include "../include/sidebar.php" ?>

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

            <div id="user-data"
     data-first-name="<?php echo htmlspecialchars($first_name); ?>"
     data-last-name="<?php echo htmlspecialchars($last_name); ?>">
        </div>

            <!-- test -->
    <div class="overlay" id="overlay" onclick="closePopup()"></div>
        <div class="popup" id="popup">
        <h2>Edit Name</h2>
        <input type="text" id="first-name" placeholder="First Name" />
        <input type="text" id="last-name" placeholder="Last Name" />
        <button onclick="saveName()">Save</button>
        <button onclick="closePopup()">Cancel</button>
    </div>

            <script> </script>
            <div class="contact-info">
                <h2>Contact Information</h2>
                <label>Email:</label>
                <input type="email" id= "email-field" value="<?php echo htmlspecialchars($email); ?>" edit>
                <label>Contact Number:</label>
                <input type="text" id= "phone-field" value="<?php echo htmlspecialchars($contact_number); ?>" edit>
            </div>


<!-- Floating Message -->
            <div id="floating-message" style="display: none;">Email address updated</div>
            
            <script src="../script/edit_function.js"></script>

            <div class="advanced-settings">
                <h2>Advanced Settings</h2>
                <button class="change-password"onclick="changePassword()">Change Password</button>
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