<form action="ajout.php" method="post">
 
    <table>
        <caption>Ajout d'un patient</caption>
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
        <tbody> 
            <td>     Adresse : </td>
            <td> <input type="text" name="adresse" ></td>
        </tbody>
        <tbody> 
            <td>    Date naissance: </td>
            <td> <input type="text" name="datenaissance" ></td>
        </tbody>
        <tbody> 
            <td>     Lieu naissance : </td>
            <td> <input type="text" name="lieunaissance" ></td>
        </tbody>
        <tbody> 
            <td>     Numero Securite Sociale : </td>
            <td><input type="text" name="numsecurite" ></td>
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
        $req = $linkpdo->prepare('INSERT INTO patient (
                                        civilite, 
                                        nom,
                                        prenom,
                                        adresse,
                                        datenaissance,
                                        lieunaissance,
                                        numsecurite
                                      )
                                VALUES(
                                    :lcivilite,
                                    :lnom,
                                    :lprenom,
                                    :ladresse,
                                    :ldatenaissance,
                                    :llieunaissance,
                                    :lnumsecurite
                                  )
                            ');
        $req->execute(array(
                            'lcivilite' => $_POST['civilite'],
                            'lnom' => $_POST['nom'],
                            'lprenom' => $_POST['prenom'],
                            'ladresse' => $_POST['adresse'],
                            'ldatenaissance' => $_POST['datenaissance'],
                            'llieunaissance' => $_POST['lieunaissance'],
                            'lnumsecurite' => $_POST['numsecurite']
        ));
        //print_r($req->errorInfo());
        //echo "Contact modifié";
    }else{
       // echo "Contact non modifié";
    }

?>    


    