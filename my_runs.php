<html>
    <link rel="stylesheet" type="text/css" href="projet_css/my_runs.css"/>
    <meta charset="utf-8"/>

    <body>
    <header>
            <h1><center>Hike Planner</center></h1>

            <form method='post'>
                <input type='submit' class='button' name='button' value='Disconnect'>
            </form>

            <nav>
                <ul>
                    <li>
                        <a href="search.php">Search</a>
                    </li>
    
                    <li>
                        <a href="hikeplanner_map_v2.html">New Run</a>
                    </li>
                    
                    <li>
                        <a href="my_runs.php">My Runs</a>
                    </li>

                </ul>
            </nav>

        </header>
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

                    foreach($req as $value) {
                ?>
                <div>
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
                                        echo "completed yet";
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
                    }
                ?>
                </script>
            </p>
        </div>
    </body>
</html>