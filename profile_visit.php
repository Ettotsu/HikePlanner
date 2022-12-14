<html>
    <head>
        <meta charset="utf-8"/>
        
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
        <link rel="stylesheet" type="text/css" href="../projet_css/profile_visit.css"/>

        <title>HikePlanner - Profile</title>
    </head>

    <body>

    <header>
            <img class="logo" src="../projet_css/HikePlanner_homepage.png"/>

            <nav>
            <h1 class="h">View profile</h1>
                <ul>
                    <br>
                    <br>
                    <li>
                        <a class="butt" href="../homepage.php">Homepage</a>
                    </li>
    
                    <li>
                        <a class="butt" href="../hikeplanner_map_v3.php">New Run</a>
                    </li>
                    
                    <li>
                        <a class="butt" href="../my_runs.php">My Runs</a>
                    </li>
                </ul>
            </nav>
            </header>
            <br>
    <a class="back" href='http://localhost/HikePlanner/homepage.php'>Back</a> <br><br>


        <?php
            session_start();
            if (isset($_SESSION['id_account']) == FALSE) {
                header("Location: ../login.php");
            }

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");


            $id = $_GET["id"];

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
                <input type='submit' class='button' name='curly' value='Follow'/>
                </form> <br>";
            } 
           
        ?>

        <img class="pp" src="../profile_picture/<?php echo $data['picture'];?>"/>
        <br>

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

        <label>Level : </label>
        <?php
            echo $data["level"];
        ?>   
        <br>

        <label>Weight (in kg) : </label>
        <?php
            echo $data["weight"];
        ?>
        <br>

        <label>Height (in cm) : </label>
        <?php
            echo $data["size"];
        ?>

        <div>       
            <h2>Runs :</h2>

            <?php
                $req_run = $bdd->prepare("SELECT run_saved.run_name, run_saved.id_run, run.distance, run.time FROM run_saved 
                                            INNER JOIN run ON run_saved.id_run = run.id_run 
                                            WHERE id_account = ? AND completed = 1
                                            GROUP BY id_run
                                            ORDER BY date DESC");
                $req_run->execute([$id]);

                $run = $req_run->fetch();

                if($run == null) {
                    echo "This person has no run yet.";
                } else {

                    $i = 0;
                    while($run != null) {                       
            ?>

            <div>

                <div <?php echo "id='map".$i."'"; ?>>
                    <!-- Here we will have the map -->
                </div>

                <?php
                    $req_run_id = $bdd->prepare("SELECT * FROM `run_saved` WHERE id_account = ? AND id_run = ? ORDER BY time ASC");
                    $req_run_id->execute([$id, $run["id_run"]]);

                    $run_id = $req_run_id->fetch();
                    
                    while($run_id != null) {    
                ?>

                <div class="table_run">
                    <h3> <?php echo"Run :".$run_id["run_name"]." distance :".$run["distance"]."km time :".$run["time"]; ?> </h3>
                    <table>
                        <tr>
                            <th> Time </th>
                            <th> Date </th>
                            <th> Weather </th>
                            <th> Difficulty </th>
                        </tr>
                        <tr>
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
                        <h4> Comments :</h4>
                        <div class="comments">
                            <p>
                                <?php
                                    echo $run_id["comments"];
                                ?>
                            </p>
                        </div>
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

                <?php
                    $req_marker = $bdd->prepare("SELECT latitude, longitude FROM waypoints WHERE id_run = ?");
                    $req_marker->execute([$run["id_run"]]);

                    $waypoint = $req_marker->fetch();
                ?>

                // Create "my_map" and insert it in the HTML element with ID "map.$i"
                var <?php echo "my_map".$i; ?> = L.map('<?php echo "map".$i; ?>').setView([<?php echo $waypoint["latitude"].",".$waypoint["longitude"]; ?>], 7);

                L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
                    attribution: 'donn??es ?? <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
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
            }
            ?>
        </div> 
    </body>
</html>