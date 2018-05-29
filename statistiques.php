<html>
    <body>

 <?php
     $linkpdo = connexionBD();
     /****** */
     $reqHomme = $linkpdo->prepare("  SELECT  DATE_FORMAT(datenaissance, '%d/%m/%Y') AS datenaissance  FROM patient WHERE civilite = 1 ");
     $reqHomme->execute(); 
     $Hm25 =0; 
     $He25e50=0;
     $Hp50 = 0;
     while($d = $reqHomme->fetch()){
        if( age($d['datenaissance']) < 25){
            $Hm25 +=1;
        }elseif(age($d['datenaissance'])>=25 && age($d['datenaissance'])<=50){
            $He25e50+=1;
        }else{
            $Hp50 +=1;
        }
     }
    /******* */
    $reqFemme = $linkpdo->prepare("  SELECT  DATE_FORMAT(datenaissance, '%d/%m/%Y') AS datenaissance  FROM patient WHERE civilite = 0 ");
    $reqFemme->execute(); 
    $Fm25 =0; 
    $Fe25e50=0;
    $Fp50 = 0;
    while($d = $reqFemme->fetch()){
    if( age($d['datenaissance']) < 25){
        $Fm25 +=1;
    }elseif(age($d['datenaissance'])>=25 && age($d['datenaissance'])<=50){
        $Fe25e50+=1;
    }else{
        $Fp50 +=1;
    }
    }
    /********* */
     function age($date){
         return (int)((time()-strtotime($date))/3600/24/365 );
     }

     function connexionBD(){
        $server = 'localhost';
        $login = 'root';
        $mdp = 'root';
        try {
            return new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); 
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
     }


     /* 
    AVEC LES REQUETE SQL
     echo 'm2';
     $reqrdv = $linkpdo->prepare("  SELECT   DATEDIFF( CURRENT_DATE,datenaissance) AS age  FROM patient WHERE nom = 'ROMERO' ");
     //$reqrdv = $linkpdo->prepare("  SELECT   CURRENT_TIMESTAMP as age ");
     $reqrdv->execute();  

     while($d = $reqrdv->fetch()){
        echo $d['age'] .'<br>';

    }*/


    
    ?>
    
        <header>
            <?php include('menu.php')?>
        </header>
        <div class="container">
            <br>
            <h2>Statistiques</h2>
            <br>
            <h3>Répartitions des usagers</h3>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tranche d'âge</th>
                        <th>Nb Hommes</th>
                        <th>Nb Femmes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Moins de 25 ans</th>
                        <td><?php echo $Hm25;?></td>
                        <td><?php echo $Fm25;?></td>
                    </tr>
                    <tr>
                        <th>Entre 25 et 50 ans</th>
                        <td><?php echo $He25e50;?></td>
                        <td><?php echo $Fe25e50;?></td>
                    </tr>
                    <tr>
                        <th>Plus de 50 ans</th>
                        <td><?php echo $Hp50;?></td>
                        <td><?php echo $Fp50;?></td>
                    </tr>
                </tbody>
            </table>
            <br>
            <h3>Nombre d'heures des consulations des médecins</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Médecin</th>
                        <th>Nombre d'heures</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $reqMedecin = $linkpdo->prepare("SELECT pkmedecin, nom,prenom FROM medecin");
                        $reqMedecin->execute();
                        while($m = $reqMedecin->fetch()){
                            $reqHrdv = $linkpdo->prepare("  SELECT  sum(DATE_FORMAT(duree, '%H')) AS heure,
                                                                    sum(DATE_FORMAT(duree, '%i')) AS min
                                                            FROM rdv 
                                                            WHERE fkmedecin =".$m['pkmedecin']);
                            $reqHrdv->execute(); 
                            while($d=$reqHrdv->fetch()){
                                if($d['heure'] != ''){
                                    echo '<tr>'.
                                            '<td>'.$m['nom'].' '.$m['prenom'].'</td>'.
                                            '<td>'.$d['heure'].'h'.$d['min'].'</td>'.
                                        '</tr>';
                                }
                            }   
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
</html>

