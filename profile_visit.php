<html>
    <body>
        <br>
        <br>

        <?php

            $id = $_GET["id"];

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$id]);

            $data = $req->fetch();
        ?>

        <label>Your Email : </label>

        <?php
            echo $data["email"];
        ?>
        <br>
        <label>Username : </label> 

        <?php
            echo $data["username"];
        ?>
        <br>
        <label>Your Level : </label>

        <?php
            echo $data["level"];
        ?>   
        <br>
        <label>Your weight : </label>

        <?php
            echo $data["weight"];
        ?>
        <br>
        <label>Your size : </label>

        <?php
            echo $data["size"];
        ?>
          
    </body>
</html>