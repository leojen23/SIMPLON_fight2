<?php
  
  // On enregistre notre autoload.
  //  function chargerClasse($classname) {
  //   require $classname.'.php';
  // }

  // spl_autoload_register('chargerClasse');


  // On fait appel à la classe Personnage
  require 'class/Personnage.php';
  // On fait appel à la classe PersonnagesManager
  require 'class/PersonnagesManager.php';

  session_start(); // On appelle session_start() 

  if (isset($_GET['deconnexion'])) {
    session_destroy();
    header('Location: .');
    exit();
  }

  // On fait appel à la connexion à la bdd
  require 'config/init.php';

  // On fait appel à le code métier
  require 'combat.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>🥋Vs🥋 Fight ! </title>
    
    <meta charset="utf-8" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link rel="stylesheet" href="/CSS/style.css">
  </head>
  <body>
    <p>Nombre de personnages créés : <?= $manager->count() ?></p>
<?php
  // On a un message à afficher ?
  if (isset($message)) {
    echo '<b>', $message, '</b>'; // Si oui, on l'affiche.
  }
  // Si on utilise un personnage (nouveau ou pas).
  if (isset($perso)) {
?>
    <p><a href="?deconnexion=1">Déconnexion</a></p>
    
    <fieldset>
      <legend>Mes informations</legend>
      <p>
        Nom : <?= htmlspecialchars($perso->nom()) ?><br />
        Dégâts : <?= $perso->degats() ?><br />
        niveau : <?= $perso->niveau() ?><br />
        experience : <?= $perso->experience() ?><br />
        force : <?= $perso->strength() ?><br />
      </p>
    </fieldset>
    
    <fieldset>
      <legend>Qui frapper ?</legend>
      <div class="list-persos">
        <?php
          $persos = $manager->getList($perso->nom());
          if (empty($persos)) {
            echo 'Personne à frapper !';
          } 
          else {?>

            <?php foreach ($persos as $unPerso):?>
              <div class="card" style="width: 18rem;">
                 
                  <div class="card-body text-center">
                    <h5 class="card-title"><?=htmlspecialchars($unPerso->nom())?></h5>
                    <p class="card-text">
                        <li>Degats: <?=$unPerso->degats()?></li>
                        <li>Niveau: <?=$unPerso->niveau()?></li>
                        <li>Experience: <?=$unPerso->experience()?></li>
                        <li>Force: <?=$unPerso->strength()?></li>
                    </p>
                    <a href="?frapper=<?=$unPerso->id()?>" class="btn btn-primary">FRAPPER</a>
                  </div>
              </div>
            <?php endforeach;?>
              
           <?php } ?>
      </div>
    </fieldset>
<?php
}
// Sinon on affiche le formulaire de création de personnage
else {
?>
<div class="row">
  <div class="col-12">

  <form action="" method="post">
    <div class="col-4">
      <div class="form-group">
        <label for="nom">Nom</label>
          <input type="text" name="nom" maxlength="50" id="nom" class="form-control" />
      </div>
    </div>


    <div class="col-4">
      <div class="form-group">
          <select class="form-control" id="exampleFormControlSelect1" name="type">
            <option ></option>
            <option value="guerrier">Guerrier</option>
            <option value="magicien">Magicien</option>
            <option value="archer">Archer</option>
          </select>
        </div>
    </div>

      <input  class=  "btn btn-outline-secondary" type="submit" value="Créer ce personnage" name="creer" />
      <input class=  "btn btn-outline-secondary" type="submit" value="Utiliser ce personnage" name="utiliser" />
    </p>
  </form>

<?php } ?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>
<?php
  // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
  if (isset($perso)) {
    $_SESSION['perso'] = $perso;
  }
