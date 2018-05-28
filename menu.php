<head>
    <link rel="stylesheet" type="text/css" href="/css/header.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>


</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Cabinet Medical</a>
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
  </div>
</nav>
<?php
 ?>
