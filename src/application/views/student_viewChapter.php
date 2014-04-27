<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <div class="content">
        
        <h1><?php echo $chp->title(); ?></h1>
        <h3><?php echo $cours->title()." - ".$part->title(); ?></h3>

        <h2>Description</h2>
        <p>
          <?php
            //Controller::print_dbg($chp);
          ?>
        </p>

        <div>
          <a class="bouton" href="<?php echo URL.''.($chp->courseNotes()->getURL());?>" name="name">Cours</a>
          <a class="bouton" href=" <?php echo URL.'Exercice/'.($chp->exercices()->getID()); ?>" name="name">Exercice</a>
        </div>

      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
<?php
/*
Chapter Object ( 
  [chapterID:protected] => 1 
  [chapterNumber:protected] => 1 
  [exercices:protected] => ExerciceSheet Object ( 
    [deadline:ExerciceSheet:private] => 
    [available:ExerciceSheet:private] => 
    [questionnaireID:ExerciceSheet:private] => 
    [questionnaireType:ExerciceSheet:private] => 
    [questions:ExerciceSheet:private] => 
    [db:ExerciceSheet:private] => PDO Object ( ) 
  ) 
  [title:protected] => Introduction to C++ 
  [courseNotes:protected] => CourseNote Object ( 
    [URL:CourseNote:private] => 
  ) 
  [db:protected] => PDO Object ( ) 
)
*/
?>