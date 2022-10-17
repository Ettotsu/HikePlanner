<html>
    <link rel="stylesheet" type="text/css" href="projet_css/login.css"/>

    <head><title>Hikeplanner Login</title></head>

    <body>
        <!-- <?php 
            if($id_account == -1) {
                echo "Username or Password invalid";
            }
        ?> -->
        
        <div class="form">

            <form method="POST" action="login_2.php">

                <label for="username">Username : </label>
                <br>
                <input id="username" name="username" type="text"/>
                <br>
                <label for="password">Password : </label>
                <br>
                <input id="password" name="password" type="password"/>
                <br>
                <input type="submit" value="Sign-in"/>

                <a href="create_account_1.php"><strong>Sign up</strong></a>
            </form>
        </div>

    </body>
</html>