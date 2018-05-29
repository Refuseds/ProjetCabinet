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
        //print_r($req->errorInfo());
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
							echo '<tr>';
							if ( $donnees['civilite'] == '1' ) {
								echo '<td>Homme</td>';
							} else {
								echo '<td>Femme</td>';
							}
							echo '<td>'.$donnees['nom'].'</td>';
							echo '<td>'.$donnees['prenom'].'</td>';
							echo '<td>'.
								'<a href="modification.php?id='.$donnees['pkmedecin'].' ">
									<img  href="modification.php?id='.$donnees['pkmedecin'].' "src="/img/wrench.png">
								</a>'.
								'<a>&emsp;&emsp;&emsp;</a>'.
								'<a data-toggle="modal" data-target="#suppression" href="#">
									<img  src="/img/trash.png">
								</a>'.
								
							'</td>';
						}
						?>
						
					</tbody>
				</table>
				<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
					Ajouter un medecin
				</button>
			</div>

				<!-- Modal Ajout-->
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



					<!-- Modal Suppression-->
					<div class="modal fade" id="suppression" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Supprimer médecin</h5>
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
