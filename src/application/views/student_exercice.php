<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
<<<<<<< HEAD
      <?php include("_templates/bienvenue_title.php"); ?>
=======
      <div id="welcome"><h3>Bienvenue</h3></div>
>>>>>>> f5b7b21adece7fa7f25cc0ecbd4b320f90ec6848

      <div class="content_big">
        
        <?php 
          print_r($_GET);
        ?>

        <h1>L'exercice de cours 1</h1>
        <h5>Enseignant: </h5>
          <h4>Date limite: </h4>
          
          <div id="div_scroll">
            <p>
               <?php
               if (!$this->started) {
                 echo "Vous allez faire l'exercice de ".$this->questionsCount." questions. Est-ce que vous êtes prêt?<br/>";
                 echo '<form action="startExercice" method="POST">';
                 echo '<input id="startexercice" value="Je commence!" type="submit"/>';
               } else 
               if ($this->finished){
                 echo "Vous avez fini cette exercice! Merci.";
               } else {
                 echo "Question ".($this->currentQuestionNumber+1)." sur ".$this->questionsCount."<br/>";
                 echo $currentQuestion->getAssignment().'<br/>';
                 if ($currentQuestion instanceof QCMQuestion) {
                     $answers = $currentQuestion->getAnswers();
                     echo '<form action="QCMExerciceResponse" method="POST">';
                     foreach($answers as $answer) {
                        echo '<input type="checkbox" name='.$currentQuestion->getID().' value='.$answer->isCorrect().'>'.$answer->getContent().'<br>';
                     }   
                 }

                 if ($currentQuestion instanceof QRFQuestion) {
                    echo '<form action="QRFExerciceResponse" method="POST">';
                    echo '<textarea name="'.$currentQuestion->getID().'" cols="25" rows="3" placeholder="Enter your answer here..." autofocus required></textarea><br>';
                 } 

                 if ($currentQuestion instanceof PQuestion) {
                    echo '<form enctype="multipart/form-data" action="PExerciceResponse" method="POST">';
                    echo '<input type="hidden" name="questionID" value='.$currentQuestion->getID().'>';
                    echo 'Le nom de fichier à charger doit être: '.$filename.'<br>';
                    echo '<input type="file" name='.$currentQuestion->getID().' id="file" enctype="multipart/form-data"> <br>';
                 }

                 if ($currentQuestion instanceof LQuestion) {
                     echo '<form action="LExerciceResponse" method="POST">';
                     echo '<textarea name="'.$currentQuestion->getID().'" cols="25" rows="5" placeholder="Enter your answer here..." autofocus required></textarea><br>';
                 }
                 echo '<input type="hidden" id="currentQuestionNumber" name="currentQuestionNumber" value="'.$this->currentQuestionNumber.'" />';
                 echo '<input type="hidden" id="questionsCount" name="questionsCount" value="'.$this->questionsCount.'" />';
                 echo '<input id="exerciceanswer" type="submit"/>';
                 echo '</form>';
               }
              ?>
            </p>
        </div>

        <a href="<?php echo URL; ?>Student/">
          <p class = "pbouton">
            <span>&nbsp;</span>
            <input class="bouton"   value="Traveaux de cours" />
          </p>
        </a>

        <p class = "pbouton">
          <span>&nbsp;</span>
          <input class="bouton" type="submit"  value="Enregistrer" />
        </p>

        <p class = "pbouton">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" value="Soumettre" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
