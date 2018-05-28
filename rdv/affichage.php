<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		



		<title> Affichage des rdv</title>
    </head>
    
    <body>
         <header>
            <?php include('../menu.php')?>
        </header>
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
                $reqrdv = $linkpdo->prepare('  SELECT  * FROM rdv ');
                $reqrdv->execute();  
              
            ?>

       <table>
        <caption>Liste des RDV</caption>
        <thead> 
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th>----Patient----</th>
                <th></th>
                <th>----Medecin----</th>
            </tr>
        </thead>
        <thead> 
            <tr>
                <th>----Date----</th>
                <th>----Heure----</th>
                <th>----Duree----</th>
                <th>----Nom----</th>
                <th>----Prenom----</th>
                <th>----Nom----</th>
                <th>----Prenom----</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody> 
            <?php
            while($rdv = $reqrdv->fetch()){
                echo '<tr>';
                    echo '<td>'.$rdv['date'].'</td>';
                    echo '<td>'.$rdv['heure'].'</td>';
                    echo '<td>'.$rdv['duree'].'</td>';

                    $reqpatient = $linkpdo->prepare('SELECT * FROM patient WHERE pkpatient LIKE :lid');
                    $reqpatient->execute(array('lid' => $rdv['fkpatient'])); 
                    $p = $reqpatient->fetch();
                    echo '<td>'.$p['nom'].'</td>';
                    echo '<td>'.$p['prenom'].'</td>';

                    $reqmedecin = $linkpdo->prepare('SELECT * FROM medecin WHERE pkmedecin LIKE :lid');
                    $reqmedecin->execute(array('lid' => $rdv['fkmedecin']));
                    $m = $reqmedecin->fetch();
                    echo '<td>'.$m['nom'].'</td>';
                    echo '<td>'.$m['prenom'].'</td>';
                echo '</tr>';
            }

            ?>
        </tbody>
    </table>


    <a href=ajout.php> Ajout </a>

    </body>
</html>