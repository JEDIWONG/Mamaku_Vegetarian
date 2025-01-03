<?php
$servername = "localhost"; // Replace with your server address
$username = "root";        // Replace with your DB username
$password = "";            // Replace with your DB password
$dbname = "mamaku_vegetarian";    // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
