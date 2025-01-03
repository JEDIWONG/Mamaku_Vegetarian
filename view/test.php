<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <style>
    /* Styling for the editable email input */
    .editable-email {
      border: 1px solid #ccc;
      padding: 8px;
      font-size: 16px;
      width: 250px;
    }

    /* Styling for the confirmation message */
    .confirmation-message {
      display: none;
      position: absolute;
      top: 50px;
      left: 50%;
      transform: translateX(-50%);
      background-color: #28a745;
      color: white;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>

  <!-- Profile Section -->
  <h1>Profile Page</h1>
  <div>
    <label for="email">Email Address:</label>
    <input type="text" id="email" class="editable-email" value="user@example.com" />
  </div>

  <!-- Floating confirmation message -->
  <div id="confirmation" class="confirmation-message">Email Address Updated</div>

  <script>
    // Event listener to update the email when it loses focus
    document.getElementById('email').addEventListener('blur', function () {
      const email = this.value.trim();

      // Ensure email is not empty
      if (email !== '') {
        // Call the updateEmail function when the field loses focus
        updateEmail(email);
      }
    });

    // Function to send the email update request to the server
    function updateEmail(email) {
      fetch('update_email.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email }),
      })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          // Show the confirmation message
          showConfirmationMessage();
        } else {
          alert('Failed to update email. Please try again.');
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
      });
    }

    // Function to show the confirmation message
    function showConfirmationMessage() {
      const confirmation = document.getElementById('confirmation');
      confirmation.style.display = 'block';

      // Hide the confirmation message after 2 seconds
      setTimeout(() => {
        confirmation.style.display = 'none';
      }, 2000);
    }
  </script>

</body>
</html>
