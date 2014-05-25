<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <?php include("_templates/sidebar_left.php"); ?>

      <div class="content">

        <?php 

        if ($currentCourse){
          include("_templates/current_course.php");
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
