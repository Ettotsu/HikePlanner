<html>
    <head>
        <a href='http://localhost/HikePlanner/homepage.php'> retour </a> <br><br>
    </head>
    <body>
        <?php
            session_start();
            $id = $_GET["id"];
            
            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$id]);

            $data = $req->fetch();

            function curly($bdd, $id) {
                $req = $bdd->prepare("INSERT INTO follow (id_account, id_followed) VALUES (?, ?);");
                $req->execute([$_SESSION['id_account'],$id]);
            }
    
            if(array_key_exists('curly', $_POST)) {
                curly($bdd, $id);
            }
            
            $req = $bdd->prepare("SELECT * FROM follow WHERE id_account = ?");
            $req->execute([$_SESSION['id_account']]);

            $followed = 0;
            foreach ($req as $value) {
                if ($value['id_followed'] == $id) {
                    $followed = 1;
                }
            }

            if ($followed != 1) {
                echo "<form method='post'>
                <input type='submit' class='button' name='curly' value='Suivre'/>
                </form> <br>";
            }
           
        ?>

        <label>Email adress : </label>
        <?php
            echo $data["email"];
        ?>
        <br>

        <label>Username : </label> 
        <?php
            echo $data["username"];
        ?>
        <br>

        <label>First name : </label> 
        <?php
            echo $data["first_name"];
        ?>
        <br>

        <label>Last Name : </label> 
        <?php
            echo $data["last_name"];
        ?>
        <br>

        <label>Your Level : </label>
        <?php
            echo $data["level"];
        ?>   
        <br>

        <label>Your weight (in kg) : </label>
        <?php
            echo $data["weight"];
        ?>
        <br>

        <label>Your height (in cm) : </label>
        <?php
            echo $data["size"];
        ?>
          
    </body>
</html>