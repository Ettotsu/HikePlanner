<html>
    <head>
        <a href='http://localhost/HikePlanner/accueil.php'> retour </a>
    </head>
    <body>
        <?php
            session_start();
            $id = $_GET["id"];

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$id]);

            $data = $req->fetch();

            function curly($id) {
                $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
                $req = $bdd->prepare("INSERT INTO follow (id_account, id_followed) VALUES (?, ?);");
                $req->execute([$_SESSION['id_account'],$id]);
            }
    
            if(array_key_exists('curly', $_POST)) {
                curly($id);
            }
            
            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT id_followed FROM follow WHERE id_account = ?");
            $req->execute([$_SESSION['id_account']]);
            $followed = 0;

            foreach ($req as $value) {
                if ($value == $id) {
                    $followed = 1;
                }
            }
            if ($followed == 0) {
                echo "<form method='post'>
                <input type='submit' class='button' name='curly' value='Suivre'/>
                </form> <br>";
                header("Refresh");
            }
           
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