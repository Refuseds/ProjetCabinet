<form action="ajout.php" method="post">


    <table>
        <caption>Ajout d'un medecin</caption>
        <tbody> 
            <td> Civilite : </td>
            <td> 
                <input list="sexe" type="text" name="civilite" >
                <datalist id="sexe">
                    <select name"civilite" >
                        <option value="Mr.">
                        <option value="Mme." >
                </datalist>
            </td>
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
        
        if($_POST['civilite'] == "Mme."){
            $civ = 0;
        }else if($_POST['civilite'] == "Mr."){
            $civ = 1;
        }else if($_POST['civilite'] == ""){
            echo " Champ civilité non renseigné";
        }

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
                            'lcivilite' => $civ,
                            'lnom' => $_POST['nom'],
                            'lprenom' => $_POST['prenom']
        ));
        //print_r($req->errorInfo());
    }

?>    


    