<html>
    <?php 
        $username = $_POST["username"];
        $password = $_POST["password"];

        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $req = $bdd->prepare("SELECT id FROM account WHERE username = ? AND password = ?");
        $req->execute([$username, $password]);
        $result = $req->fetch();

        session_start();

        if($result == NULL) {
            $_SESSION['id_account'] = -1;
            header("Location: login_1.php");

        } else {
            $_SESSION['id_account'] = $result["id"];
            header("Location: homepage.php");
        } 
    ?>
</html>
