<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | Mamaku Vegetarian</title>
        <link rel="stylesheet" href="./style/home.css">
        
    </head>
    <body>
        <header>
            <button class="menu">&#9776;</button>
            <div class="home-logo">
                <img src="./assets/images/Logo.svg" alt="Logo">
                <h1>Mamaku Vegetarian</h1>
            </div>
            <nav> 
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="./view/menu.php">Our Menu</a></li>
                    <li><a href="./view/cart.php">Cart</a></li>
                    <li><a href="./view/register.php" class="btn signup">Sign Up</a></li>
                    <li><a href="./view/login.php" class="btn login">Login</a></li>
                </ul>
            </nav>
            <div class="dropdown_menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="./view/menu.php">Our Menu</a></li>
                <li><a href="./view/cart.php">Cart</a></li>
                <li><a href="./view/register.php" class="btn signup">Sign Up</a></li>
                <li><a href="./view/login.php" class="btn login">Login</a></li>
            </div>
        </header>

        <main>
            <section class="news">
                <h2>TASTE THE GREENERY WHILE</h2>
                <h2>ENJOYING THE SCENERY</h2>
                <p><a href="./view/menu.php">View All Menu</a></p>
            </section>

            <section class="about"> 
                <h2>About Mamaku Vegetarian</h2>
                <div class="box-container">
                   <div class="box">
                        <img src="./assets/images/Tomato.svg" alt="Tomato Icon">
                        <div>
                          <h3>100% Vegan Goodness</h3>
                          <p>We provide a variety of vegetables as well as other soy-based foods.</p>
                      </div>
                   </div>

                    <div class="box">
                        <img src="./assets/images/Verified.svg" alt="Fresh from the market">
                        <div>
                          <h3>Fresh from the market</h3>
                          <p>We use the ingredients brought from the market, maintaining the freshness of the food.</p>
                        </div>
                    </div>

                    <div class="box">
                        <img src="./assets/images/nutrition.svg" alt="Flavourful & Nutritious">
                        <div>
                          <h3>Flavourful & Nutritious</h3>
                          <p>Our meals packed with taste and nutrients make healthy eating enjoyable.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        
        <footer>
            <p>Copyright &copy; 2024. Mamaku Vegetarian All Rights Reserved.</p>
        </footer>

        <script src="./script/index.js"></script>
    </body>
</html>