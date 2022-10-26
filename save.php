<html>
    <?php
        session_start();

        $lat = $_GET["lat"];
        $long = $_GET["lng"];
        $new = 1;

        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $size = count($lat);

        echo "taille :".$size."<br>";

        $req = $bdd->prepare("SELECT id_run, MAX(order_waypoint) FROM waypoints GROUP BY id_run HAVING MAX(order_waypoint) = ?");
        $req->execute([$size]);

        foreach($req as $value) {
            echo "id_run :".$value["id_run"]."<br>";

            $i = 0;
            $new = 0;

            $req1 = $bdd->prepare("SELECT latitude, longitude FROM waypoints WHERE id_run = ?");
            $req1->execute([$value["id_run"]]);

            foreach($req1 as $coord) {
                echo "lat : ".$lat[$i]."<br>";
                echo "lng : ".$long[$i]."<br>";
                echo "coord lat : ".$coord["latitude"]."<br>";
                echo "coord lng : ".$coord["longitude"]."<br><br>";

                if($lat[$i] != $coord["latitude"] and $long[$i] != $coord["longitude"]) {
                    $new = 1;
                    break;
                }
                $i++;
            }

            if($new == 0) {
                $id_run = $value["id_run"];
                echo "id_run :".$id_run."<br>";
                break;
            }

        }

        echo "nouveau :".$new."<br>";
        
        if($new == 1) {

            $req = $bdd->prepare("INSERT INTO run (data) VALUES ('4')");
            $req->execute();

            $req = $bdd->prepare("SELECT MAX(id_run) FROM run");
            $req->execute();
            $id_run = $req->fetch()["MAX(id_run)"];

            for($j = 0; $lat[$j] != NULL; $j++) {

                $req = $bdd->prepare("INSERT INTO waypoints (id_run, order_waypoint, latitude, longitude) VALUES (?,?,?,?)");
                $req->execute([$id_run, $j + 1, $lat[$j], $long[$j]]);
            }
        }

        $req = $bdd->prepare("INSERT INTO run_saved (id_account, id_run) VALUES (?, ?)");
        $req->execute([$_SESSION['id_account'], $id_run]);
        
        header("Location: my_runs.php");                
    ?>
</html>