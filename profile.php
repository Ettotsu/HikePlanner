<html>
    <body>
        <a href="edit_profile.php">Edit</a>
        <br>

        <?php
            session_start();

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$_SESSION['id_account']]);

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