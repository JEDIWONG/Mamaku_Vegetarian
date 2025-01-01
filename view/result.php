<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Mamaku Vegetarian</title>

    <link rel="stylesheet" href="../style/index.css">
    <link rel="stylesheet" href="../style/sidebar.css">
    <link rel="stylesheet" href="../style/result.css"> 
</head>
<body>
    
    <?php include "../include/sidebar.php" ?>

    <main>

        <section class="result-container">
            <img src="../assets/icons/tick-circle-svgrepo-com.svg">
            <h3>Order Received</h3>

            <h1>Your Order Number : 21</h1>
            <p>Please Wait while we preparing your dishes</p>
            
            <button class="checkout-download-btn">Download Receipt</button>
            <button class="checkout-back-btn" onclick="location.href = 'menu.php' ">Return To Menu</button>
        </section>

    </main>


</body>
</html>