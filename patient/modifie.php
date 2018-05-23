<html>
    <body>
        Patient modifié<br>
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
        
       if(isset($_POST['valid'])){
            $req = $linkpdo->prepare('UPDATE patient
                                        SET     civilite = :lcivilite, 
                                                nom = :lnom,
                                                prenom = :lprenom, 
                                                adresse = :ladresse,
                                                datenaissance = :ldatenaissance,
                                                lieunaissance = :llieunaissance, 
                                                numsecurite = :lnumsecurite
                                        WHERE pkpatient LIKE :lid
                                ');
            $req->execute(array(
                'lcivilite' => $_POST['civilite'],
                'lnom' => $_POST['nom'],
                'lprenom' => $_POST['prenom'],
                'ladresse' => $_POST['adresse'],
                'ldatenaissance' => $_POST['datenaissance'],
                'llieunaissance' => $_POST['lieunaissance'],
                'lnumsecurite' => $_POST['numsecurite'],
                'lid' => $_POST['id']
            ));
        }
    
    ?>
    </body>
</html>