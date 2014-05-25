<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>
      <?php include("_templates/sidebar_left.php"); ?>

      <div class="content">

        <?php 
        $examMessage = isset($exam)?"Examen (Modifier)":"Nouvel Examen";
        $projectMessage = isset($project)?"Examen":"Nouveau Projet";

        if ($currentCourse){
          echo '<h1 id="'.$currentCourse->title().'">'.$currentCourse->title().'</h1>';
          echo '<a class="bouton" href='.URL.'Professor/CreateProjet&courseID='.strval($currentCourse->courseID()).'>'.$examMessage.'</a>';
          echo '<a class="bouton" href='.URL.'Professor/CreateProjet&courseID='.strval($currentCourse->courseID()).'>'.$projectMessage.'</a>';
          echo '<a class="bouton" href="#'.($currentCourse->title()).'" onclick=createPart('.$currentCourse->courseID().');>Nouvelle Partie</a>';
          echo '<p class="description">'.$currentCourse->description().'</p>';
          foreach ($currentCourse->parts() as $part) {
            echo '<div class="part"><h2 class="part_nom">'.($part->title()).'</h2>
                  <a class="bouton" href="'.URL.'Professor/CreateChapter/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'"> Ajouter un chapitre</a>
                  <a class="bouton" href="#" onclick="deletePart('.$currentCourse->courseID().','.$part->partID().',\''.$part->title().'\',\''.$currentCourse->title().'\')";>Supprimer la Partie</a>
                  <ul class="liste_chapitres">';
            foreach($part->chapters() as $chapter){
              echo '<li><a class="chp" target="blank" href="'.URL.'Professor/AfficherCours/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a></li>';
            }
            echo "</ul></div>";
          }
          echo '<p class = "pbouton">
                  <a href="'.URL.'Professor/SupprimerCours/?cours='.$currentCourse->courseID().'" class="bouton">Supprimer ce cours</a>
                  <a href='.URL.'Professor/ViewNotes class="bouton">Consulter les notes</a>
                </p>
            ';
        } else {
            $this->printQuestionsToCorrect($prof);
            $this->printQuestionsToValidate($prof);
        }
        ?>
      </div>
    <div class="clearfooter"></div>
      
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>
