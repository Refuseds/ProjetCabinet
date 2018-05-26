<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		



		<title> Affichage</title>
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
                                            FROM patient 
                                            ');
                $req->execute();  
            ?>

       <table>
        <caption>Liste des patients</caption>
        <thead> 
            <tr>
                <th>----Civilite----</th>
                <th>----Nom----</th>
                <th>----Prenom----</th>
                <th>----Adresse----</th>
                <th>----Date naissance----</th>
                <th>----Lieu naissance----</th>
                <th>----numero secu----</th>
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
                    echo '<td>'.$donnees['adresse'].'</td>';
                    echo '<td>'.$donnees['datenaissance'].'</td>';
                    echo '<td>'.$donnees['lieunaissance'].'</td>';
                    echo '<td>'.$donnees['numsecurite'].'</td>';
                    echo '<td>'.
                    '<a href="modification.php?id='.$donnees['pkpatient']
                    .' "> Modification</a>'
                    .'</td>';
                    echo '<td>'.
                    '<a href="suppression.php?id='.$donnees['pkpatient']
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