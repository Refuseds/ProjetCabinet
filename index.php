<?php 
session_start();
?>
<HTML>
<a> Veuillez vous identifier </a>
<form method="POST" action="home.php">
	<p> identifiant :
		<input type="text" name="id">
		mot de passe :
		<input type="text" name="pw">
		<input type="submit" name="envoyer" value="se connecter">
		<input type="hidden" value="true" name="tentative" />
	</p>
</form>
<br>

<?php

// test l'état de la session pour modifier l'affichage et si deja connecté rediriger vers home.php
if( isset($_SESSION['login']) ) {
	if ( $_SESSION['login'] == 'ok' ) {
		header('Location: home.php');
	}
	if ( $_SESSION['login'] == 'incomplet' ) {
		echo "<a> Identification invalide ( apparait si aucun champs n'a été renseigné )  </a> ";
	}
	if ( $_SESSION['login'] == 'incorrect') {
		echo "<a> Le nom d'utilisateur ou le mot de passe est invalide ( apparait qd login incorrect ) </a>";
	}
}

?>


</HTML>