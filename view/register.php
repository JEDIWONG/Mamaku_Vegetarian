<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once '../model/database_model.php';
        $db = new Database();
        $conn = $db->conn;

        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirm_password = $conn->real_escape_string($_POST['confirm_password']);

        // Validate inputs
        if (empty($email) || empty($password) || empty($confirm_password)) {
            echo "<script>alert('All fields are required.'); window.location.href='register.php';</script>";
            exit();
        }

        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match.'); window.location.href='register.php';</script>";
            exit();
        }

        // Password policy: 6-8 characters, one uppercase, one number, one special character, no spaces
        if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{6,8}$/', $password)) {
            echo "<script>alert('Password must be 6-8 characters, contain one uppercase letter, one number, one special character, and no spaces.'); window.location.href='register.php';</script>";
            exit();
        }

        // Check if the email already exists
        $checkEmailQuery = "SELECT * FROM user WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);
        if ($result->num_rows > 0) {
            echo "<script>alert('Email already registered.'); window.location.href='register.php';</script>";
            exit();
        }

        // Store email and hashed password in the session
        $_SESSION['email'] = $email;
        $_SESSION['password'] = password_hash($password, PASSWORD_BCRYPT);

        // Redirect to Step 2
        header("Location: register_step2.php");
        exit();
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

        <form class="register-form" action="register.php" method="POST" onsubmit="return validatePassword()">
            <h1>Register</h1>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>

            <button type="submit">Next</button>
        </form>

        <script src="../script/register.js"></script>

</section>
</body>
</html>
