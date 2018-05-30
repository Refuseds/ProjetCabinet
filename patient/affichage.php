<?php include '../secure.php';?>
<?php
// ajout de données
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
}

if ( isset($_POST['suppression'])) {
	$server = 'localhost';
	$login = 'root';
	$mdp = 'root';
	try {
		$linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	};

	$req = $linkpdo->prepare('DELETE FROM patient WHERE pkpatient = :pk');
	$req->execute(array('pk' => $_POST['pkpatient'] ));
}
?>
<html lang="fr">
<head>
	<meta charset="UTF-8" />
	<title> Affichage</title>
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
		$req = $linkpdo->prepare(" SELECT  pkpatient,civilite,nom,prenom,adresse,
			DATE_FORMAT(datenaissance, '%d/%m/%Y') AS datenaissance,
			lieunaissance,
			numsecurite
			FROM patient
			");
			$req->execute();
			?>
			<br>
			<div class="container">
				<h2>Liste des patients</h2>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>Civilité</th>
							<th>Nom</th>
							<th>Prénom</th>
							<th>Adresse</th>
							<th>Date de naissance</th>
							<th>Lieu de naissance</th>
							<th>Sécurité sociale</th>
							<th>Modification / suppression</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// construction des données du tableau
						while($donnees = $req->fetch()){
							echo '<tr>';
							if ( $donnees['civilite'] == '1' ) {
								echo '<td>Homme</td>';
							} else {
								echo '<td>Femme</td>';
							}
							echo '<td>'.$donnees['nom'].'</td>';
							echo '<td>'.$donnees['prenom'].'</td>';
							echo '<td>'.$donnees['adresse'].'</td>';
							echo '<td>'.$donnees['datenaissance'].'</td>';
							echo '<td>'.$donnees['lieunaissance'].'</td>';
							echo '<td>'.$donnees['numsecurite'].'</td>';
							// bouton pointant la modale de modification
							echo '<td>'.'<a data-toggle="modal" data-target="#modifier'.$donnees['pkpatient'].'"><img src="/img/wrench.png"></a>';

							// modal de mofification
							?>
							<div class="modal fade" id="modifier<?php echo $donnees['pkpatient'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Modifier un patient</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="affichage.php" method="post">
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">Civilité</label>
													<div class="col-sm-8">
														<select class="custom-select mr-sm-2" name="civilite" >
															<option <?php if ($donnees['civilite'] == 1 ) {echo 'selected ';} ?> value="1">Mr.</option>
															<option <?php if ($donnees['civilite'] == 0 ) {echo 'selected ';} ?> value="0">Mme</option>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">Nom</label>
													<div class="col-sm-8">
														<input type="text" value="<?php echo $donnees['nom'];?>" class="form-control" name="nom">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">Prénom</label>
													<div class="col-sm-8">
														<input type="text" value="<?php echo $donnees['prenom'];?>" class="form-control" name="prenom">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">Adresse</label>
													<div class="col-sm-8">
														<input type="text" value="<?php echo $donnees['adresse'];?>" class="form-control" name="adresse">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">Date de naissance</label>
													<div class="col-sm-8">
														<input type="date" value="<?php echo $donnees['datenaissance'];?>" class="form-control" name="datenaissance">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">Lieu de naissance</label>
													<div class="col-sm-8">
														<input type="text" value="<?php echo $donnees['lieunaissance'];?>" class="form-control" name="lieunaissance">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-sm-4 col-form-label">N° sécurité sociale</label>
													<div class="col-sm-8">
														<input type="text" value="<?php echo $donnees['numsecurite'];?>" class="form-control" name="numsecurite">
													</div>
												</div>
												<br>
												<input class="btn btn-success float-right" type="submit" value="Valider" name="valid">
											</div>
										</form>
									</div>
								</div>
							</div>
							<?php
							// espace entre les deux icones modifier et supprimer
							echo '<a>&emsp;&emsp;&emsp;</a>';
							// bouton pointant la modale de suppression
							echo '<a data-toggle="modal" data-target="#supprimer'.$donnees['pkpatient'].'"><img src="/img/trash.png"></a></td>';
							// modal de Suppression
							?>
							<div class="modal fade" id="supprimer<?php echo $donnees['pkpatient'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      					<div class="modal-dialog" role="document">
      						<div class="modal-content">
      							<div class="modal-header">
      								<h5 class="modal-title" id="exampleModalLabel">Confirmation de Suppression</h5>
      								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
      									<span aria-hidden="true">&times;</span>
      								</button>
      							</div>
      							<div class="modal-body">
                    <br>
                    <a> Êtes-vous sûr de vouloir supprimer le patient  <b>'<?php echo $donnees['prenom'].' '.$donnees['nom'];?></b>  ?
      								<form action="affichage.php" method="post">
      									<br>
                        <input type="hidden" value="<?php echo $donnees['pkpatient'];?>" name="pkpatient" />
      									<input class="btn btn-outline-danger float-right" type="submit" value="Supprimer" name="suppression">
      							</form>
      						</div>
      					</div>
      				</div>
						<?php } ?>
					</tbody>
				</table>
			<!-- Boutton pointant vers la modale d'ajout -->
			<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
				Ajouter un patient
			</button>
		</div>

			<!-- Modale d'ajout -->
			<div class="modal fade" id="ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau patient</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="affichage.php" method="post">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Civilité</label>
									<div class="col-sm-8">
										<select class="custom-select mr-sm-2" name="civilite" >
											<option selected value="1">Mr.</option>
											<option value="0">Mme</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Nom</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="nom">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Prénom</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="prenom">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Adresse</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="adresse">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Date de naissance</label>
									<div class="col-sm-8">
										<input type="date" class="form-control" name="datenaissance">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Lieu de naissance</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="lieunaissance">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">N° sécurité sociale</label>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="numsecurite">
									</div>
								</div>
								<br>
								<input class="btn btn-success float-right" type="submit" value="Valider" name="valid">
							</div>
						</form>
					</div>
				</div>
			</div>
		</body>
</html>
