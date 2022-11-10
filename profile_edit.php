<html>
    <?php
        session_start();

        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $email = $_POST["email"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $level = $_POST["level"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];

        $req = $bdd->prepare("UPDATE account SET email = ?, first_name = ?, last_name = ?, level = ?, weight = ?, size = ? WHERE id = ?");
        $req->execute([$email, $first_name, $last_name, $level, $weight, $height, $_SESSION['id_account']]);

        header("Location: profile.php");
    ?>
</html>