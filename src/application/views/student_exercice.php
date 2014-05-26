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
          
          <div id="question">
               <?php
               if (!$_SESSION["started"]) {
                if ($attemptsCount == 0) {
                  echo "Vous avez épuisé votre limite des tentatives.<br/>";
                } else {
                  $count = $attemptsCount == -1?3:$attemptsCount;
                  echo '<p class="assignment">Vous allez faire l\'exercice de '.$_SESSION["questionsCount"].' questions. Vous avez encore '.$count.' tentatives. Est-ce que vous êtes prêt?</p><br/>';
                  echo '<form action="StartExercice" method="POST">';
                  echo '<p style="margin-left:30px"><input id="startexercice" class="bouton" value="Je commence!" type="submit"/></p>';
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
                    echo '<p align="center"><textarea class="answer" name="'.$currentQuestion->getID().'" cols="25" rows="3" placeholder="Enter your answer here..." autofocus required></textarea></p><br>';
                 } 

                 if ($currentQuestion instanceof PQuestion) {
                    echo '<form enctype="multipart/form-data" action="PExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                    echo '<input type="hidden" name="questionID" value='.$currentQuestion->getID().'>';
                    echo '<p align="center">Le nom de fichier à charger doit être: '.$filename.'</p>';
                    echo '<p align="center"><input type="file" name='.$currentQuestion->getID().' id="file" enctype="multipart/form-data"></p> <br>';
                 }

                 if ($currentQuestion instanceof LQuestion) {
                     echo '<form action="LExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                     echo '<p align="center"><textarea class="answer" name="'.$currentQuestion->getID().'" cols="25" rows="5" placeholder="Enter your answer here..." autofocus required></textarea></p><br>';
                 }
                 echo '<input type="hidden" id="currentQuestionNumber" name="currentQuestionNumber" value="'.$_SESSION["currentQuestionNumber"].'" />';
                 echo '<input type="hidden" id="questionsCount" name="questionsCount" value="'.$_SESSION["questionsCount"].'" />';
                 echo '<input id="exerciceanswer" class="bouton" type="submit"/>';
                 echo '</form>';
               }
              ?>
          </div>
      <?php
       if ($_SESSION["finished"]  ) {
        echo '<p class = "pbouton">
          <span>&nbsp;</span>
          <a class="bouton" href=""'.URL.'Student/ExerciceSave"; ?>">Enregistrer</a>
        </p>

        <p class = "pbouton">
          <span>&nbsp;</span>
          <a class="bouton" href="'.URL.'Student/ExerciceOk">Soumettre</a>
        </p>';
      } elseif($attemptsCount == 0){
        echo '<p class = "pbouton">
          <span>&nbsp;</span>
          <a class="bouton" href=""'.URL.'Student">Retourner a la liste des cours</a>
        </p>';

      }
      ?>          
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
