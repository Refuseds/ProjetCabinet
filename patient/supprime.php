<?php include '../secure.php';?>
<html>
    <body>
        Patient supprimé<br>
     <form action='affichage.php' method="post">
        <input type="submit" value="Retour à l'affichage">
    </form>



    <?php
        $server = 'localhost';
        $login = 'root';
        $mdp = 'root';
        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        };
        $req2 = $linkpdo->prepare('DELETE FROM patient
                                    WHERE pkpatient LIKE :lpkpatient');
        $req2->execute(array('lpkpatient' => $_POST['pkpatient'] ));
    ?>
    </body>
</html>
