<form action="ajout.php" method="post">

<input id="www" type="url" list="urldata" name="adresseweb">

<datalist id="urldata">
  <select>
    <option value="sans label ni contenu"></option>
    <option value="sans label avec contenu texte">le texte</option>
    <option value="avec label" label="le label"></option>
    <option value="avec label et texte" label="le label">le texte</option>
  </select>
</datalist>

    <table>
        <caption>Ajout d'un medecin</caption>
        <tbody> 
            <td> Civilite : </td>
            <td> 
                <input list="sexe" type="text" name="civilite" >
                <datalist id="sexe">
                    <select name="civilite" >
                        <option value="Mr.">
                        <option value="0" >Mme.</option>
                    </select>
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


    