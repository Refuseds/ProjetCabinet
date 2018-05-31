<?php
session_start();
?>
<HTML>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<script src="/bootstrap/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/login.css">
	<body class="text-center">
    <form class="form-signin" method="POST" action="home.php">
      <img class="mb-4" src="/img/logo.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Veuillez vous identifier</h1>
			<br>
      <input type="text" name="id" class="form-control" placeholder="identifiant" required autofocus>
      <input type="password" name="pw" class="form-control" placeholder="mot de passe" required>
			<input type="hidden" value="true" name="tentative" />
      <button class="btn btn-lg btn-primary btn-block" name="envoyer" type="submit">Connexion</button>
    </form>
		<div class="alerte">
			<?php
			if( isset($_SESSION['login']) ) {
				if ( $_SESSION['login'] == 'ok' ) {
					header('Location: home.php');
				}
				if ( $_SESSION['login'] == 'incomplet' ) {
					echo '<div class="alert alert-danger" role="alert">
		  						Une erreur est survenue : les identifiants sont incomplets !
								</div>';
				}
				if ( $_SESSION['login'] == 'incorrect') {
					echo '<div class="alert alert-danger" role="alert">
		  						identifiant et/ou mot de passe incorrecte !
								</div>';
				}
			}
			?>
		</div>
  </body>
	<footer>
		<a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Licence Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br />Cette œuvre est mise à disposition selon les termes de la <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/">Licence Creative Commons Attribution</a>.
	</footer>
</HTML>
