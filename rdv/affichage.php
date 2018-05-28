<?php include '../secure.php';?>
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
		<br>
		<div class="container">
			<h2>Liste des RDV</h2>
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Date</th>
						<th>Heure</th>
						<th>Durée</th>
						<th>Nom du patient</th>
						<th>Prénom du patient</th>
						<th>Nom du médecin</th>
						<th>Prénom du médecin</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while($rdv = $reqrdv->fetch()){
						echo '<tr>';
						echo '<td>'.$rdv['date'].'</td>';
						echo '<td>'.$rdv['heure'].'</td>';
						echo '<td>'.$rdv['duree'].'</td>';

						$reqpatient = $linkpdo->prepare('SELECT * FROM patient WHERE pkrdv LIKE :lid');
						$reqpatient->execute(array('lid' => $rdv['fkpatient']));
						$p = $reqpatient->fetch();
						echo '<td>'.$p['nom'].'</td>';
						echo '<td>'.$p['prenom'].'</td>';

						$reqmedecin = $linkpdo->prepare('SELECT * FROM medecin WHERE pkmedecin LIKE :lid');
						$reqmedecin->execute(array('lid' => $rdv['fkmedecin']));
						$m = $reqmedecin->fetch();
						echo '<td>'.$m['nom'].'</td>';
						echo '<td>'.$m['prenom'].'</td>';
						echo '<td>'.'<a href="modification.php?id='.$rdv['pkrdv'].' ">
						<img  href="modification.php?id='.$rdv['pkrdv'].' "src="/img/wrench.png">
						</a>'.'<a>&emsp;&emsp;&emsp;</a>'.'<a href="suppression.php?id='.$rdv['pkrdv'].' ">
						<img  href="modification.php?id='.$rdv['pkrdv'].' "src="/img/trash.png">
						</a>'.'</td>';
						echo '</tr>';
					}
					?>
				</tbody>
			</table>
			<a class="btn btn-success float-right" href=ajout.php> Ajouter un RDV </a>
		</div>
	</body>
</html>
