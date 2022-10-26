<html>
    <?php
        $lat = $_GET["lat"];
        $long = $_GET["lng"];
        $i = 0;

        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $i = count($lat);

        echo $i;

        $req = $bdd->prepare("SELECT id_run FROM waypoints HAVING MAX(order_waypoint)  =  ?");
        $req->execute([$i]);

        foreach($req as $value) {
            
            echo $value["id_run"]."<br>"; 
        }

        // $req = $bdd->prepare("INSERT INTO run (data) VALUES ('4')");
        // $req->execute();

        // $req = $bdd->prepare("SELECT MAX(id_run) FROM run");
        // $req->execute();
        // $id_run = $req->fetch();
        
        // echo $id_run["MAX(id_run)"];

        // for($i = 0; $lat[$i] != NULL; $i++) {

        //     $req = $bdd->prepare("INSERT INTO waypoints (id_run, order_waypoint, latitude, longitude) VALUES (?,?,?,?)");
        //     $req->execute([$id_run["MAX(id_run)"], $i + 1, $lat[$i], $long[$i]]);
        // }

        // echo "lat : ".$lat[0]."<br>";
        // echo "lng : ".$long[0];
    ?>
</html>