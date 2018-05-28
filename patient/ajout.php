<?php include '../secure.php';?>
<link rel="stylesheet" type="text/css" href="/css/header.css">
<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
<script src="/bootstrap/js/bootstrap.min.js"></script>

<form class="mt-5 mx-auto" style="width: 800px;"  action="ajout.php" method="post">


  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Civilité</label>
    <div class="col-sm-10">
      <select class="custom-select mr-sm-2" name="civilite" >
        <option selected value="1">Mr.</option>
        <option value="0">Mme</option>
      </select>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Nom</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="nom">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Prénom</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="prenom">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Adresse</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="adresse">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Date de naissance</label>
    <div class="col-sm-10">
        <input type="date" class="form-control" name="datenaissance">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Lieu de naissance</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="lieunaissance">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Numéro de sécurité sociale</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" name="numsecurite">
    </div>
  </div>
  <input class="btn btn-success float-right" type="submit" value="Valider" name="valid">
  </div>


</form>


<form action="ajout.php" method="post">
  <table>
    <caption>Ajout d'un patient</caption>
    <tbody>
      <td> Civilite : </td>
      <td>
        <input list="sexe" type="text" name="civilite" >
        <datalist id="sexe">
          <select name"civilite" >
            <option value="Mr.">
              <option value="Mme." >
              </datalist>
            </tbody>
            <tbody>
              <td>    Nom : </td>
              <td> <input type="text" name="nom" ></td>
            </tbody>
            <tbody>
              <td>    Prenom : </td>
              <td> <input type="text" name="prenom"></td>
            </tbody>
            <tbody>
              <td>     Adresse : </td>
              <td> <input type="text" name="adresse" ></td>
            </tbody>
            <tbody>
              <td>    Date naissance: </td>
              <td> <input type="date" name="datenaissance" ></td>
            </tbody>
            <tbody>
              <td>     Lieu naissance : </td>
              <td> <input type="text" name="lieunaissance" ></td>
            </tbody>
            <tbody>
              <td>     Numero Securite Sociale : </td>
              <td><input type="text" name="numsecurite" ></td>
            </tbody>
          </table>
          <input type="submit" value="Valider" name="valid">
        </form>

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
            'lcivilite' => $civ,
            'lnom' => $_POST['nom'],
            'lprenom' => $_POST['prenom'],
            'ladresse' => $_POST['adresse'],
            'ldatenaissance' => $_POST['datenaissance'],
            'llieunaissance' => $_POST['lieunaissance'],
            'lnumsecurite' => $_POST['numsecurite']
          ));
          //print_r($req->errorInfo());
          //echo "Contact modifié";
        }else{
          // echo "Contact non modifié";
        }

        ?>
