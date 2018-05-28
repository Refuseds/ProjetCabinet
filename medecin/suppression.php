<?php include '../secure.php';?>

<html>
    <body>
    <h1> Suppression</h1>
    <form action='supprime.php' method="post">
        <input type="hidden" name="pkmedecin" value="<?php  echo $_GET['id']; ?>"  ><br />
            Voulez vous vraiment supprimer le patient ?
        <input type="submit" name="suppr" value="Supprimer">
    </form>
    <form action='affichage.php' method="post">
        <input type="submit"  value="Retour">
    </form>




    </body>
</html>
