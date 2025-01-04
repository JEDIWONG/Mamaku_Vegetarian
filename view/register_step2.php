<?php
    session_start();

    require_once "../model/email_notification_model.php";

    $notification = new EmailNotification();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
            echo "<script>alert('Step 1 not completed. Please start again.'); window.location.href='register_step1.php';</script>";
            exit();
        }

        require_once '../model/database_model.php';
        $db = new Database();
        $conn = $db->conn;

        $first_name = $conn->real_escape_string($_POST['first_name']);
        $last_name = $conn->real_escape_string($_POST['last_name']);
        $phone_number = $conn->real_escape_string($_POST['phone_number']);
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];

        // Validate inputs
        if (empty($first_name) || empty($last_name) || empty($phone_number)) {
            echo "<script>alert('All fields are required.'); window.location.href='register_step2.php';</script>";
            exit();
        }

        // Insert user into the database
        $insertUserQuery = "INSERT INTO user (email, password_hash, first_name, last_name, phone_number) VALUES ('$email', '$password', '$first_name', '$last_name', '$phone_number')";
        if ($conn->query($insertUserQuery) === TRUE) {
            // Get the last inserted user_id
            $user_id = $conn->insert_id;

            // Create a cart for the user
            $createCartQuery = "INSERT INTO cart (user_id) VALUES ('$user_id')";
            if ($conn->query($createCartQuery) === TRUE) {
                // Registration and cart creation successful

                $notification->sendEmail(
                    $email,
                    $first_name." ".$last_name,
                    "Registration Success",
                    "Welcome to Mamaku Vegetarian"
                ); 
                session_destroy(); // Clear session
                echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
                
            } else {
                echo "<script>alert('Registration successful, but failed to create cart.'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('Registration failed. Please try again.'); window.location.href='register_step2.php';</script>";
        }
    }
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

        
        <form class="register-form" action="register_step2.php" method="POST">
            <h1>Step 2: Personal Information</h1>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <button type="submit">Register</button>
        </form>

</section>
</body>
</html>