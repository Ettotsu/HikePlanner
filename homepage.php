<html>
    <link rel="stylesheet" type="text/css" href="./projet_css/homepage.css"/>
    <meta charset="utf-8"/>

    <head>
        <title>Hike Planner - Homepage</title>
    </head>

    <body>
        <?php
        session_start();

        if (isset($_SESSION['id_account']) == FALSE) {
            header("Location: login_1.php");
        } 

        function disconnect() {
            unset($_SESSION['id_account']);
            header("Location: login_1.php");
        }

        if(array_key_exists('button', $_POST)) {
            disconnect();
        }
        ?>

        <header>
            <img class="logo" src="./projet_css/HikePlanner.png"/>

            <nav>
                <ul>
                    <li>
                        <a class="butt" href="homepage.php">Homepage</a>
                    </li>
    
                    <li>
                        <a class="butt" href="hikeplanner_map_v2.html">New Run</a>
                    </li>
                    
                    <li>
                        <a class="butt" href="my_runs.php">My Runs</a>
                    </li>
                </ul>

            </nav>
        </header>

        <form class="deco" method='post'>
                    <input type='submit' class='button' name='button' value='Disconnect'>
            </form>
        <br>


        <main>
        <div class="side">
        <br>
        <img src="./projet_css/if2.jpg"/>
        <br>
        <br>
        <p>
        </p>
        <a href="profile.php">My profile</a>
        </div>

        <div>
        <?php 
        
        echo "<div> <form method='post'>
            <input id='research' name='research' type='text'/>
            <input type='submit' class='button' name='search' value='Search'/>
            </form> </div> <br><br>";

        function research() {  
            $research = "%";          
            $research .= $_POST["research"];
            $research .= "%";

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("SELECT * FROM account WHERE username LIKE ? AND id != ?;");
            $req->execute([$research, $_SESSION['id_account']]);
            
            echo "<div>";
            if ($research != "%%") {
                foreach($req as $value) {
                    $link = "profile_visit.php/?id=";
                    $link .= $value["id"];
                    echo "<a href='$link' >".$value['username'].'<br>'."</a>"; 
                }
            }
            echo "</div>";
        }

        if(array_key_exists('search', $_POST)) {
            research();
        }
        
        ?>
        </div>
        </main>
        <footer>
            <a href="./projet_css/if2.jpg">Privacy policy</a>
        </footer>
        
    </body>
</html>