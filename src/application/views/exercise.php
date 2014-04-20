<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">
      
      <?php include("_templates/student_sidebar_left.php"); ?>

      <div class="content">
        
        <h5>Enseignant: echo nom d'enseignant</h5>
        <div id="div_scroll">
        	<h1>Notes de Cours 1</h1>
            <p>
              echo Les Notes de cours
            </p>
            <hr>
            <h1>L'exercice de cours 1</h1>
            <p>
                <?php
                    foreach($questions as $question){
                        echo $question->getAssignment().'<br/>';
                        $answers = $question->getAnswers();
                        foreach($answers as $answer) {
                            if($question instanceof QCMQuestion)
                            {
                                echo '<input type="checkbox" name="checkboxanswer" value="val">'.$answer->getContent().'<br>';
                            }
                            else if($question instanceof QRFQuestion || $question instanceof LQuestion || $question instanceof PQuestion)
                            {
                                echo '<input type="text" name="textanswer" placeholder="Your answer...">';
                            }
                            else
                            {
                                throw new Exception("Undefined question type");
                            }
                        }
                        echo '<br/>';
                    }
                    echo '<form action="">';
                    echo '<input id="inscription" type="submit"/>';
                echo '<br/>';
                ?>
            </p>
        </div>

        <a href="Student">
          <p style="padding-top: 15px; display: inline">
            <span>&nbsp;</span>
            <input class="bouton"  name="name" value="Traveaux de cours" />
          </p>
        </a>

        <p style="padding-top: 15px; display: inline">
          <span>&nbsp;</span>
          <input class="bouton" type="submit" name="name" value="Enregistrer" />
        </p>
          
      </div>
    </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


