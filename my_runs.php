<html>
    <body>
        <p>
            beubeu
        </p>
        <p>
        
            <?php
                session_start();

                $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

                $req = $bdd->prepare("SELECT id_run FROM run_saved WHERE id_account = ?");
                $req->execute([$_SESSION['id_account']]);

                foreach($req as $value) {
                    echo "run : ".$value["id_run"]."<br>";

            ?>
            <a href="">edit</a>
            <br><br>

            <?php
                }

            ?>
        </p>
    </body>
</html>