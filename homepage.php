<html> 
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ==" crossorigin="" />
        <link rel="stylesheet" type="text/css" href="./projet_css/homepage.css"/>
        <title>HikePlanner - Homepage</title>
    </head>

    <body>
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

            function add_into_runs($bdd) {
                $id_run = $_POST["id_run"];

                $req_add = $bdd->prepare("INSERT INTO run_saved (id_run, id_account) VALUES (?, ?)");
                $req_add->execute([$id_run, $_SESSION['id_account']]);
            }

            if(array_key_exists('button', $_POST)) {
                disconnect();
            }

            if(array_key_exists("add_run", $_POST)) {
                add_into_runs($bdd);
            }
        ?>

        <header>
            <img class="logo" src="./projet_css/HikePlanner_homepage.png"/>


            <nav>
            <h1 class="h">Homepage</h1>
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
            <form class="deco" method='post'>
                    <input type='submit' class='button' name='button' value='Disconnect'>
        </form>
        </header>

        <br>

        <main>
            <div class="side">
                <?php
                    $username=$bdd->prepare("SELECT username,  level, first_name, last_name, picture FROM account WHERE id=?");
                    $username->execute([$_SESSION['id_account']]);
                    $var = $username->fetch();
                ?>
                <br>
                <img src="./profile_picture/<?php echo $var['picture'];?>"/>
                <br>
                <br>
                <p>
                <?php
                    echo $var["username"]."<br>".$var["first_name"]."  ".$var["last_name"]."<br>".$var["level"];
                ?>
                </p>
                <a href="profile.php">View my profile</a>
                <br>
                <p><strong>Following accounts : </strong>
                <?php
                    $req_follow = $bdd->prepare("SELECT username FROM account
                                                    INNER JOIN follow ON account.id = follow.id_followed 
                                                    WHERE id_account = ?");
                    $req_follow->execute([$_SESSION['id_account']]);
                    foreach($req_follow as $value) {
                        if($value != null) {
                            echo "<br>".$value["username"];
                        }
                    }
                ?>
                </p>
            </div>


            <div class="se">
                <?php
                echo "<div> <form method='post'>
                    <input id='research' name='research' type='text'/>
                    <input type='submit' class='button' name='search' value='Search'/>
                    </form> </div> <br><br>";

                function research($bdd) {  
                    $research = "%";          
                    $research .= $_POST["research"];
                    $research .= "%";

                    $req = $bdd->prepare("SELECT * FROM account WHERE username LIKE ? AND id != ?;");
                    $req->execute([$research, $_SESSION['id_account']]);
                    
                    echo "<div>";
                    if ($research != "%%") {
                        foreach($req as $value) {
                            $link = "profile_visit.php/?id=".$value["id"];
                            echo "<a href='$link' >".$value['username'].'<br>'."</a>"; 
                        }
                    }
                    echo "</div>";
                }

                if(array_key_exists('search', $_POST)) {
                    research($bdd);
                }
                
                ?>
            </div>

            <div class="follow">
                <?php
                    $req = $bdd->prepare("SELECT run_saved.id_run, run.distance, run.time AS estimated_time, follow.* FROM run_saved 
                                            INNER JOIN run ON run_saved.id_run = run.id_run 
                                            INNER JOIN follow ON run_saved.id_account = follow.id_followed
                                            WHERE follow.id_account = ? AND run_saved.completed = 1
                                            GROUP BY run_saved.id_run
                                            ORDER BY run_saved.date DESC");
                    $req->execute([$_SESSION['id_account']]);

                    $parkour = $req->fetch();
                    $i = 0;

                    if($parkour != null) {
                        while($parkour != null) {
                ?>

                <div>
                    <div <?php echo "id='map".$i."'"; ?>>
                        <!-- Here we will have the map -->
                    </div>

                    <div class="table_run">
                        <h3> <?php echo "distance : ".$parkour["distance"]."km ; time : ".$parkour["estimated_time"]; ?> </h3>
                        <table>
                            <tr>
                                <th></th>
                                <th> Time </th>
                                <th> Date </th>
                                <th> Weather </th>
                                <th> Difficulty </th>
                                <th> Comments </th>
                            </tr>
                            
                            <?php
                                $req_run = $bdd->prepare("SELECT MIN(time), date, weather, difficulty, comments, username FROM run_saved 
                                                            INNER JOIN follow ON run_saved.id_account = follow.id_followed
                                                            INNER JOIN account ON follow.id_followed = account.id
                                                            WHERE follow.id_account = ? AND id_run = ? AND completed = 1 
                                                            GROUP BY run_saved.id_account");
                                $req_run->execute([$_SESSION['id_account'], $parkour["id_run"]]);

                                $run = $req_run->fetch();
                                while($run != null) {
                            ?>

                            <tr>
                                <td>
                                    <?php
                                        echo $run["username"];
                                    ?>
                                </td>
                                <td> 
                                    <?php
                                        echo $run["MIN(time)"];
                                    ?>
                                </td>
                                <td> 
                                    <?php
                                        echo $run["date"];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $run["weather"];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $run["difficulty"];
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $run["comments"];
                                    ?>
                                </td> 
                            </tr>

                            <?php $run = $req_run->fetch(); } ?>
                        </table>
                        <form method="post">
                            <input name="id_run" type="hidden" value="<?php echo $parkour["id_run"]; ?>" />
                            <input name="add_run" type="submit" value="Add to my Runs"/>
                        </form>                                
                    </div>

                    <?php                  
                        $req_marker = $bdd->prepare("SELECT latitude, longitude FROM waypoints WHERE id_run = ?");
                        $req_marker->execute([$parkour["id_run"]]);

                        $waypoint = $req_marker->fetch();
                    ?>

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
                </div>
                <?php
                        $parkour = $req->fetch();
                        $i ++;
                        }
                    } else {
                        echo "<em>None of the people you follow have scheduled a run yet.</em>";
                    } 
                ?>
            </div>
        </main>

        <footer>
            <a href="./projet_css/if2.jpg">Privacy policy</a>
        </footer>       
    </body>
</html>