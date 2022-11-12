<html>
    <head>
        <title>Hikeplanner - Profile</title>
        <meta charset="utf-8"/>
        <link rel="stylesheet" type="text/css" href="projet_css/profile.css"/>
    </head>

    <body>
        <a href="#edit_profile">HikePlanner - Profile edit</a>
        <br>

        <?php
            session_start();

            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

            $req = $bdd->prepare("SELECT * FROM account WHERE id = ?");
            $req->execute([$_SESSION['id_account']]);

            $data = $req->fetch();
        ?>

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
                <form method="POST" action="profile_edit.php">
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
                    <input class="edit" type="submit" value="Edit Profile"/>
                </form>
                <a href="#" class="cross">&times;</a>
            </div>
        </div>
          
    </body>
</html>