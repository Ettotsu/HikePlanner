<!DOCTYPE html>
<html>
    <head>
        <title>Hikeplanner - My profile</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="projet_css/profile.css"/>
    </head>

    <body>
    <header>
            <img class="logo" src="./projet_css/HikePlanner_homepage.png"/>


            <nav>
            <h1 class="h">My profile</h1>
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
        <a href="#edit_profile" class="edit">Edit your profile</a>
        <br>

        <?php
            session_start();

            if (isset($_SESSION['id_account']) == FALSE) {
                header("Location: login.php");
            }

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$_SESSION['id_account']]);

            $data = $req->fetch();

            function disconnect() {
                unset($_SESSION['id_account']);
                header("Location: login.php");
            }
            if(array_key_exists('button', $_POST)) {
                disconnect();
            }
        ?>
        <br>
        <img class="pp" src="./profile_picture/<?php echo $data['picture']; ?>"/>
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

        <div id="edit_profile" class="overlay">
            <div class="edit_form">
                <form method="POST" action="profile_edit.php" enctype="multipart/form-data">
                    <label for="email">Email address :</label>
                    <input id="email" name="email" type="text" value="<?php echo $data["email"];?>" placeholder="example@mail.com"/>
                    <br>

                    <label for="first_name">First name :</label>
                    <input id="first_name" name="first_name" type="text" value="<?php echo $data["first_name"];?>" placeholder="Catherine"/>
                    <br>

                    <label for="last_name">Last name :</label>
                    <input id="last_name" name="last_name" type="text" value="<?php echo $data["last_name"];?>" placeholder="De Médicis"/>
                    <br>

                    <label for="level">Your hiking level :</label>
                    <select id="level" name="level" value="<?php echo $data["level"];?>">
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                    <br>

                    <label for="weight">Your weight (in kg) :</label>
                    <input class="param" id="weight" name="weight" type="number" value="<?php echo $data["weight"];?>" min="1" max="300"/>
                    <br>

                    <label for="height">Your height (in cm) :</label>
                    <input class="param" id="height" name="height" type="number" value="<?php echo $data["size"];?>"  min="1" max="250"/>
                    <br>

                    <label for="image">Profile picture :</label>
                    <input id="image" name="image" type="file" accept="image/png, image/jpeg"/>
                    <br>
                    <br>

                    <input class="edit" type="submit" value="Validate"/>
                </form>
                <a href="#" class="cross">&times;</a>
            </div>
        </div>
          
        <?php
        function convert($time) {  
            $divided_time = explode(':', $time);
            if(isset($divided_time[1]) == TRUE) {
                return $divided_time[0] + $divided_time[1]/60 ;
            } else {
                return 0.00;
            }
        }

        $req_data = $bdd -> prepare("SELECT run_saved.run_name, run_saved.time, run.distance FROM run_saved INNER JOIN run ON run_saved.id_run = run.id_run 
                                    WHERE id_account = ? AND completed = 1 AND run_saved.difficulty != '' ORDER BY run_saved.run_name;");
        $req_data -> execute([$_SESSION['id_account']]);
        $req1 = $req_data->fetch();

        if (isset($req1['distance']) == TRUE) {
            echo "<br><br><br>My runs : <br><br><table><tr><th> run </th>
                <th> distance </th>
                <th> time </th>
                <th> speed </th>
                </tr>";

                echo "<tr>";

                $run = $req1['run_name'];
                if ($run == NULL) {$run = "Unnamed run";}
                echo "<td>".$run."</td>";

                if ($req1['distance'] != 0) {
                $distance = $req1['distance'];
                echo "<td>".$distance." km</td>";
                } else {
                    echo "<td>Unspecified</td>";
                }

                if (convert($req1['time']) != 0) {
                    $time = convert($req1['time']);
                    echo "<td>".number_format($time, 2)." h</td>";
                } else {
                    echo "<td>Unspecified</td>";
                }

                if (convert($req1['time']) != 0 && $req1['distance'] != 0) {
                    $speed = $distance / $time;
                    echo "<td>".number_format($speed, 2)." km/h</td></tr>"; 
                } else {
                    echo "<td>Unspecified</td></tr>";  
                }    

            foreach ($req_data as $value) {
                echo "<tr>";

                $run = $value['run_name'];
                if ($run == NULL) {$run = "Unnamed run";}
                echo "<td>".$run."</td>";

                if ($value['distance'] != 0) {
                $distance = $value['distance'];
                echo "<td>".$distance." km</td>";
                } else {
                    echo "<td>Unspecified</td>";
                }

                if (convert($value['time']) != 0) {
                    $time = convert($value['time']);
                    echo "<td>".number_format($time, 2)." h</td>";
                } else {
                    echo "<td>Unspecified</td>";
                }

                if (convert($value['time']) != 0 && $value['distance'] != 0) {
                    $speed = $distance / $time;
                    echo "<td>".number_format($speed, 2)." km/h</td></tr>"; 
                } else {
                    echo "<td>Unspecified</td></tr>";  
                }
            }
            echo "</table><br><br>";

            $req_data = $bdd -> prepare("SELECT run_saved.time, run.time AS estimated_time, run.distance, run_saved.difficulty FROM run_saved INNER JOIN run ON run_saved.id_run = run.id_run 
                                WHERE id_account = ? AND completed = 1 ORDER BY run_saved.difficulty ASC;");
            $req_data -> execute([$_SESSION['id_account']]);

            $difficulty = "difficult"; //difficult - easy - hardcore - medium

            $d_moy = 0;
            $d_add = 0;
            $d_max = 0;

            $t_moy = 0;
            $t_add = 0;
            $t_max = 0;

            $s_moy = 0;
            $s_add = 0;
            $s_max = 0;

            echo "Difficulty statistics :<br><br><table><tr>
            <th> difficulty </th>
            <th> number of runs </th>
            <th> average distance </th>
            <th> max distance </th>
            <th> average time </th>
            <th> max time </th>
            <th> average speed </th>
            <th> max speed </th>
            </tr>";

            $value = $req_data->fetch();
            while($difficulty != "over") {

                if(isset($value["difficulty"]) == TRUE && $value["difficulty"] == $difficulty) {

                    if($value["distance"] != 0) {
                        $distance = $value["distance"];
                        $d_moy += $distance;
                        $d_add += 1;
                        $d_max = max($d_max, $distance);
                    } 

                    if(convert($value["time"]) != 0) {
                        $time = convert($value["time"]);
                        $t_moy += $time;
                        $t_add += 1;
                        $t_max = max($t_max, $time);
                    } 

                    if (convert($value['time']) != 0 && $value['distance'] != 0) {
                        $speed = $distance / $time;
                        $s_moy += $speed;
                        $s_add += 1;
                        $s_max = max($s_max, $speed);
                        
                    } 

                    $value = $req_data->fetch();

                } else {

                    if ($d_add != 0) {
                        $d_moy = $d_moy / $d_add;
                    } else {
                        $d_moy = 0;
                    }
                    if ($t_add != 0) {
                        $t_moy = $t_moy / $t_add;
                    } else {
                        $t_moy = 0;
                    }
                    if ($s_add != 0) {
                        $s_moy = $s_moy / $s_add;
                    } else {
                        $s_moy = 0;
                    }

                    echo "<tr>
                    <td>".$difficulty."</td>
                    <td>".$d_add."</td>
                    <td>".number_format($d_moy,2)." km</td>
                    <td>".number_format($d_max,2)." km</td>
                    <td>".number_format($t_moy,2)." h</td>
                    <td>".number_format($t_max,2)." h</td>
                    <td>".number_format($s_moy,2)." km/h</td>
                    <td>".number_format($s_max,2)." km/h</td></tr>";

                    $d_moy = 0;
                    $d_add = 0;
                    $d_max = 0;
                    $t_moy = 0;
                    $t_add = 0;
                    $t_max = 0;
                    $s_moy = 0;
                    $s_add = 0;
                    $s_max = 0;

                    if($difficulty == "difficult") {
                        $difficulty = "easy";
                    } else { 
                        if($difficulty == "easy") {
                            $difficulty = "hardcore";
                    } else { 
                        if($difficulty == "hardcore") {
                            $difficulty = "medium";
                    } else { $difficulty = "over";
                    }}}

                }
            }
        } else {echo "<br><br>You have no runs recorded yet.";}    
        ?>

    </body>
</html>