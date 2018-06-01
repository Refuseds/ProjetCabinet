<?php 
    include '../connexionBDD.php';
    //echo 'test reussi valeur = '.$_POST['id_patient'];

    echo '<select class="custom-select mr-sm-2" name="medecin" required>';
    if($_POST['id_patient'] != ''){
        $req_patient_fkmedecin = $linkpdo-> prepare('SELECT fkmedecin FROM patient WHERE pkpatient = :lpkpatient');
        $req_patient_fkmedecin->execute(array('lpkpatient'=> $_POST['id_patient']));
        $res_patient_fkmedecin = $req_patient_fkmedecin->fetch();
        if($res_patient_fkmedecin['fkmedecin']!= '0'){
            $req_medecin = $linkpdo->prepare('SELECT * FROM medecin WHERE pkmedecin = :lpkmedecin');
            $req_medecin -> execute(array('lpkmedecin'=> $res_patient_fkmedecin['fkmedecin']));
            $res_medecin = $req_medecin->fetch();
            echo '<option value="'.$res_medecin['pkmedecin'].'" > '.$res_medecin['nom'].' '.$res_medecin['prenom'].' </option>';

            echo'<!-- injection de la liste de medecin -->';
            $req_tout_medecin = $linkpdo->prepare('SELECT * FROM medecin WHERE pkmedecin <> :lpkmedecin ');
            $req_tout_medecin->execute(array('lpkmedecin' => $res_medecin['pkmedecin']));
            while($m=$req_tout_medecin->fetch()){
            echo '<option value="'.$m['pkmedecin'].'"> '.$m['nom'].' '.$m['prenom'].'</option>';
            }
        }else{
            echoReste();
        }
    }else{
        echoReste();
    }


    echo '</select>';

    function echoReste(){
        include '../connexionBDD.php';

        echo '<option value="" > Veuillez choisir un médecin </option> ';
        echo'<!-- injection de la liste de medecin -->';
        $req_tout_medecin = $linkpdo->prepare('SELECT * FROM medecin');
        $req_tout_medecin->execute();
        while($m=$req_tout_medecin->fetch()){
        echo '<option value="'.$m['pkmedecin'].'"> '.$m['nom'].' '.$m['prenom'].'</option>';
        }
    }
?>