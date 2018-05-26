<html lang="fr">
	<head>
		<meta charset="UTF-8" />




		<title> Affichage des medecins</title>
    </head>

    <body>
        <a href="../index.html">back</a>

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
                $req = $linkpdo->prepare('  SELECT  *
                                            FROM medecin
                                            ');
                $req->execute();  
            ?>

       <table>
        <caption>Liste des medecins</caption>
        <thead>
            <tr>
                <th>----Civilite----</th>
                <th>----Nom----</th>
                <th>----Prenom----</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($donnees = $req->fetch()){
                echo '<tr>';
                    echo '<td>'.$donnees['civilite'].'</td>';
                    echo '<td>'.$donnees['nom'].'</td>';
                    echo '<td>'.$donnees['prenom'].'</td>';
                    echo '<td>'.
                    '<a href="modification.php?id='.$donnees['pkmedecin']
                    .' "> Modification</a>'
                    .'</td>';
                    echo '<td>'.
                    '<a href="suppression.php?id='.$donnees['pkmedecin']
                                    .' "> Suppression</a>'
                    .'</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>

    <a href=ajout.php> Ajout </a>

    </body>
</html>
