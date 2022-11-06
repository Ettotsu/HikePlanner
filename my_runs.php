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

                    $req_run = $bdd->prepare("SELECT id_run FROM `run_saved` WHERE id_account = ? GROUP BY id_run");
                    $req_run->execute([$_SESSION['id_account']]);

                    $i = 0;
                    $run = $req_run->fetch();

                    while($run != null) {

                        $req_marker = $bdd->prepare("SELECT latitude, longitude FROM waypoints WHERE id_run = ?");
                        $req_marker->execute([$run["id_run"]]);
                        
                        $waypoint = $req_marker->fetch();
                ?>

                <div>

                    <div <?php echo "id='map".$i."'"; ?>>
                        <!-- Here we will have the map -->
                    </div>

                    <?php
                        $req_run_id = $bdd->prepare("SELECT * FROM `run_saved` WHERE id_account = ? AND id_run = ? ORDER BY time ASC");
                        $req_run_id->execute([$_SESSION['id_account'], $run["id_run"]]);

                        $run_id = $req_run_id->fetch();
                        $j = 0;                        

                        while($run_id != null) {
                    ?>

                    <?php if($j == 1) { 
                        $open = 1;
                        
                        echo "<div id='more' class='all'>
                        <div class='more'>";
                        }
                    ?>

                    <table>
                        <tr>
                            <th> Run </th>
                            <th> State </th>
                            <th> Time </th>
                            <th> Date </th>
                            <th> Weather </th>
                            <th> Difficulty </th>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                    echo "run : ".$run["id_run"]."<br>";
                                ?>
                            </td>
                            <td>
                                <?php
                                    if($run_id["completed"] != NULL){
                                        echo "completed"; 
                                    } else{
                                        echo "not completed yet</td>";
                                    }
                                ?>
                            </td>
                            <td> 
                                <?php
                                    echo $run_id["time"];
                                ?>
                            </td>
                            <td> 
                                <?php
                                    echo $run_id["date"];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $run_id["weather"];
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $run_id["difficulty"];
                                ?>
                            </td>
                    </table>
                    <div>
                        <h4> Comments </h4>
                        <p class="comments">
                            <?php
                                echo $run_id["comments"];
                            ?>
                        </p>
                    </div>

                    <?php
                        $run_id = $req_run_id->fetch(); 
                        $j ++;
                        } 
                        
                        if($open == 1) { $open = 0; 
                    ?>

                        </div>
                        <a href="#" class="less_button">See less -</a>
                    </div>    
                    
                    <?php } ?>

                    <div id="more" class="box_more_button">
                        <a href="#more" class="more_button">See more +</a>
                        <br><br>
                    </div>

                    <div>
                        <a href="#popup" class="edit_button">edit</a>
                        <br><br>
                    </div>

                    <div id="popup" class="overlay<?php echo $i; ?>">
                        <div class="popup">
                            <h1> Run
                                <?php
                                    echo $run["id_run"];
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

                <!-- Javascript files -->
                <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
                <script type="text/javascript">
                    
                    // Create "my_map" and insert it in the HTML element with ID "map.$i"
                    var <?php echo "my_map".$i; ?> = L.map('<?php echo "map".$i; ?>').setView([<?php echo $waypoint["latitude"].",".$waypoint["longitude"]; ?>], 7);
                    
                    // Set up Leaflet to use OpenStreetMap with Mapbox for routing
                    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
                        minZoom: 1,
                        maxZoom: 15
                    }).addTo(<?php echo "my_map".$i; ?>);

                    <?php
                        

                        

                        while($waypoint != null) {
                    ?>

                    var marker = L.marker([<?php echo $waypoint["latitude"].",".$waypoint["longitude"]; ?>]).addTo(<?php echo "my_map".$i; ?>);

                    <?php $waypoint = $req_marker->fetch(); } ?>
                    
                </script>

                <?php
                    $i ++;
                    $run = $req_run->fetch();
                    }
                ?>
            </p>
        </div>
    </body>
</html>