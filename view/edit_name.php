<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Name with Database</title>
  <style>
    body {
      font-family: Arial, sans-serif;
    }
    .profile-container {
      max-width: 400px;
      margin: 50px auto;
      text-align: center;
    }
    .popup {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      border-radius: 8px;
      display: none;
      z-index: 1000;
    }
    .popup.active {
      display: block;
    }
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      z-index: 999;
    }
    .overlay.active {
      display: block;
    }
    .popup input {
      display: block;
      width: 90%;
      margin: 10px auto;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .popup button {
      padding: 10px 20px;
      margin: 10px;
      background: #4caf50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .popup button:hover {
      background: #45a049;
    }
  </style>
</head>
<body>

<?php
    // Include database connection
    include '../view/db_connect.php';

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

<div class="profile-container">
  <h1 id="full-name"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>
  <button onclick="openPopup()">Edit Name</button>
</div>

<!-- Popup Structure -->
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
</body>
</html>
