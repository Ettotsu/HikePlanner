<html>
    <?php
        session_start();

        if (isset($_SESSION['id_account']) == FALSE) {
            header("Location: login.php");
        }

        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $level = $_POST["level"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];

        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $req_username = $bdd->prepare("SELECT id FROM account WHERE username = ?");
        $req_username->execute([$username]);

        if($req_username->fetch() != null) {
            header("Location: register.php?invalid=1");
        
        } else {
            $req = $bdd->prepare("INSERT INTO account (username, password, first_name, last_name, email, level, weight, size) VALUES (?,?,?,?,?,?,?,?)");
            $req->execute([$username, $password, $first_name, $last_name, $email, $level, $weight, $height]);

            header("Location: login.php");
        }
    ?>
</html>
