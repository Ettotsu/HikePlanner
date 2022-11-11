<html>
    <head><title>Hikeplanner - Sign up</title></head>

    <body>

        <link rel="stylesheet" type ="text/css" href="./projet_css/create_account.css"/>
        
        <page>
        <div class = "logo">
        <img src="./projet_css/HikePlanner.png"/>
        </div>

        <div class="formulaire">
        <form method="POST" action="register_2.php">
            <label for="email">Email address :</label>
            <input id="email" name="email" type="text" placeholder="example@mail.com"/>
            <br>

            <label for="username">Username :</label>
            <input id="username" name="username" type="text" placeholder="Jus-de-dragon"/>
            <br>

            <label for="password">Password :</label>
            <input id="password" name="password" type="password"/>
            <br>
            <br>

            <label for="level">Your hiking level :</label>
            <select id="level" name="level">
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advanced">Advanced</option>
            </select>
            <br>

            <label for="weight">Your weight (in kg) :</label>
            <input class="param" id="weight" name="weight" type="number" min="1" max="300"/>
            <br>

            <label for="height">Your height (in cm) :</label>
            <input class="param" id="height" name="height" type="number" min="1" max="250"/>
            <br>


            <input class="sign-up" type="submit" value="Sign up"/>
        </form>
        </div>
        <footer>
        <a class="credit" href="https://www.pexels.com/photo/brown-mountains-2559941/" target="blank"><strong>Background credit</strong></a>
        </footer>
        </page>
    </body>
</html>