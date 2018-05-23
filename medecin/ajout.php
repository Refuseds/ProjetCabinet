<form action="ajout.php" method="post">
 
    <table>
        <caption>Ajout d'un medecin</caption>
        <tbody> 
            <td> Civilite : </td>
            <td> <input type="text" name="civilite"></td>
        </tbody>
        <tbody> 
            <td>    Nom : </td>
            <td> <input type="text" name="nom" ></td>
        </tbody>
        <tbody> 
            <td>    Prenom : </td>
            <td> <input type="text" name="prenom"></td>
        </tbody>
    </table>
    <input type="submit" value="Valider" name="valid">
</form>

<?php 
    if( isset($_POST['valid'])){
        $server = 'localhost';
        $login = 'root';
        $mdp = 'root';
        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
        } 
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        };
        $req = $linkpdo->prepare('INSERT INTO medecin (
                                        civilite, 
                                        nom,
                                        prenom
                                      )
                                VALUES(
                                    :lcivilite,
                                    :lnom,
                                    :lprenom
                                  )
                            ');
        $req->execute(array(
                            'lcivilite' => $_POST['civilite'],
                            'lnom' => $_POST['nom'],
                            'lprenom' => $_POST['prenom']
        ));
        //print_r($req->errorInfo());
    }

?>    


    