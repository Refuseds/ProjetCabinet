<?php
    include '../connexionBDD.php';

 

$finNouveauRDV = calculFinRDV($_POST['heure'],$_POST['duree']);


//selection de tous les rdv avec medecin et date donné
$req = $linkpdo-> prepare('SELECT pkrdv,DATE_FORMAT(heure, "%h:%i") as heure,duree  FROM rdv 
                                            WHERE fkmedecin = :lfkmedecin
                                            AND date = :ldate');
$req->execute(array('lfkmedecin' => $_POST['medecin'], 'ldate' => $_POST['date'] ));

$verification = 1000;
//pour chaque rdv
while($res = $req-> fetch()){
    $finRDVBase =calculFinRDV($res['duree'],$res['heure']);
    $verification += ctrl($res['heure'],$finRDVBase,$_POST['heure'],$finNouveauRDV,$res['pkrdv']);
}

if($verification == 0  ){
    echo 'ok';
}else{
    echo ' non';
}



function ctrl($oldHeureDebut, $oldHeureFin, $newHeureDebut, $newHeureFin, $pkrdv){
        if($newHeureDebut < $oldHeureFin && $newHeureDebut >$oldHeureDebut){
            echo "Attention : une consultation est deja en cours à ".$oldHeureDebut." et ce termine à ".$oldHeureFin."<br>";
            return 1;
        }elseif($newHeureFin > $oldHeureDebut && $newHeureFin < $oldHeureFin){
            echo "Attention : une consultation commence à ".$oldHeureDebut." et ce termine à ".$oldHeureFin."<br>";
            return 1;
        }else{
            return 0;
        }
}


function calculFinRDV($debut,$duree){
    $today = strtotime("TODAY");
    $time1 = strtotime($debut) - $today;
    $time2 = strtotime($duree) - $today;
    $total = $time1 + $time2 + $today;
    return date('h:i',$total);
}

?>