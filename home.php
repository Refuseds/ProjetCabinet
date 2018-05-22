<HTML>
<?php

if ( empty($_POST['id']) || empty($_POST['pw']) ) { 
	setcookie('id', 'login_incomplet', time() + (86400 * 30));
	setcookie('pw', 'login_incomplet', time() + (86400 * 30));
	header('Location: index.php');	
} else {
	
	try {
		$linkpdo = new PDO("mysql:host=localhost;dbname=cabinet", 'root', '');
	} catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
	}
	
// preparation de la requete 
	$req = $linkpdo->prepare("SELECT * FROM login WHERE identifiant = :id and password = :pw ");

//Exécution de la requête avec les paramètres passés sous forme de tableau indexé
	$req->execute(array('id'=>$_POST['id'], 'pw'=>$_POST['pw']) );
	$data = $req->fetch();
	if ($data == false ) {
		setcookie('id', 'login_erreur', time() + (86400 * 30));
		setcookie('pw', 'login_erreur', time() + (86400 * 30));
		header('Location: index.php');
	} else {
	setcookie('id', $_POST['id'], time() + (86400 * 30));
	setcookie('pw', $_POST['pw'], time() + (86400 * 30));
	}
}
?>

