<?php include '../secure.php';?>
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
    FROM medecin
    WHERE pkmedecin like :lid');
    $req->execute(array('lid' => $ida)) ;
    $donnees = $req ->fetch();
    $id = $donnees['pkmedecin'];

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
        </table>
        <input type="hidden" name="id" value="<?php echo $donnees['pkmedecin']; ?>"  ><br />

        <input type="submit" value="Valider" name="valid">
    </form>


  </body>
</html>
