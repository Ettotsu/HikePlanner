<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="./projet_css/login.css"/>
        <title>HikePlanner - Login</title>
    </head>

    <body>
        <page>
            <div class="logo">
                <img src="./projet_css/HikePlanner.png"/>
            </div>

            <div class="formulaire">
                <div class="error_connection">
                    <?php 
                        if(isset($_GET["error_connection"])) {
                            echo "Username or Password invalid";
                        }
                    ?>
                </div>
                <form method="POST" action="login_2.php">

                    <label for="username">Username :</label>
                    <br>
                    <input id="username" name="username" type="text"/>
                    <br>
                    <label for="password">Password :</label>
                    <br>
                    <input id="password" name="password" type="password"/>
                    <br>
                    <input class="sign-in" type="submit" value="Sign in"/>
                    <a class="sign-up" href="register.php">Sign up</a>
                </form>
            </div>

            <footer>
                <a class="credit" href="https://www.pexels.com/photo/scenic-photo-of-forest-with-sunlight-1757363/" target="blank"><strong>Background credit</strong></a>
            </footer>
        </page>
    </body>
</html>