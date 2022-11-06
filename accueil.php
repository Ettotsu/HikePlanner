<html>
    <link rel="stylesheet" type="text/css" href="projet_css/accueil.css"/>
    <meta charset="utf-8"/>

    <head>
        <title>Hike Planner</title>
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
                        <a href="hikeplanner_map.html">New Run</a>
                    </li>
                    
                    <li>
                        <a href="my_runs.html">My Runs</a>
                    </li>

                </ul>
            </nav>

        </header>

        <div>
            <a href="profile.php">Profile</a>


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
                
                echo "<p>";
                if ($research != "%%") {
                    foreach($req as $value) {
                        $link = "profile_visit.php/?id=";
                        $link .= $value["id"];
                        echo "<a href='$link' >".$value['username'].'        '."</a>"; 
                    }
                }
                echo "</p>";
            }

            if(array_key_exists('search', $_POST)) {
                research();
            }
            
            ?>

        </div>

        <footer>
            <p>Mentions légales</p>
        </footer>
        
    </body>
</html>