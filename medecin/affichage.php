<?php include '../secure.php';?>
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

    if($_POST['civilite'] == "Mme."){
        $civ = 0;
    }else if($_POST['civilite'] == "Mr."){
        $civ = 1;
    }else if($_POST['civilite'] == ""){
        echo " Champ civilité non renseigné";
    }

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
}
if( isset($_POST['suppression'])) {
  $server = 'localhost';
  $login = 'root';
  $mdp = 'root';
  try {
      $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
  }
  catch (Exception $e) {
      die('Erreur : ' . $e->getMessage());
  };

  $req = $linkpdo->prepare('DELETE FROM  medecin WHERE pkmedecin = :pk');
  $req->execute(array('pk' => $_POST['pkmedecin'],));
}
?>
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
              // construction des données du tableau
							echo '<tr>';
							if ( $donnees['civilite'] == '1' ) {
								echo '<td>Homme</td>';
							} else {
								echo '<td>Femme</td>';
							}
							echo '<td>'.$donnees['nom'].'</td>';
							echo '<td>'.$donnees['prenom'].'</td>';

              // bouton pointant la modale de modification
							echo '<td>'.'<a data-toggle="modal" data-target="#modifier'.$donnees['pkmedecin'].'"><img src="/img/wrench.png"></a>';

              // modal de mofification
							?>
							<div class="modal fade" id="modifier<?php echo $donnees['pkmedecin'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Modifier un medecin</h5>
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
							echo '<a data-toggle="modal" data-target="#supprimer'.$donnees['pkmedecin'].'"><img src="/img/trash.png"></a></td>';
							// modal de Suppression
							?>
							<div class="modal fade" id="supprimer<?php echo $donnees['pkmedecin'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" value="<?php echo $donnees['pkmedecin'];?>" name="pkmedecin" />
      									<input class="btn btn-outline-danger float-right" type="submit" value="Supprimer" name="suppression">
      							</form>
      						</div>
      					</div>
      				</div>
						<?php } ?>
					</tbody>
				</table>
        <!-- Bouton pointant vers la modale d'ajout de medecin -->
				<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
					Ajouter un médecin
				</button>
			</div>
				<!-- Modal d'ajout d'un medecin  -->
				<div class="modal fade" id="ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau médecin</h5>
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
												<option selected value="1">Mr</option>
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
									<br>
									<input class="btn btn-success float-right" type="submit" value="Valider" name="valid">
								</div>
							</form>
						</div>
					</div>
				</div>
		</body>
		</html>
