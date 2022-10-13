<html>
    <body>
        <?php
            session_start();

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$_SESSION['id_account']]);

            $data = $req->fetch();

        echo "<label for='email'>Your Email</label>
            <input id='email' name='email' type='text' value=".$data["email"]."><br>";
        echo "<label for='username'>Username</label>
        <input id='username' name='username' type='text' value=".$data["username"]."><br>";
        echo "<label for='level'>Your Level</label>
        <input id='level' name='level' type='text' value=".$data["level"].">";
        ?>     
    </body>
</html>