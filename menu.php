<head>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
  <script src="/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="/css/ajout.css">

</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
    <img src="/img/medical.png" width="30" height="30" class="d-inline-block align-top" alt="">
    Cabinet Medical</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link <?php if ( (substr($_SERVER['REQUEST_URI'], 1, 7)) == "medecin" ) { echo "active";}?> " href="/medecin/affichage.php">Medecins <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link <?php if ( (substr($_SERVER['REQUEST_URI'], 1, 7)) == "patient" ) { echo "active";}?>" href="/patient/affichage.php">Patients</a>
        <a class="nav-item nav-link <?php if ( (substr($_SERVER['REQUEST_URI'], 1, 3)) == "rdv" ) { echo "active";}?>" href="/rdv/affichage.php">RDV</a>
        <a class="nav-item nav-link <?php if ( (substr($_SERVER['REQUEST_URI'], 1, 11)) == "patient" ) { echo "statistique";}?>" href="#">Statistiques</a>
      </div>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <form method="POST" action="../home.php">
            <button type="submit" name="deconnexion" class="btn btn-light">se déconnecter</button>
          </form>
        </li>
      </ul>
    </div>
  </nav>
  <?php
  ?>
