<?php include '../secure.php';?>
<?php
// ajout de données
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
// suppression de données
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

  $req = $linkpdo->prepare('DELETE FROM  rdv WHERE pkrdv = :pkrdv');
  $req->execute(array('pkrdv' => $_POST['pkrdv'],));
}
// modification de données
if( isset($_POST['modification'])){
    $server = 'localhost';
    $login = 'root';
    $mdp = 'root';
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    };
    $req = $linkpdo->prepare('UPDATE rdv SET date = :date, heure = :heure, duree = :duree, fkpatient = :fkpatient, fkmedecin = :fkmedecin WHERE pkrdv = :pkrdv');
    $req->execute(array(
                        'date' => $_POST['date'],
                        'heure' => $_POST['heure'],
                        'duree' => $_POST['duree'],
                        'fkpatient' => $_POST['fkpatient'],
                        'fkmedecin' => $_POST['fkmedecin'],
                        'pkrdv' => $_POST['pkrdv']
    ));
}
?>
<html lang="fr">
<head>
	<meta charset="UTF-8" />
	<title> Affichage des consultations</title>
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
		$reqrdv = $linkpdo->prepare("  SELECT  DATE_FORMAT(date, '%d/%m/%Y') AS date,
											heure, duree, pkrdv, fkpatient, fkmedecin
										 FROM rdv ORDER BY date DESC ");
		$reqrdv->execute();
		?>
		<br>
		<div class="container">
			<h2>Liste des consultations</h2>
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

            // bouton pointant la modale de modification
            echo '<td>'.'<a data-toggle="modal" data-target="#modifier'.$rdv['pkrdv'].'"><img src="/img/wrench.png"></a>';

            // modal de mofification
            ?>
            <div class="modal fade" id="modifier<?php echo $rdv['pkrdv'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modifier un RDV</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="affichage.php" method="post">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Date</label>
                        <div class="col-sm-8">
                          <input type="date" value="<?php echo substr($rdv['date'], 6, 4).'-'.substr($rdv['date'], 3, 2).'-'.substr($rdv['date'], 0, 2); ?>" class="form-control" name="datenaissance">
                        </div>
                      </div>
                      <div class="form-group row">
      									<label class="col-sm-4 col-form-label">Heure</label>
      									<div class="col-sm-8">
      										<input type="time" value="<?php echo $rdv['heure']; ?>" class="form-control" name="heure">
      									</div>
      								</div>
      								<div class="form-group row">
      									<label class="col-sm-4 col-form-label">Durée</label>
      									<div class="col-sm-8">
      										<input type="time" value="<?php echo $rdv['duree']; ?>" class="form-control" name="duree">
      									</div>
      								</div>



                      <div class="form-group row">
      									<label class="col-sm-4 col-form-label">Patient</label>
      									<div class="col-sm-8">
      										<select class="custom-select mr-sm-2" name="fkpatient" >
      											
      										</select>
      									</div>
      								</div>
      								<div class="form-group row">
      									<label class="col-sm-4 col-form-label">Docteur</label>
      									<div class="col-sm-8">
      										<select class="custom-select mr-sm-2" name="fkmedecin" >
      											<?php ?>
      										</select>
      									</div>
      								</div>



                      <br>
                      <input type="hidden" value="<?php echo $rdv['pkrdv'];?>" name="pkrdv" />
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
            echo '<a data-toggle="modal" data-target="#supprimer'.$rdv['pkrdv'].'"><img src="/img/trash.png"></a></td>';
            // modal de Suppression
            ?>
            <div class="modal fade" id="supprimer<?php echo $rdv['pkrdv'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                  <a> Êtes-vous sûr de vouloir supprimer le RDV du Dr <b>'<?php echo $m['prenom'].' '.$m['nom'];?></b>
                     le <b><?php echo $rdv['date'];?></b> à <b><?php echo $rdv['heure'];?></b> ?
                    <form action="affichage.php" method="post">
                      <br>
                      <input type="hidden" value="<?php echo $rdv['pkrdv'];?>" name="pkrdv" />
                      <input class="btn btn-outline-danger float-right" type="submit" value="Supprimer" name="suppression">
                  </form>
                </div>
              </div>
            </div>
          <?php } ?>
				</tbody>
			</table>
			<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
				Ajouter une consultation
			</button>
		</div>

			<!-- Modal -->
			<div class="modal fade" id="ajout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Ajouter une consultation</h5>
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
										<option> Veuillez choisir un patient </option>

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
										<option> Veuillez choisir un médecin </option>

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
