<html>
    <?php
        session_start();

        $username = $_POST["username"];
        $password = $_POST["password"];

        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $req = $bdd->prepare("SELECT id, password FROM account WHERE username = ?");
        $req->execute([$username]);
        $result = $req->fetch();

        if($result == null) {
            header("Location: login.php?error_connection=1");

        } else if(password_verify($password, $result["password"])){
            $_SESSION['id_account'] = $result["id"];
            header("Location: homepage.php");
        } else {
            header("Location: login.php?error_connection=1");
        }
    ?>
</html>
