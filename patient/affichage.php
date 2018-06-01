<?php include '../secure.php';?>
<?php include '../connexionBDD.php';?>
<?php
// ajout de données
if( isset($_POST['valid'])){
	$req = $linkpdo->prepare('INSERT INTO patient (
		civilite,
		nom,
		prenom,
		adresse,
		datenaissance,
		lieunaissance,
		numsecurite,
		fkmedecin
	)
	VALUES(
		:lcivilite,
		:lnom,
		:lprenom,
		:ladresse,
		:ldatenaissance,
		:llieunaissance,
		:lnumsecurite,
		:lfkmedecin
	)
	');
	$req->execute(array(
		'lcivilite' => $_POST['civilite'],
		'lnom' => $_POST['nom'],
		'lprenom' => $_POST['prenom'],
		'ladresse' => $_POST['adresse'],
		'ldatenaissance' => $_POST['datenaissance'],
		'llieunaissance' => $_POST['lieunaissance'],
		'lnumsecurite' => $_POST['numsecurite'],
		'lfkmedecin' => $_POST['medecin']
	));
}
// suppression de données
if ( isset($_POST['suppression'])) {
	$req = $linkpdo->prepare('DELETE FROM patient WHERE pkpatient = :pk');
	$req->execute(array('pk' => $_POST['pkpatient'] ));
}
// modification de donnée
if( isset($_POST['modification'])){
	$req = $linkpdo->prepare('UPDATE patient SET civilite = :lcivilite, nom = :lnom, prenom = :lprenom, adresse = :ladresse,
		datenaissance = :ldatenaissance,	lieunaissance = :llieunaissance,	numsecurite = :lnumsecurite, fkmedecin = :lfkmedecin WHERE pkpatient = :lpk');
	$req->execute(array(
		'lcivilite' => $_POST['civilite'],
		'lnom' => $_POST['nom'],
		'lprenom' => $_POST['prenom'],
		'ladresse' => $_POST['adresse'],
		'ldatenaissance' => $_POST['datenaissance'],
		'llieunaissance' => $_POST['lieunaissance'],
		'lnumsecurite' => $_POST['numsecurite'],
		'lpk' => $_POST['pkpatient'],
		'lfkmedecin' => $_POST['fkmedecin']
	));
}
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8" />
		<title> Affichage</title>
	</head>
	<header>
		<?php include('../menu.php')?>
	</header>
	<body>
		<?php
		// liste des patients
		$req_liste_patient = $linkpdo->prepare(" SELECT  pkpatient,civilite,nom,prenom,adresse,fkmedecin,
			DATE_FORMAT(datenaissance, '%d/%m/%Y') AS datenaissance,
			lieunaissance,
			numsecurite
			FROM patient
			");
		$req_liste_patient->execute();
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
						<th>Médecin traitant</th>
						<th>Modification / suppression</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// construction des données du tableau
					while($donnees_patient = $req_liste_patient->fetch()){
						echo '<tr>';
						if ( $donnees_patient['civilite'] == '1' ) {
							echo '<td>Mr.</td>';
						} else {
							echo '<td>Mme.</td>';
						}
						echo '<td>'.$donnees_patient['nom'].'</td>';
						echo '<td>'.$donnees_patient['prenom'].'</td>';
						echo '<td>'.$donnees_patient['adresse'].'</td>';
						echo '<td>'.$donnees_patient['datenaissance'].'</td>';
						echo '<td>'.$donnees_patient['lieunaissance'].'</td>';
						echo '<td>'.$donnees_patient['numsecurite'].'</td>';
						$req_medecin_traitant =  $linkpdo->prepare("SELECT nom FROM medecin WHERE pkmedecin LIKE :lfkmedecin");
						$req_medecin_traitant -> execute(array('lfkmedecin' => $donnees_patient['fkmedecin']));
						$donnees_medecin = $req_medecin_traitant->fetch();
						if($donnees_medecin['nom'] == ''){
							echo '<td> Non assigné </td>';
						}else{
							echo '<td> Dr. '.$donnees_medecin['nom'].'</td>';
						}

						// bouton pointant la modale de modification
						echo '<td>'.'<a href="" data-toggle="modal" data-target="#modifier'.$donnees_patient['pkpatient'].'"><img src="/img/wrench.png"></a>';

						// modal de mofification
					?>
						<div class="modal fade" id="modifier<?php echo $donnees_patient['pkpatient'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
														<option <?php if ($donnees_patient['civilite'] == 1 ) {echo 'selected ';} ?> value="1">Mr.</option>
														<option <?php if ($donnees_patient['civilite'] == 0 ) {echo 'selected ';} ?> value="0">Mme</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Nom<span style="color: #fb4141">*</span></label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo $donnees_patient['nom'];?>" class="form-control" name="nom" required>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Prénom<span style="color: #fb4141">*</span></label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo $donnees_patient['prenom'];?>" class="form-control" name="prenom" required>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Adresse</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo $donnees_patient['adresse'];?>" class="form-control" name="adresse">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Date de naissance<span style="color: #fb4141">*</span></label>
												<div class="col-sm-8">
													<input type="date" value="<?php echo substr($donnees_patient['datenaissance'], 6, 4).'-'.substr($donnees_patient['datenaissance'], 3, 2).'-'.substr($donnees_patient['datenaissance'], 0, 2); ?>" class="form-control" name="datenaissance" max="<?php echo date("Y-m-d");?>" required>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Lieu de naissance</label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo $donnees_patient['lieunaissance'];?>" class="form-control" name="lieunaissance" >
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">N° sécurité sociale<span style="color: #fb4141">*</span></label>
												<div class="col-sm-8">
													<input type="text" value="<?php echo $donnees_patient['numsecurite'];?>" class="form-control" name="numsecurite" required>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-4 col-form-label">Docteur</label>
												<div class="col-sm-8">
													<select class="custom-select mr-sm-2" name="fkmedecin" >
														<?php
														if($donnees_patient['fkmedecin'=='']){
															echo '<option selected value="NULL"> Aucun médecin assigné </option>';

														}
															$req_medecin_selection = $linkpdo->prepare('SELECT * FROM medecin');
															$req_medecin_selection->execute();
															while($medecin_selection = $req_medecin_selection->fetch()){
																// permet de donner une seleciton du medecin correspondant au patient
																if ( $medecin_selection['pkmedecin'] == $donnees_patient['fkmedecin']) {
																	echo '<option selected value="'.$medecin_selection['pkmedecin'].'"> '.$medecin_selection['nom'].' '.$medecin_selection['prenom'].'</option>';
																} else {
																	echo '<option value="'.$medecin_selection['pkmedecin'].'"> '.$medecin_selection['nom'].' '.$medecin_selection['prenom'].'</option>';
																}
															}
														?>
													</select>
												</div>
											</div>
											<br>
											<label class="col-sm-4 col-form-label"><span style="color: #fb4141">*<font size="-2"> Champs obligatoires</font></span></label>
											<input type="hidden" value="<?php echo $donnees_patient['pkpatient'];?>" name="pkpatient">
											<input class="btn btn-success float-right" type="submit" value="Enregitrer les modifications" name="modification">
										</div>
									</form>
								</div>
							</div>
						</div>
						<?php
						// espace entre les deux icones modifier et supprimer
						echo '<a>&emsp;&emsp;&emsp;</a>';
						// bouton pointant la modale de suppression
						echo '<a href="" data-toggle="modal" data-target="#supprimer'.$donnees_patient['pkpatient'].'"><img src="/img/trash.png"></a></td>';
						// modal de Suppression
						?>
						<div class="modal fade" id="supprimer<?php echo $donnees_patient['pkpatient'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <a> Êtes-vous sûr de vouloir supprimer le patient  <b>'<?php echo $donnees_patient['prenom'].' '.$donnees_patient['nom'];?></b>  ?
    								<form action="affichage.php" method="post">
    									<br>
                      <input type="hidden" value="<?php echo $donnees_patient['pkpatient'];?>" name="pkpatient">
    									<input class="btn btn-outline-danger float-right" type="submit" value="Supprimer" name="suppression">
    							</form>
    						</div>
    					</div>
    				</div>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<!-- Boutton pointant vers la modale d'ajout -->
		<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
			Ajouter un patient
		</button>
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
								<label class="col-sm-4 col-form-label">Nom<span style="color: #fb4141">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="nom" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Prénom<span style="color: #fb4141">*</span></label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="prenom" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Adresse</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="adresse">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Date de naissance<span style="color: #fb4141">*</span></label>
								<div class="col-sm-8">
									<input type="date" class="form-control" name="datenaissance" max="<?php echo date("Y-m-d");?>" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Lieu de naissance</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="lieunaissance">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">N° sécurité sociale<span style="color: #fb4141">*</span></label>
								<div class="col-sm-8">
								<!--	<input type="number" class="form-control" name="numsecurite" min="99999999999999" max="1000000000000000" required>-->
									<input type="text" class="form-control" name="numsecurite" pattern="[0-9]{15}" title="15 chiffres"required>

								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Médecin traitant</label>
								<div class="col-sm-8">
									<select class="custom-select mr-sm-2" name="medecin" >
										<option> Veuillez choisir un médecin </option>
										<!-- injection de la liste de medecin -->
										<?php
										$reqmedecin = $linkpdo->prepare('SELECT * FROM medecin ');
										$reqmedecin->execute();
												while($m=$reqmedecin->fetch()){
													echo '<option value="'.$m['pkmedecin'].'"> '.$m['nom'].' '.$m['prenom'].'</option>';
												}
										?>
									</select>
								</div>
							</div>
							<br>
							<label class="col-sm-4 col-form-label"><span style="color: #fb4141">*<font size="-2"> Champs obligatoires</font></span></label>
							<input class="btn btn-success float-right" type="submit" value="Valider" name="valid">
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
