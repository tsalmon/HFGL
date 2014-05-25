<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>

      <div class="content_big">
        <?php
          if ($_SESSION["type"] == "chapter") {
            echo '<h1>Exercice de cours: '.$_SESSION["coursTitle"].'</h1>';
            echo '<h1>Part: '.$_SESSION["partTitle"].'</h1>';
            echo '<h1>Chapitre: '.$_SESSION["chapterTitle"].'</h1>';
          } else 
          if ($_SESSION["type"] == "examen") {
            echo '<h1>Examen de cours: '.$_SESSION["coursTitle"].'</h1>';
          }
        ?>
       
        <h3>Enseignant: </h5>
        <h3>Date limite: </h4>
          
          <div id="div_scroll">
               <?php
               if (!$_SESSION["started"]) {
                if ($attemptsCount == 0) {
                  echo "Vous avez épuisé votre limite des tentatives.<br/>";
                  echo '<form action="'.URL.'Student">
                          <input type="submit" value="Retourner">
                        </form>';
                } else {
                  $count = $attemptsCount == -1?3:$attemptsCount;
                  echo '<p class="assignment">Vous allez faire l\'exercice de '.$_SESSION["questionsCount"].' questions. Vous avez encore '.$count.' tentatives. Est-ce que vous êtes prêt?</p><br/>';
                  echo '<form action="StartExercice" method="POST">';
                  echo '<p style="margin-left:400px"><input id="startexercice" class="bouton" value="Je commence!" type="submit"/></p>';
                  echo '</form>';
                }

               } else 
               if ($_SESSION["finished"]){
                 echo "Vous avez fini cette exercice! Merci.";
               } else {
                 echo '<p class="assignment">Question '.($_SESSION["currentQuestionNumber"]+1).' sur '.$_SESSION["questionsCount"].'</p><br/>';
                 echo '<p class="assignment">'.$currentQuestion->getAssignment().'</p><br/>';
                 if ($currentQuestion instanceof QCMQuestion) {
                     $answers = $currentQuestion->getAnswers();
                     echo '<form action="QCMExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                     foreach($answers as $answer) {
                        echo '<p><input class="answer" type="checkbox" name='.$currentQuestion->getID().' value='.$answer->isCorrect().'>'.$answer->getContent().'</p><br>';
                     }   
                 }

                 if ($currentQuestion instanceof QRFQuestion) {
                    echo '<form action="QRFExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                    echo '<textarea name="'.$currentQuestion->getID().'" cols="25" rows="3" placeholder="Enter your answer here..." autofocus required></textarea><br>';
                 } 

                 if ($currentQuestion instanceof PQuestion) {
                    echo '<form enctype="multipart/form-data" action="PExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                    echo '<input type="hidden" name="questionID" value='.$currentQuestion->getID().'>';
                    echo 'Le nom de fichier à charger doit être: '.$filename.'<br>';
                    echo '<input type="file" name='.$currentQuestion->getID().' id="file" enctype="multipart/form-data"> <br>';
                 }

                 if ($currentQuestion instanceof LQuestion) {
                     echo '<form action="LExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                     echo '<textarea name="'.$currentQuestion->getID().'" cols="25" rows="5" placeholder="Enter your answer here..." autofocus required></textarea><br>';
                 }
                 echo '<input type="hidden" id="currentQuestionNumber" name="currentQuestionNumber" value="'.$_SESSION["currentQuestionNumber"].'" />';
                 echo '<input type="hidden" id="questionsCount" name="questionsCount" value="'.$_SESSION["questionsCount"].'" />';
                 echo '<input style="margin-left:250px" id="exerciceanswer" class="bouton" type="submit"/>';
                 echo '</form>';
               }
              ?>

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
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
