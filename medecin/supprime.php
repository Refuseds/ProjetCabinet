<?php include '../secure.php';?>
<html>
    <body>
        Medecin supprimé<br>
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
        $req2 = $linkpdo->prepare('DELETE FROM medecin
                                    WHERE pkmedecin LIKE :lpkmedecin');
        $req2->execute(array('lpkmedecin' => $_POST['pkmedecin'] ));
    ?>
    </body>
</html>
