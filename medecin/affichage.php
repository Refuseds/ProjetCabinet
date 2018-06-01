<?php include '../secure.php';?>
<?php include '../connexionBDD.php';?>
<?php
// ajout de données
if( isset($_POST['valid'])){
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
// suppression de données
if( isset($_POST['suppression'])) {
  $req = $linkpdo->prepare('DELETE FROM  medecin WHERE pkmedecin = :pk');
  $req->execute(array('pk' => $_POST['pkmedecin'],));
}
// modification de données
if( isset($_POST['modification'])){
    $req = $linkpdo->prepare('UPDATE medecin SET civilite = :lcivilite, nom = :lnom, prenom = :lprenom WHERE pkmedecin = :lpk');
    $req->execute(array(
                        'lcivilite' => $_POST['civilite'],
                        'lnom' => $_POST['nom'],
                        'lprenom' => $_POST['prenom'],
                        'lpk' => $_POST['pkmedecin']
    ));
}
?>
<html lang="fr">
  <head>
  	<meta charset="UTF-8" />
  	<title> Affichage des medecins</title>
  </head>
  	<header>
  	 <?php include('../menu.php')?>
  	</header>
  <body>
  	<?php
  		$req = $linkpdo->prepare('SELECT * FROM medecin');
  		$req->execute();
  	?>
    <!-- tableau de medecins -->
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
              // transforme le stockage en format binaire en Homme / Femme
  						echo '<tr>';
  						if ( $donnees['civilite'] == '1' ) {
  							echo '<td>Mr.</td>';
  						} else {
  							echo '<td>Mme.</td>';
  						}
  						echo '<td>'.$donnees['nom'].'</td>';
  						echo '<td>'.$donnees['prenom'].'</td>';

              // bouton pointant la modale de modification
  						echo '<td>'.'<a href="" data-toggle="modal" data-target="#modifier'.$donnees['pkmedecin'].'"><img src="/img/wrench.png"></a>';

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
  											<label class="col-sm-4 col-form-label">Nom<span style="color: #fb4141">*</span></label>
  											<div class="col-sm-8">
  												<input type="text" value="<?php echo $donnees['nom'];?>" class="form-control" name="nom" required>
  											</div>
  										</div>
  										<div class="form-group row">
  											<label class="col-sm-4 col-form-label">Prénom<span style="color: #fb4141">*</span></label>
  											<div class="col-sm-8">
  												<input type="text" value="<?php echo $donnees['prenom'];?>" class="form-control" name="prenom" required>
  											</div>
  										</div>
  										<br>
											<label class="col-sm-4 col-form-label"><span style="color: #fb4141">*<font size="-2"> Champs obligatoires</font></span></label>
                      <input type="hidden" value="<?php echo $donnees['pkmedecin'];?>" name="pkmedecin" />
  										<input class="btn btn-success float-right" type="submit" value="Enregistrer les modifications" name="modification">
  									</div>
  								</form>
  							</div>
  						</div>
  					</div>
  				<?php
  					// espace entre les deux icones modifier et supprimer
  					echo '<a>&emsp;&emsp;&emsp;</a>';
  					// bouton pointant la modale de suppression
  					echo '<a href="" data-toggle="modal" data-target="#supprimer'.$donnees['pkmedecin'].'"><img src="/img/trash.png"></a></td>';
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
          </div>
  				<?php } ?>
  			</tbody>
  		</table>
  	</div>
    <!-- Bouton pointant vers la modale d'ajout de medecin -->
    <button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
      Ajouter un médecin
    </button>
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
  							<label class="col-sm-4 col-form-labels">Civilité</label>
  							<div class="col-sm-8">
  								<select class="custom-select mr-sm-2" name="civilite" >
  									<option selected value="1">Mr</option>
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
