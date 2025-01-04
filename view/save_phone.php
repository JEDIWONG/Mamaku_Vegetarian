<?php
// save_phone.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];

    // Save the phone number to a file or database
    // Example: Save to a file (you can replace this with database code)
    file_put_contents('phone_number.txt', $phone);

    echo 'success';
    exit;
}
?>
