<html>

    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
        <link rel="stylesheet" type="text/css" href="projet_css/my_runs.css"/>
        <title>HikePlanner - My Runs</title>
    </head>

    
    <body>
    <header>
            <img class="logo" src="./projet_css/HikePlanner_homepage.png"/>

            <nav>
            <h1 class="h">My runs</h1>
                <ul>
                    <br>
                    <br>
                    <li>
                        <a class="butt" href="homepage.php">Homepage</a>
                    </li>
    
                    <li>
                        <a class="butt" href="hikeplanner_map_v3.php">New Run</a>
                    </li>
                    
                    <li>
                        <a class="butt" href="my_runs.php">My Runs</a>
                    </li>
                </ul>
            </nav>
            <?php
             session_start();

             if (isset($_SESSION['id_account']) == FALSE) {
                 header("Location: login.php");
             }

             $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
             function disconnect() {
                unset($_SESSION['id_account']);
                header("Location: login.php");
            }
            if(array_key_exists('button', $_POST)) {
                disconnect();
            }
            ?>
            <form class="deco" method='post'>
                    <input type='submit' class='button' name='button' value='Disconnect'>
        </form>
    </header>
        <main>
            <br>
                   
            <?php
                function add_run($bdd) {
                    $id_run = $_POST["id_run"];

                    $req_add_run = $bdd->prepare("INSERT INTO run_saved(id_run, id_account) VALUES (?,?)");
                    $req_add_run->execute([$id_run, $_SESSION['id_account']]);
                }

                if(array_key_exists("add_run", $_POST)) {
                    add_run($bdd);
                }

                $req_run = $bdd->prepare("SELECT run_saved.id_run, run.name, run.distance, run.time FROM run_saved 
                                            INNER JOIN run ON run_saved.id_run = run.id_run 
                                            WHERE id_account = ? 
                                            GROUP BY id_run
                                            ORDER BY run_saved.number_run DESC");
                $req_run->execute([$_SESSION['id_account']]);

                $run = $req_run->fetch();

                if($run == null) {
                    echo"You haven't planned a run yet";
                } else {

                    $i = 0;
                    while($run != null) {

                        $req_marker = $bdd->prepare("SELECT latitude, longitude FROM waypoints WHERE id_run = ?");
                        $req_marker->execute([$run["id_run"]]);
                        
                        $waypoint = $req_marker->fetch();
            ?>
            <div>
                <div <?php echo "id='map".$i."'"; ?>>
                    <!-- Here we will have the map -->
                </div>

                <div class="title_run">
                    <h3> 
                        Run :
                        <?php
                            if($run["name"] == null) {
                                echo "Unnamed";
                            } else {
                                echo $run["name"];
                            }
                            echo "<br>distance : ".$run["distance"]."km";
                            $time = explode(":", $run["time"]);
                            echo " time : ";

                            if($time[0] != 0) {
                                echo $time[0]."h";
                            }
                            if($time[1] != 0) {
                                echo $time[1]."min";
                            }                     
                        ?> 
                    </h3>
                </div>

                <?php
                    $req_run_id = $bdd->prepare("SELECT * FROM `run_saved` WHERE id_account = ? AND id_run = ? ORDER BY time ASC");
                    $req_run_id->execute([$_SESSION['id_account'], $run["id_run"]]);

                    $run_id = $req_run_id->fetch();
                    
                    while($run_id != null) {    
                ?>

                <div class="table_run">
                    <table>
                        <tr>
                            <th> State </th>
                            <th> Time </th>
                            <th> Date </th>
                            <th> Weather </th>
                            <th> Difficulty </th>
                        </tr>
                        <tr>
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
                        </tr>
                    </table>

                    <div>
                        <h4> Comments </h4>
                        <div class="comments">
                            <p>
                                <?php
                                    echo $run_id["comments"];
                                ?>
                            </p>
                        </div>
                    </div>

                    <a href=<?php echo"#edit_run".$run_id["number_run"];?> >Edit Run</a>
                </div>

                <div id=<?php echo"edit_run".$run_id["number_run"];?> class="edit_run">
                    <div class="edit">
                        <h2>Run</h2>
                        <form method="post" action="my_runs_edit.php">
                            <table>
                                <tr>
                                    <th> State </th>
                                    <th> Time </th>
                                    <th> Date </th>
                                    <th> Weather </th>
                                    <th> Difficulty </th>
                                </tr>
                                <tr>
                                    <td>
                                        <select name="state">
                                            <option value="1">Completed</option>
                                            <option value="0">Not Completed</option>
                                        </select>
                                    </td>
                                    <td> 
                                        <input name="time" type="time" placeholder="-h--min"/>
                                    </td>
                                    <td> 
                                        <input name="date" type="date"/>
                                    </td>
                                    <td>
                                        <input name="weather" type="text" placeholder="Sunny"/>
                                    </td>
                                    <td>
                                        <select name="difficulty">
                                            <option value="easy">Easy</option>
                                            <option value="medium">Medium</option>
                                            <option value="difficult">Difficult</option>
                                            <option value="hardcore">Hardcore</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                            <div>
                                <h4> Comments </h4>
                                <input class="comments" name="comments" type="text" placeholder="Enter your comments here !"/>
                            </div>

                            <input name="number_run" type="hidden" value="<?php echo $run_id["number_run"];?>"/>
                            <input name="edit_run" type="submit" value="Edit"/>
                            <input type="submit" value="Delete Run"/>
                        </form>

                        <a href="#" class="cross">&times;</a>
                    </div>
                </div>

                <?php 
                    $run_id = $req_run_id->fetch();
                    } 
                ?>
                
            </div>

            <!-- Javascript files -->
            <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw==" crossorigin=""></script>
            <script type="text/javascript">
                
                // Create "my_map" and insert it in the HTML element with ID "map.$i"
                var <?php echo "my_map".$i; ?> = L.map('<?php echo "map".$i; ?>').setView([<?php echo $waypoint["latitude"].",".$waypoint["longitude"]; ?>], 7);
                
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

            <form method="post">
                <input name="id_run" type="hidden" value="<?php echo $run["id_run"]; ?>" />
                <input name="add_run" type="submit" value="+ add run"/>
            </form>

            <?php
                    $i ++;
                    $run = $req_run->fetch();
                    }
                }
            ?>
        </main>
    </body>
</html>