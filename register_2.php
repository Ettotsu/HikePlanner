<html>
    <?php 
        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        $level = $_POST["level"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];
        
        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");
        $req = $bdd->prepare("INSERT INTO account (username, password, email, level, weight, size) VALUES (?,?,?,?,?,?)");
        $req->execute([$username, $password, $email, $level, $weight, $height]);

        header("Location: login.php");
    ?>
</html>
