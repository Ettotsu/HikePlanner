<html>
    <?php
        $bdd = new PDO("mysql:host=localhost;dbname=projet_if3;charset=utf8", "root", "");

        $state = $_POST["state"];
        $time = $_POST["time"];
        $date = $_POST["date"];
        $weather = $_POST["weather"];
        $difficulty = $_POST["difficulty"];
        $comments = $_POST["comments"];
        $num_run = $_POST["number_run"];

        if(array_key_exists("edit", $_POST)) {
            $req_edit_run = $bdd->prepare("UPDATE run_saved SET completed=?, date=?, time=?, difficulty=?,weather=?, comments=? WHERE number_run=?");         
            $req_edit_run->execute([$state, $date, $time, $difficulty, $weather, $comments, $num_run]);
        } else {
            $req_delete = $bdd->prepare("DELETE FROM run_saved WHERE number_run = ?");
            $req_delete->execute([$num_run]);
        }

        header("Location: my_runs.php");    
    ?>
</html>