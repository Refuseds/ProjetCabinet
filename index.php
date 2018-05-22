<HTML>
<a> Veuillez vous identifier </a>
<form method="POST" action="home.php">
	<p> identifiant :
		<input type="text" name="id">
		mot de passe :
		<input type="text" name="pw">
	<input type="submit" name="envoyer" value="se connecter">
	</p>
</form>
<br>
<?php
	if( isset($_COOKIE['id']) ) {
		if ( $_COOKIE['id'] == 'login_incomplet' || $_COOKIE['pw'] == 'login_incomplet' ) {
			echo "<a> Identification invalide ( apparait si aucun champs n'a été renseigné )  </a> ";
		}
		if ( $_COOKIE['id'] == 'login_erreur' ||  $_COOKIE['pw'] == 'login_erreur' ) {
			echo "<a> Le nom d'utilisateur ou le mot de passe est invalide ( apparait qd login incorrect </a>";
		}
	}
	var_dump($_COOKIE['id']);
?>


</HTML>