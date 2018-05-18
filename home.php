<HTML>
<?php

if ( isset($_POST['nom'])) {
	$cookieName = $_POST['nom'];
	setcookie('cNom', $cookieName, time() + 3600);
	setcookie('cCpt', $cookieCpt, time() + 3600);
}