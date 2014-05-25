<?php

$projet = "";
$examen = "";

if($page == "prof"){
  $examMessage = isset($exam)?"Examen (Modifier)":"Nouvel Examen";  
  $projectMessage = isset($project)?"Projet":"Nouveau Projet";
  $projet = '<a class="bouton" href='.URL.'Professor/CreateExamen&courseID='.strval($currentCourse->courseID()).'>'.$examMessage.'</a>';
  $examen = '<a class="bouton" href='.URL.'Professor/CreateProjet&courseID='.strval($currentCourse->courseID()).'>'.$projectMessage.'</a>';
} elseif($page == "student") {
  if (isset($project)) {
    $projet = '<tr><td>Projet</td> <td><a href="'.URL.'Student/Project/?cours='.strval($currentCourse->courseID()).'">Sujet de projet</a></td></tr>';
  }
  if(isset($exam)){
    $examen = '<tr><td>Examen</td> <td><a href="'.URL.'Student/DoExercice/?type=examen&courseTitle='.$currentCourse->title().'&courseID='.$currentCourse->courseID().'">Feuille d examen</a></td></tr>';
  }
}
echo '<h1 id="'.$currentCourse->title().'">'.$currentCourse->title().'</h1>
          '.$projet.' '.$examen.'
          <a class="bouton" href="#'.($currentCourse->title()).'" onclick=createPart('.$currentCourse->courseID().');>Nouvelle Partie</a>
          <p class="description">'.$currentCourse->description().'</p>';
          foreach ($currentCourse->parts() as $part) {
      echo '<div class="part"><h2 class="part_nom">'.($part->title()).'</h2>
              <a class="bouton" href="'.URL.'Professor/CreateChapter/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'"> Ajouter un chapitre</a>
              <a class="bouton" href="#" onclick="deletePart('.$currentCourse->courseID().','.$part->partID().',\''.$part->title().'\',\''.$currentCourse->title().'\')";>Supprimer la Partie</a>
              <ul class="liste_chapitres">';
             foreach($part->chapters() as $chapter){
          echo '<li><a class="chp" target="blank" href="'.URL.'Professor/AfficherCours/?cours='.strval($currentCourse->courseID()).'&part='.strval($part->partID()).'&chp='.strval($chapter->chapterID()).'">'.$chapter->title().'</a></li>';
              }
        echo "</ul>
            </div>";
          }
          echo '<p class = "pbouton">
                  <a href="'.URL.'Professor/SupprimerCours/?cours='.$currentCourse->courseID().'" class="bouton">Supprimer ce cours</a>
                  <a href='.URL.'Professor/ViewNotes class="bouton">Consulter les notes</a>
                </p>';
?>