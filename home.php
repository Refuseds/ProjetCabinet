<?php
session_start();


	if ( $_SESSION['login'] != 'ok' ) {
		if ( (empty($_POST['id']) || empty($_POST['pw']) ) ) { 
		$_SESSION["login"] = 'incomplet';
		header('Location: index.php');	
		} else {
		
		// connexion à la BDD
		try {
			$linkpdo = new PDO("mysql:host=localhost;dbname=cabinet", 'root', '');
		} catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
		}
		
		// preparation de la requete 
		$req = $linkpdo->prepare("SELECT password FROM login WHERE identifiant = :id");

		//Exécution de la requête avec les paramètres passés sous forme de tableau indexé
		$req->execute(array('id'=>$_POST['id'] ));
		$data = $req->fetch();
		// si requete fausse redirection sinon creation de session correcte
		var_dump($data);
		if ($data == false ) {
			$_SESSION["login"] = 'incorrect';
			header('Location: index.php');
		} else {
			if ( password_verify($_POST['pw'], $data[0]) ) {
				$_SESSION["login"] = 'ok';
			} else {
				header('Location: index.php');
			}
			
		}
		}	
	}
// si l'utilisateur à cliqué sur deconnexion on detruit la session et renvoi sur la page de connexion
if ( isset($_POST['deconnexion']) ) {
	session_destroy();
	header('Location: index.php');
}
$options = [
    'cost' => 12,
];

// fonction pour crypter les mot de passe
// $hash = password_hash("admin", PASSWORD_BCRYPT, $options);
?>
<HTML>
<form method="POST" action="home.php">
		<input type="submit" name="deconnexion" value="se deconnecter">
	</p>
</form>



