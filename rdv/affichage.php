<?php include '../secure.php';?>
<?php
    if( isset($_POST['valid'])){
        echo strtok($_POST['patient']," ");


        $server = 'localhost';
        $login = 'root';
        $mdp = 'root';
        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        };
        $req = $linkpdo->prepare('INSERT INTO rdv (
                                        date,
                                        heure,
                                        duree,
                                        fkpatient,
                                        fkmedecin
                                      )
                                VALUES(
                                    :ldate,
                                    :lheure,
                                    :lduree,
                                    :lfkpatient,
                                    :lfkpatient
                                  )
                            ');
        $req->execute(array(
                            'ldate' => $_POST['date'],
                            'lheure' => $_POST['heure'],
                            'lduree' => $_POST['duree'],
                            'lfkpatient' => $_POST['patient'],
                            'lfkpatient' =>$_POST['medecin']
        ));

    }
?>
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
			<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
				Ajouter un RDV
			</button>
		</div>

			<!-- Modal -->
			<div class="modal fade" id="ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ajouter un RDV</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="affichage.php" method="post">
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control" name="date">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Heure</label>
									<div class="col-sm-8">
										<input type="time" class="form-control" name="heure">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Durée</label>
									<div class="col-sm-8">
										<input type="time" value="00:30" class="form-control" name="duree">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Patient</label>
									<div class="col-sm-8">
										<select class="custom-select mr-sm-2" name="patient" >
											<?php
											    $server = 'localhost';
											    $login = 'root';
											    $mdp = 'root';
											    try {
											        $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); }
											    catch (Exception $e) {
											        die('Erreur : ' . $e->getMessage());
											    };
											    $reqpatient = $linkpdo->prepare('SELECT * FROM patient ');
											    $reqpatient->execute();
	                    while($p=$reqpatient->fetch()){
	                        echo '<option value="'.$p['pkpatient'].'"> '.$p['nom'].' '.$p['prenom'].'</option>';
	                    }?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Docteur</label>
									<div class="col-sm-8">
										<select class="custom-select mr-sm-2" name="medecin" >
											<?php
											    $server = 'localhost';
											    $login = 'root';
											    $mdp = 'root';
											    try {
											        $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); }
											    catch (Exception $e) {
											        die('Erreur : ' . $e->getMessage());
											    };
											    $reqmedecin = $linkpdo->prepare('SELECT * FROM medecin ');
											    $reqmedecin->execute();
	                    while($m=$reqmedecin->fetch()){
	                        echo '<option value="'.$m['pkmedecin'].'"> '.$m['nom'].' '.$m['prenom'].'</option>';
	                    }?>
										</select>
									</div>
								</div>
								<br>
								<input class="btn btn-success float-right" type="submit" value="Valider" name="valid">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
