<html>
    
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
    <link rel="stylesheet" type="text/css" href="projet_css/my_runs.css"/>

    <body>
        
        <div>       
            <h2>
                My Runs
            </h2>
            <p>
            
                <?php
                    session_start();

                    $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

                    $req = $bdd->prepare("SELECT * FROM run_saved WHERE id_account = ?");
                    $req->execute([$_SESSION['id_account']]);

                    $i = 0;

                    foreach($req as $value) {
                ?>
                <div>

                    <div <?php echo "id='map".$i."'"; ?>>
                        <!-- Here we will have the map -->
                    </div>

                    <table>
                        <tr>
                            <th> Run </th>
                            <th> State </th>
                            <th> Date </th>
                            <th> Weather </th>
                            <th> Difficulty </th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    echo "run : ".$value["id_run"]."<br>";
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($value["completed"] != NULL){
                                        echo "completed";
                                ?>
                            </td>
                            <td> 
                                <?php
                                    echo $value["date"];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $value["weather"];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $value["difficulty"];
                                ?>
                            </td>
                                                   
                                <?php
                                    } else{
                                        echo "not completed yet</td>";
                                    }
                                ?>
                    </table>
                    <p>
                        <h4> Comments </h4>
                        <?php
                            echo $value["comments"];
                        ?>
                    </p>

                    <div>
                        <a href="#popup" class="edit_button">edit</a>
                        <br><br>
                    </div>

                    <div id="popup" class="overlay">
                        <div class="popup">
                            <h1> Run
                                <?php
                                    echo $value["id_run"];
                                ?>                          
                            </h1>
                            <a href="#" class="cross">&times;</a>

                            <form method="post" action="#">

                                <table>
                                    <tr>
                                        <th> State </th>
                                        <th> Date </th>
                                        <th> Weather </th>
                                        <th> Difficulty </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="state" placeholder="Completed">
                                                <option value="Completed">Completed</option>
                                                <option value="Uncomlpleted">Uncompleted</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input name="date" type="date" placeholder="--/--/----"/>
                                        </td>
                                        <td>
                                            <input name="weather" type="text" placeholder="sunny"/>
                                        </td>
                                        <td>

                                            <select id="level" name="level">
                                                <option value="Beginner">Beginner</option>
                                                <option value="Intermediate">Intermediate</option>
                                                <option value="Advanced">Advanced</option>
                                            </select>

                                        </td>
                                    </tr>
                                </table>

                                <input name="submit" type="submit" value="Edit"/>
                            </form>

                        </div>
                    </div>
                </div>

                <?php
                    $i ++;

                    unset($value);
                    }
                ?>
                
                <!-- Javascript files -->
                <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
                <script type="text/javascript">

                    <?php
                        $req = $bdd->prepare("SELECT * FROM run_saved WHERE id_account = ?");
                        $req->execute([$_SESSION['id_account']]);

                        for($j = 0; $j < $i; $j ++) {
                            $value = $req->fetch();
                    ?>
                    
                    // Create "my_map" and insert it in the HTML element with ID "map.$i"
                    var <?php echo "my_map".$j; ?> = L.map('<?php echo "map".$j; ?>').setView([10, 10], 10);
                    
                    // Set up Leaflet to use OpenStreetMap with Mapbox for routing
                    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                        minZoom: 1,
                        maxZoom: 15
                    }).addTo(<?php echo "my_map".$j; ?>);

                    <?php
                        $req1 = $bdd->prepare("SELECT latitude, longitude FROM waypoints WHERE id_run = ?");
                        $req1->execute([$value["id_run"]]);

                        $waypoint = $req1->fetch();

                        while($waypoint != null) {
                    ?>

                    var marker = L.marker([<?php echo $waypoint["latitude"].",".$waypoint["longitude"]; ?>]).addTo(<?php echo "my_map".$j; ?>);

                    <?php $waypoint = $req1->fetch(); }} ?>
                    
                </script>
                
            </p>
        </div>
    </body>
</html>