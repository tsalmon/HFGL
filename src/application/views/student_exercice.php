<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      <?php include("_templates/student_sidebar_left.php"); ?>
      <div class="content">
        
        <h1>L'exercice de cours 1</h1>
        <h5>Enseignant: </h5>
          <h4>Date limite: </h4>
          
          <div id="div_scroll">
            <p>
              <script src="application/quiz/quiz.js" type="text/javascript"> </script>
              <div class="lueckentext-quiz">
                    <p>Das<strong>Internet (weltweites Computernetz)</strong> weiß alles.</p>
              </div>


               <?php
               echo 'les questions de chapitre';
               echo '<form action="<?php echo URL; ?>Exercice/Exercice_result" method="POST">';
                //     foreach($questions as $question){
                //         echo $question->getAssignment().'<br/>';
                //         $answers = $question->getAnswers();
                //         foreach($answers as $answer) {
                //             if($question instanceof QCMQuestion)
                //             {
                //                 echo '<input type="checkbox" name=".$question->getID()." value="val">'.$answer->getContent().'<br>';
                //             }
                //             else if($question instanceof QRFQuestion || $question instanceof LQuestion || $question instanceof PQuestion)
                //             {
                //                 echo '<input type="text" name=".$question->getID()." placeholder="Your answer...">';
                //             }
                //             else
                //             {
                //                 throw new Exception("Undefined question type");
                //             }
                //         }
                //         echo '<br/>';
                //     }
                //     echo '<form action="">';
                //     echo '<input id="exerciceanswer" type="submit"/>';
                // echo '<br/>';
                ?>
            </p>
        </div>

        <a href="<?php echo URL; ?>Student/">
          <p style="padding-top: 15px; display: inline">
            <span>&nbsp;</span>
            <input class="bouton"  name="name" value="Traveaux de cours" />
          </p>
        </a>

        <p style="padding-top: 15px; display: inline">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" name="name" value="Enregistrer" />
        </p>

        <p style="padding-top: 15px; display: inline">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" name="name" value="Soumettre" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


