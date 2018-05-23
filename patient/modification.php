<?php

    $server = 'localhost';
    $login = 'root';
    $mdp = 'root';
    ///Connexion au serveur MySQL
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    };
    $ida = $_GET['id']; 
    

    $req = $linkpdo->prepare('  SELECT *
    FROM patient 
    WHERE pkpatient like :lid');
    $req->execute(array('lid' => $ida)) ;
    $donnees = $req ->fetch();
    $id = $donnees['pkpatient'];

?>


<html>
  <body>
      <h1> Modification</h1>

    <form action="modifie.php" method="post">
        <table>
            <caption>Modification d'un patient</caption>
            <tbody> 
                <td> Civilite : </td>
                <td> <input type="text" name="civilite" value="<?php echo $donnees['civilite']; ?>"></td>
            </tbody>
            <tbody> 
                <td>    Nom : </td>
                <td> <input type="text" name="nom" value="<?php echo $donnees['nom']; ?>"></td>
            </tbody>
            <tbody> 
                <td>    Prenom : </td>
                <td> <input type="text" name="prenom" value="<?php echo $donnees['prenom']; ?>"></td>
            </tbody>
            <tbody> 
                <td>     Adresse : </td>
                <td> <input type="text" name="adresse" value="<?php echo $donnees['adresse']; ?>" ></td>
            </tbody>
            <tbody> 
                <td>    Date naissance: </td>
                <td> <input type="text" name="datenaissance" value="<?php echo $donnees['datenaissance']; ?>" ></td>
            </tbody>
            <tbody> 
                <td>     Lieu naissance : </td>
                <td> <input type="text" name="lieunaissance" value="<?php echo $donnees['lieunaissance']; ?>"></td>
            </tbody>
            <tbody> 
                <td>     Numero Securite Sociale : </td>
                <td><input type="text" name="numsecurite" value="<?php echo $donnees['numsecurite']; ?>"></td>
            </tbody>
        </table>
        <input type="hidden" name="id" value="<?php echo $donnees['pkpatient']; ?>"  ><br />

        <input type="submit" value="Valider" name="valid">
    </form>

   
  </body>
</html>

