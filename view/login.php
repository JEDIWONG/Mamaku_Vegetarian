<?php
    // Include database connection
    include '../model/database_model.php';

    $db = new Database();
    $conn = $db->conn;

    session_start();

    // Check if form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        // Validate input
        if (empty($email) || empty($password)) {
            echo "<script>alert('Email and Password are required.'); window.location.href='login.php';</script>";
            exit();
        }

        // Prepare and execute query securely to prevent SQL Injection
        $query = "SELECT * FROM user WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();

            // Verify the hashed password
            if (password_verify($password, $user['password_hash'])) {
                // Successful login
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];

                header("Location: dashboard.php");
                exit();
            } else {
                // Incorrect password
                echo "<script>alert('Invalid password.'); window.location.href='login.php';</script>";
            }
        } else {
            // Email not found
            echo "<script>alert('No account found with this email.'); window.location.href='login.php';</script>";
        }

        $stmt->close();
    }

    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mamaku Vegetarian</title>

        <link rel="stylesheet" href="../style/index.css">
        <link rel="stylesheet" href="../style/login.css">
    </head>
    <body>
        <section class="login-page-container">

            <section class="login-info">

                <div class="login-logo">
                    <img src="../assets/images/logo.png" alt="logo">
                    <p>Mamaku Vegetarian</p>
                </div>

                <h1>
                    “Experience Begin Vegan”
                </h1>

                <h2>
                    New to Vegetarian ?
                </h2>

                <h3>
                    Sign Up Today
                </h3>

                <button onclick="location.href='register.php'">
                    Register Here
                </button>

            </section>

            
                
            <form class="login-form" action="login.php" method="POST">
                <h1>Sign In</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <a href="#">Forgot Password</a>
                <button type="submit">Login</button>
            </form>
            

            
        </section>
    </body>
</html>