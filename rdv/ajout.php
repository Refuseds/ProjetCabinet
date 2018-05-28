<?php include '../secure.php';?>
<?php
    $server = 'localhost';
    $login = 'root';
    $mdp = 'root';
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    };
    $reqpatient = $linkpdo->prepare('SELECT * FROM patient ');
    $reqpatient->execute();
    $reqmedecin = $linkpdo->prepare('SELECT * FROM medecin ');
    $reqmedecin->execute();
?>
<form action="ajout.php" method="post">

    <table>
        <caption>Ajout d'un RDV</caption>
        <tbody>
            <td> Date : </td>
            <td> <input type="text" name="date"></td>
        </tbody>
        <tbody>
            <td>    Heure : </td>
            <td> <input type="text" name="heure" ></td>
        </tbody>

        <tbody>
            <td>    Durée : </td>
            <td> <input type="text" name="duree"></td>
        </tbody>
        <tbody>
            <td>     Patient : </td>
            <td>
                <input list="patient" type="text" name="patient" >
                <datalist id="patient">
                    <?php
                    while($p=$reqpatient->fetch()){
                        echo '<option value="'.$p['pkpatient'].' '.$p['nom'].' '.$p['prenom'].'">';
                    }?>
                </datalist>
            </td>
        </tbody>
        <tbody>
            <td>    Medecin : </td>
            <td>
                <input list="medecin" type="text" name="medecin" >
                <datalist id="medecin">
                    <?php
                    while($m=$reqmedecin->fetch()){
                        echo '<option value="'.$m['pkmedecin'].' '.$m['nom'].' '.$m['prenom'].'">';
                    }?>
                </datalist>
            </td>
        </tbody>
    </table>
    <input type="submit" value="Valider" name="valid">
</form>

<?php
    if( isset($_POST['valid'])){
        echo strtok($_POST['patient']," ");


        $server = 'localhost';
        $login = 'root';
        $mdp = 'root';
        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp);
        }
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        };
        $req = $linkpdo->prepare('INSERT INTO rdv (
                                        date,
                                        heure,
                                        duree,
                                        fkpatient,
                                        fkmedecin
                                      )
                                VALUES(
                                    :ldate,
                                    :lheure,
                                    :lduree,
                                    :lfkpatient,
                                    :lfkpatient
                                  )
                            ');
        $req->execute(array(
                            'ldate' => $_POST['date'],
                            'lheure' => $_POST['heure'],
                            'lduree' => $_POST['duree'],
                            'lfkpatient' => strtok($_POST['patient']," "),
                            'lfkpatient' => strtok($_POST['medecin']," ")
        ));

    }

?>
