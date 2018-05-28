<?php
session_start();

// si aucune session existante, la créer
if (!isset($_SESSION['login'])) {
	$_SESSION['login']='vide';
	header('Location: /index.php');
} else {
	// si l'utilisateur n'est pas déjà correctement identifié
	if ($_SESSION['login'] != 'ok') {
		// si un des champs d'identification est vide
		header('Location: /index.php');
	}
}
?>
