<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <div class="content">
        
        <h1><?php echo $cours->title(); ?></h1>
        <h2><?php echo $part->title(); ?></h2>
        <h3><?php echo $chp->title(); ?></h3>

        <?php  
          print_r($chp);
        ?>

        <div>
          
          <a class="bouton" href="<?php echo URL.''.($chp->courseNotes()->getURL());?>" name="name">Cours</a>
          <a class="bouton" href="<?php echo URL.'Exercice'; ?>" name="name">Exercice</a>
        </div>

      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


