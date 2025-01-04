document.addEventListener("DOMContentLoaded", () => {
    const userData = document.getElementById("user-data");
    first_name = userData.getAttribute("data-first-name");
    last_name = userData.getAttribute("data-last-name");

  });

let popupShown = false;

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

    fetch('../view/update_name.php', {
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

  function changePassword() {
    const passwordField = document.getElementById('password');
    const successMessage = document.getElementById('successMessage');
    const formData = new FormData();

    formData.append('password', passwordField.value);

    fetch('change_password.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === 'success') {
            successMessage.style.display = 'block';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 3000);
        }
    })
    .catch(error => console.error('Error:', error));
}

      // Add event listener for when the email field loses focus
    document.getElementById('email-field').addEventListener('blur', function() {
        const email = this.value.trim();

        if (!popupShown) {
          popupShown = true; // Set the flag
          const email = this.value.trim();
          if (email === "") {
              alert("Email field cannot be empty."); // Example popup
          }
          setTimeout(() => popupShown = false, 100); // Reset flag after a brief delay
      }
  });

    if (email) {
        // Send the updated email to the server
        fetch('../view/update_email.php', {
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
  

    document.getElementById('phone-field').addEventListener('blur', function() {
      const phone_number = this.value.trim();

  if (phone_number) {
      // Send the updated email to the server
      fetch('../view/update_phone.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ phone_number })
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

  function confirmDeleteAccount() {
    document.getElementById('delete-overlay').style.display = 'block';
    document.getElementById('delete-popup').style.display = 'block';
}

function closeDeletePopup() {
    document.getElementById('delete-overlay').style.display = 'none';
    document.getElementById('delete-popup').style.display = 'none';
}

function deleteAccount() {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '../view/delete_account.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Account deleted successfully.');
            window.location.href = '../view/logout.php'; // Redirect to logout page
        } else {
            alert('An error occurred. Please try again.');
        }
    };
    xhr.send('user_id=1'); // Pass the dynamic user ID if applicable
}
