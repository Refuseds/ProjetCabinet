<html lang="fr">
<head>
	<meta charset="UTF-8" />




	<title> Affichage des medecins</title>
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
		$req = $linkpdo->prepare('  SELECT  *
			FROM medecin
			');
			$req->execute();
			?>
			<br>
			<div class="container">
				<h2>Liste des medecins</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Civilité</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Modification / suppression</th>
						</tr>
					</thead>
					<tbody>
						<?php
						while($donnees = $req->fetch()){
							echo '<tr>';
							if ( $donnees['civilite'] == '1' ) {
								echo '<td>Homme</td>';
							} else {
								echo '<td>Femme</td>';
							}
							echo '<td>'.$donnees['nom'].'</td>';
							echo '<td>'.$donnees['prenom'].'</td>';
							echo '<td>'.'<a href="modification.php?id='.$donnees['pkmedecin'].' ">
							<img  href="modification.php?id='.$donnees['pkmedecin'].' "src="/img/wrench.png">
								</a>'.'<a>&emsp;&emsp;&emsp;</a>'.'<a href="suppression.php?id='.$donnees['pkmedecin'].' ">
								<img  href="modification.php?id='.$donnees['pkmedecin'].' "src="/img/trash.png">
									</a>'.'</td>';

						}
						?>
					</tbody>
				</table>
			<a class="btn btn-success float-right" href=ajout.php> Ajouter un medecin </a>
			</div>
		</body>
		</html>
