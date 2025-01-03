
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