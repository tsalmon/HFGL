<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <?php include("_templates/bienvenue_title.php"); ?>

      <div class="content_big">

        <h1>L'exercice de cours: <?php echo $_SESSION["cours"]; ?></h1>
        <h1>Part: <?php echo $_SESSION["part"]; ?></h1>
        <h1>Chapitre: <?php echo $_SESSION["chptname"]; ?></h1>
        <h3>Enseignant: </h5>
        <h3>Date limite: </h4>
          
          <div id="div_scroll">
            <p>
               <?php
               if (!$_SESSION["started"]) {
                 echo "Vous allez faire l'exercice de ".$_SESSION["questionsCount"]." questions. Est-ce que vous êtes prêt?<br/>";
                 echo '<form action="StartExercice" method="POST">';
                 echo '<input id="startexercice" value="Je commence!" type="submit"/>';
               } else 
               if ($_SESSION["finished"]){
                 echo "Vous avez fini cette exercice! Merci.";
               } else {
                 echo "Question ".($_SESSION["currentQuestionNumber"]+1)." sur ".$_SESSION["questionsCount"]."<br/>";
                 echo $currentQuestion->getAssignment().'<br/>';
                 if ($currentQuestion instanceof QCMQuestion) {
                     $answers = $currentQuestion->getAnswers();
                     echo '<form action="QCMExerciceResponse?questionID='.$currentQuestion->getID().'" method="POST">';
                     foreach($answers as $answer) {
                        echo '<input type="checkbox" name='.$currentQuestion->getID().' value='.$answer->isCorrect().'>'.$answer->getContent().'<br>';
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
    <div class="clearfooter"></div>
      
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>
