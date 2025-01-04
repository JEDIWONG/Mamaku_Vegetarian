<?php 

    session_start();

    if (!isset($_SESSION['user_id'])) {
        // Redirect guest users to the login page
        header("Location: login.php");
        exit;
    }

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order | Mamaku Vegetarian</title>

        <link rel="stylesheet" href="../style/index.css">
        <link rel="stylesheet" href="../style/sidebar.css">
        <link rel="stylesheet" href="../style/transaction.css">

    </head>
    <body>

        <?php include "../include/sidebar.php" ?>

        <main>
            
            
        </main>
        
    </body>
</html>