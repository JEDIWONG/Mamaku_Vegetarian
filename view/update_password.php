<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];

    // Validate password
    if (empty($password)) {
        echo 'Password cannot be empty';
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    //include '../view/db_connect.php'; // Include your database connection file

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$user", $email, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Update password in the database
        $stmt = $pdo->prepare("UPDATE user SET password = :password WHERE id = :id");
        $stmt->execute([
            ':password' => $hashedPassword,
            ':id' => 1 // Replace with the appropriate user ID
        ]);

        echo 'success';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    exit;
}
?>
