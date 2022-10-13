<html>
    <head><title>Hikeplanner</title></html>

    <body>
        <form method="POST" action="create_account_2.php">
            <label for="email">Email address</label>
            <input id="email" name="email" type="text"/>
            <br>

            <label for="level">Select your hiking level</label>
            <select id="level" name="level">
                <option value="Beginner">Beginner</option>
                <option value="Intermediate">Intermediate</option>
                <option value="Advenced">Advanced</option>
            </select>
            <br>

            <label for="weight">Your weight</label>
            <input id="weight" name="weight" type="number" value="0"/>
            <br>

            <label for="size">How tall are you ?</label>
            <input id="size" name="size" type="number"/>
            <br>

            <label for="username">Username</label>
            <input id="username" name="username" type="text"/>
            <br>

            <label for="password">Password</label>
            <input id="password" name="password" type="password"/>
            <br>

            <input type="submit" value="Sign in"/>

        </form>

</html>