<html>
    <body>


    <?php
     $server = 'localhost';
     $login = 'root';
     $mdp = 'root';
     try {
         $linkpdo = new PDO("mysql:host=$server;dbname=cabinet", $login, $mdp); }
     catch (Exception $e) {
         die('Erreur : ' . $e->getMessage());
     };
     $reqrdv = $linkpdo->prepare('  SELECT   FROM patient WHERE ');
     $reqrdv->execute();  
    ?>
        <header>
            <?php include('../menu.php')?>
        </header>
        <h1> Page en cours de construction </h1>

        <table>
            <thead>
                <tr>
                    <th>Tanche d'âge</th>
                    <th>Nb Hommes</th>
                    <th>Nb Femmes</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Moins de 25 ans</th>
                    <td>9s</td>
                    <td>10s</td>
                </tr>
                <tr>
                    <th>Entre 25 et 50 ans</th>
                    <td>40s</td>
                    <td>41s</td>
                </tr>
                <tr>
                    <th>Plus de 50 ans</th>
                    <td>40s</td>
                    <td>41s</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>