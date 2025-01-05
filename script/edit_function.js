document.addEventListener("DOMContentLoaded", () => {
  const userData = document.getElementById("user-data");
  first_name = userData.getAttribute("data-first-name");
  last_name = userData.getAttribute("data-last-name");
  const userId = document.getElementById('user-id').getAttribute('data-user-id');

});

let popupShown = false;

function saveName() {
  const firstName = document.getElementById('first-name').value.trim();
  const lastName = document.getElementById('last-name').value.trim();
  const fullName = `${firstName} ${lastName}`;
  const userId = document.getElementById('user-id').getAttribute('data-user-id');

  fetch('../controller/update_name.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ userId, fullName })
  })
  
  .then(response => response.json())
  .then(data => {
      if (data.success) {
          document.getElementById('full-name').textContent = fullName;
          closePopup();
      } else {
          alert(data.message || 'Failed to update name.');
      }
  })
  .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again.');
  });
}




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
    // Function to open the popup
    function openChangePasswordPopup() {
        document.getElementById('change-password-popup').style.display = 'block';
        document.getElementById('change-password-overlay').style.display = 'block';
    }

    // Function to close the popup
    function closeChangePasswordPopup() {
        document.getElementById('change-password-popup').style.display = 'none';
        document.getElementById('change-password-overlay').style.display = 'none';
    }

    // Handle the form submission via AJAX
    document.getElementById('change-password-form').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        const currentPassword = document.getElementById('current-password').value.trim();
        const newPassword = document.getElementById('new-password').value.trim();
        const confirmPassword = document.getElementById('confirm-password').value.trim();

        const formData = new FormData();
        formData.append('current-password', currentPassword);
        formData.append('new-password', newPassword);
        formData.append('confirm-password', confirmPassword);

        fetch('../controller/change_password.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const messageDiv = document.getElementById('change-password-message');
            if (data.success) {
                messageDiv.textContent = data.message;
                messageDiv.style.color = 'green';
                // Optionally close the popup after success
                setTimeout(closeChangePasswordPopup, 3000);
            } else {
                messageDiv.textContent = data.message;
                messageDiv.style.color = 'red';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

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


  if (email) {
      // Send the updated email to the server
      fetch('../controller/update_email.php', {
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

  document.getElementById('phone-field').addEventListener('blur', function() {
    const phone_number = this.value.trim();

if (phone_number) {
    // Send the updated email to the server
    fetch('../controller/update_phone.php', {
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
  xhr.open('POST', '../contoller/delete_account.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function () {
      if (xhr.status === 200) {
          alert('Account deleted successfully.');
          window.location.href = '../controller/logout.php'; // Redirect to logout page
      } else {
          alert('An error occurred. Please try again.');
      }
  };
  xhr.send('user_id=1'); // Pass the dynamic user ID if applicable
}
