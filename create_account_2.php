<html>
    <head><title>Hikeplanner</title></head>

    <body>
        <?php 
            
            $username = $_POST["username"];
            $password = $_POST["password"];
            $email = $_POST["email"];
            $level = $_POST["level"];
            $weight = $_POST["weight"];
            $size = $_POST["size"];
            
            $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
            $req = $bdd->prepare("INSERT INTO account (username, password, email, level, weight, size) VALUES (?,?,?,?,?,?)");
            $req->execute([$username, $password, $email, $level, $weight, $size]);

            header("Location: login_1.php");
        ?>
    </body>

</html>
