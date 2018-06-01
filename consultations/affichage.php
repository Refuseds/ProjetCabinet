<?php include '../secure.php';?>
<?php include '../connexionBDD.php';?>
<?php
  if ($_SESSION['login'] != 'ok') {
    // si un des champs d'identification est vide
    if ( (empty($_POST['id']) || empty($_POST['pw']) ) ) {
      $_SESSION["login"] = 'incomplet';
      header('Location: /index.php');
    } else {
      // connexion à la BDD
      try {
        $linkpdo = new PDO("mysql:host=localhost;dbname=cabinet", 'root', 'root');
      } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
      }

      // preparation de la requete
      $req = $linkpdo->prepare("SELECT password FROM login WHERE identifiant = :id");

      //Exécution de la requête avec les paramètres passés sous forme de tableau indexé
      $req->execute(array('id'=>$_POST['id'] ));
      $data = $req->fetch();
      // si requete fausse redirection sinon creation de session correcte
      if ($data == false ) {
        $_SESSION["login"] = 'incorrect';
        header('Location: /index.php');
      } else {
        if ( password_verify($_POST['pw'], $data[0]) ) {
          $_SESSION["login"] = 'ok';
        } else {
          header('Location: /index.php');
        }
      }
    }
  }
?>




<?php
  // ajout de données
  if( isset($_POST['valid'])){
    $req = $linkpdo->prepare('INSERT INTO rdv (
                                    date,
                                    heure,
                                    duree,
                                    fkpatient,
                                    fkmedecin
                                  )
                            VALUES(
                                :date,
                                :heure,
                                :duree,
                                :fkpatient,
                                :fkmedecin
                              )
                        ');
    $req->execute(array(
                        'date' => $_POST['date'],
                        'heure' => $_POST['heure'],
                        'duree' => $_POST['duree'],
                        'fkpatient' => $_POST['patient'],
                        'fkmedecin' =>$_POST['medecin']
    ));
  }
  // suppression de données
  if( isset($_POST['suppression'])) {
    $req = $linkpdo->prepare('DELETE FROM  rdv WHERE pkrdv = :pkrdv');
    $req->execute(array('pkrdv' => $_POST['pkrdv'],));
  }
  // modification de données
  if( isset($_POST['modification'])){
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
  <header>
    <?php include('../menu.php')?>
  </header>
  <body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

  	<?php
  		$reqrdv = $linkpdo->prepare("  SELECT  DATE_FORMAT(date, '%d/%m/%Y') AS date,
  											heure, duree, pkrdv, fkpatient, fkmedecin
  										 FROM rdv ORDER BY date DESC ");
  		$reqrdv->execute();
  	?>
		<br>
    <!-- tableau des RDV -->
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
            // remplissage du tableau
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
              echo '<td>'.'<a href="" data-toggle="modal" data-target="#modifier'.$rdv['pkrdv'].'"><img src="/img/wrench.png"></a>';
          ?>
          <!-- Modal de modification -->
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
                      <label class="col-sm-4 col-form-label">Date<span style="color: #fb4141">*</span></label>
                      <div class="col-sm-8">
                        <input type="date" value="<?php echo substr($rdv['date'], 6, 4).'-'.substr($rdv['date'], 3, 2).'-'.substr($rdv['date'], 0, 2); ?>" class="form-control" name="date" required>
                      </div>
                    </div>
                    <div class="form-group row">
    									<label class="col-sm-4 col-form-label">Heure<span style="color: #fb4141">*</span></label>
    									<div class="col-sm-8">
    										<input type="time" value="<?php echo $rdv['heure']; ?>" class="form-control" name="heure" required>
    									</div>
    								</div>
    								<div class="form-group row">
    									<label class="col-sm-4 col-form-label">Durée<span style="color: #fb4141">*</span></label>
    									<div class="col-sm-8">
    										<input type="time" value="<?php echo $rdv['duree']; ?>" class="form-control" name="duree" required>
    									</div>
    								</div>
                    <div class="form-group row">
    									<label class="col-sm-4 col-form-label">Patient<span style="color: #fb4141">*</span></label>
    									<div class="col-sm-8">
    										<select class="custom-select mr-sm-2" name="fkpatient" required>
                          <?php
                            $req_patient_selection = $linkpdo->prepare('SELECT * FROM patient');
                            $req_patient_selection->execute();
                            while($patient_selection = $req_patient_selection->fetch()){
                              // permet de donner une seleciton du patient correspondant au RDV
                              if ( $patient_selection['pkpatient'] == $rdv['fkpatient']) {
                                echo '<option selected value="'.$patient_selection['pkpatient'].'"> '.$patient_selection['nom'].' '.$patient_selection['prenom'].'</option>';
                              } else {
                                echo '<option value="'.$patient_selection['pkpatient'].'"> '.$patient_selection['nom'].' '.$patient_selection['prenom'].'</option>';
                              }
                            }
                           ?>
    										</select>
    									</div>
    								</div>
    								<div class="form-group row">
    									<label class="col-sm-4 col-form-label">Docteur<span style="color: #fb4141">*</span></label>
    									<div class="col-sm-8">
    										<select class="custom-select mr-sm-2" name="fkmedecin" >
                          <?php
                            $req_medecin_selection = $linkpdo->prepare('SELECT * FROM medecin');
                            $req_medecin_selection->execute();
                            while($medecin_selection = $req_medecin_selection->fetch()){
                              // permet de donner une seleciton du medecin correspondant au RDV
                              if ( $medecin_selection['pkmedecin'] == $rdv['fkmedecin']) {
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
                    <input type="hidden" value="<?php echo $rdv['pkrdv'];?>" name="pkrdv" />
                    <input class="btn btn-success float-right" type="submit" value="Enregistrer les modifications" name="modification">
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!--  bouton de suppression -->
          <?php
            // espace entre les deux icones modifier et supprimer
            echo '<a>&emsp;&emsp;&emsp;</a>';
            // bouton pointant la modale de suppression
            echo '<a href="" data-toggle="modal" data-target="#supprimer'.$rdv['pkrdv'].'"><img src="/img/trash.png"></a></td>';
          ?>
          <!-- Modale de suppression-->
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
          </div>
          <?php } ?>
				</tbody>
			</table>
      <!-- bouton d'ajout de RDV-->
			<button type="button" class="btn btn-success float-right ajouter" data-toggle="modal" data-target="#ajout">
				Ajouter une consultation
			</button>
		</div>
			<!-- Modal d'ajout de RDV -->
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
									<label class="col-sm-4 col-form-label">Date<span style="color: #fb4141">*</span></label>
									<div class="col-sm-8">
										<input type="date" class="form-control" name="date" min="<?php echo date("Y-m-d");?>" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Heure<span style="color: #fb4141">*</span></label>
									<div class="col-sm-8">
										<input type="time" class="form-control" name="heure" min="08:00" max="17:00" required>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Durée<span style="color: #fb4141">*</span></label>
									<div class="col-sm-8">
										<input type="time" value="00:30" class="form-control" name="duree">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Patient<span style="color: #fb4141">*</span></label>
									<div class="col-sm-8">
										<select  id="patient" class="custom-select mr-sm-2" name="patient" onChange="maFonction()" required>
  										<option value =""> Veuillez choisir un patient </option>
                        <!-- injection de la liste de patient -->
  											<?php
  										    $reqpatient = $linkpdo->prepare('SELECT * FROM patient ');
  										    $reqpatient->execute();
  												while($p=$reqpatient->fetch()){
  													echo '<option value="'.$p['pkpatient'].'"> '.$p['nom'].' '.$p['prenom'].'</option>';
  											  }
                        ?>
										</select>
									</div>
								</div>
                <script language="Javascript" >

                  function maFonction()
                  {
                      //var marque = $(":select[name=patient]").value();    // On récupère la valeur du sélect ayant pour id "patient"
                      var patient = document.getElementById("patient").value;
                     // alert("i = "+ patient);
                     // $("#cc").html("Hello, World!");

                     $.post('avoirMedecin.php',               // AJAX : On appelle un script php
                      {id_patient: patient},          // Passage de la variable en paramètre
                          function(data){
                        $('#selection_medecin_defaut').html(data);             // On ajoute le résultat de se script dans la balise qui a pour id "conteneur". (un div ou un span comme tu le souhaites)
                    });
                                  }
                </script>
								<div class="form-group row">
									<label class="col-sm-4 col-form-label">Docteur<span style="color: #fb4141">*</span></label>
									<div class="col-sm-8" id="selection_medecin_defaut" >

                      <select class="custom-select mr-sm-2" name="medecin" required>

                          <option value="" > Veuillez choisir un médecin </option>
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
              </form>
						</div>
					</div>
				</div>
			</div>
	</body>
</html>
