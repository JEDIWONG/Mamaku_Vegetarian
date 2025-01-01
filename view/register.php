<?php
    // Include database connection
    include '../model/database_model.php';

    $db = new Database(); 
    $conn = $db->conn;

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

        // Validate inputs
        if (empty($email) || empty($password) || empty($confirm_password)) {
            echo "<script>alert('All fields are required.'); window.location.href='register.html';</script>";
            exit();
        }

        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match.'); window.location.href='register.html';</script>";
            exit();
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);
        if ($result->num_rows > 0) {
            echo "<script>alert('Email already registered.'); window.location.href='register.php';</script>";
            exit();
        }

        // Insert user into the database
        $insertUserQuery = "INSERT INTO user (email, password_hash) VALUES ('$email', '$hashedPassword')";
        if ($conn->query($insertUserQuery) === TRUE) {
            // Get the last inserted user_id
            $user_id = $conn->insert_id; // Get the user ID of the newly registered user

            // Now create a cart for the user
            $createCartQuery = "INSERT INTO cart (user_id) VALUES ('$user_id')";
            if ($conn->query($createCartQuery) === TRUE) {
                // Success, redirect to login page
                echo "<script>alert('Registration successful! Cart created.'); window.location.href='login.php';</script>";
            } else {
                // Cart creation failed
                echo "<script>alert('Registration successful, but failed to create cart.'); window.location.href='login.php';</script>";
            }
        } else {
            // Registration failed
            echo "<script>alert('Registration failed. Please try again.'); window.location.href='register.php';</script>";
        }
    }

    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/register.css">
</head>
<body>
    <section class="register-page-container">

        <section class="register-info">

            <div class="register-logo">
                <img src="../assets/images/logo.png" alt="logo">
                <p>Mamaku Vegetarian</p>
            </div>

            <h1>
                “Start Your Journey Today”
            </h1>

            <h2>
                Already Have an Account?
            </h2>

            <h3>
                Sign In Below
            </h3>

            <button onclick="location.href='login.php'">
                Login Here
            </button>

        </section>

        
        <form class="register-form" action="register.php" method="POST">
            <h1>Register</h1>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <button type="submit">Register</button>
        </form>

</section>
</body>
</html>
