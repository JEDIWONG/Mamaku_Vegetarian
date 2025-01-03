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
    <script src="../script/edit_name.js"></script>


</head>
<body>

    <?php

    // Fetch user data from the database
    $sql = "SELECT * FROM user WHERE user_id = 1"; // Replace '1' with the dynamic user ID if applicable
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
                <div class="profile-pic"></div>
                <div>
                <h1 id="full-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>
                    <p>Registered since <?php echo htmlspecialchars($registration_date); ?></p>
                    <button class="edit-btn" onclick="openPopup()">Edit Name</button>
                </div>
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

            <script>
   first_name = "<?php echo htmlspecialchars($first_name); ?>";
    last_name = "<?php echo htmlspecialchars($last_name); ?>";


  function openPopup() {

   // const fullName = document.getElementById('full-name').textContent.split(' ');
    document.getElementById('first-name').value = first_name;
    document.getElementById('last-name').value = last_name;

    document.getElementById('popup').classList.add('active');
    document.getElementById('overlay').classList.add('active');
  }

  function closePopup() {
    document.getElementById('popup').classList.remove('active');
    document.getElementById('overlay').classList.remove('active');
  }

  function saveName() {
    const firstName = document.getElementById('first-name').value.trim();
    const lastName = document.getElementById('last-name').value.trim();

    fetch('update_name.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ firstName, lastName })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
      // Update both the displayed name and the JavaScript variables
      document.getElementById('full-name').textContent = `${firstName} ${lastName}`;
      // Update the JavaScript variables for future edits
      first_name = firstName;
      last_name = lastName;
      closePopup();
      } else {
        alert('Failed to update name. Please try again.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again.');
    });
  }
</script>
            <!-- test -->

            <div class="contact-info">
                <h2>Contact Information</h2>
                <label>Email:</label>
                <input type="email" id= "email-field" value="<?php echo htmlspecialchars($email); ?>" edit>
                <label>Contact Number:</label>
                <input type="text" value="<?php echo htmlspecialchars($contact_number); ?>" edit>
            </div>


<!-- Floating Message -->
<div id="floating-message" style="display: none;">Email address updated</div>
        
<script>
    // Add event listener for when the email field loses focus
document.getElementById('email-field').addEventListener('blur', function() {
  
    const email = document.getElementById('email-field').value.trim();

  if (email) {
    // Send the updated email to the server
    fetch('update_email.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); 
      if (data.success) {
        // Show the floating message
        const message = document.getElementById('floating-message');
        message.style.display = 'block';
        
        // Hide the message after 3 seconds
        setTimeout(() => {
          message.style.display = 'none';
        }, 3000);
      } else {
        alert('Failed to update email. Please try again.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again.');
    });
  }
});

</script>
            <div class="advanced-settings">
                <h2>Advanced Settings</h2>
                <button class="change-password">Change Password</button>
                <button class="delete-account">Delete Account</button>
            </div>
        </section>
    </div>

    </main>
    <?php include "../include/footer.php"?>
</body>
</html>