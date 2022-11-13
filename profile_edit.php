<html>
    <?php
        session_start();

        if (isset($_SESSION['id_account']) == FALSE) {
            header("Location: login.php");
        }

        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $email = $_POST["email"];
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $level = $_POST["level"];
        $weight = $_POST["weight"];
        $height = $_POST["height"];

        if($_FILES["image"]["name"] != null) {

            $origin = $_FILES["image"]["tmp_name"];
            $destination = 'profile_picture/'.$_FILES["image"]["name"];
            move_uploaded_file($origin, $destination);

            $image = $_FILES["image"]["name"];
        } else {
            $req_image = $bdd->prepare("SELECT picture FROM account WHERE id = ?");
            $req_image->execute([$_SESSION['id_account']]);

            $image =  $req_image->fetch()["picture"];
        }

        $req = $bdd->prepare("UPDATE account SET email = ?, first_name = ?, last_name = ?, level = ?, weight = ?, size = ?, picture = ? WHERE id = ?");
        $req->execute([$email, $first_name, $last_name, $level, $weight, $height, $image, $_SESSION['id_account']]);

        header("Location: profile.php");
    ?>
</html>