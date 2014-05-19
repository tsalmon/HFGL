
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="form_settings">


        <form name="chpform" method="post" 
              action="<?php echo URL.'Professor/CreateChapter_ok?cours='.$_GET["cours"].'&part='.$_GET["part"]; ?>" 
              onsubmit="return chpValid();"
              enctype="multipart/form-data">
        <fieldset>
          <legend> 
            <?php
            $create = 1;
            if($page == "CreateChapter"){
              echo '<h1>Création de chapitre</h3>';
            } else {
              $create = 0;
              echo '<h1>Modifier un chapitre</h3>';
            }
            ?>
          </legend>
          <p>Pour le cours "<?php echo $cours->title(); ?>" - partie "<?php echo $part->title();  ?>"</p>

          <p>
            <p><span>Nom du chapitre</span>
              <input type="text" name="chp_name" placeholder="Chapitre..." value="<?php if(!$create){ echo $chp->title(); }?>" required/>
            </p>

            <p><span>Description du chapitre</span>
              <textarea name="chp_descr" placeholder="Description"></textarea>
            </p>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
            <p>
              <span><label for="upload">Leçon :</label></span>
              <input type="file" id="upload" name="chp_file_lesson"/>
            </p>
          </p>
        <p class="date">
          <span><label>A faire a partir du : </label></span>
          <select name="avalable_year" onchange="year(0);"></select>
          <select name="avalable_month" onchange="month(0);"></select>    
          <select name="avalable_day"></select>          
        </p>

        <p class="date">
          <span><label>Jusqu'au : </label></span>
          <select name="deadline_year" onchange="year(1);"></select>
          <select name="deadline_month" onchange="month(1);"></select>    
          <select name="deadline_day"></select>          
        </p>

           <p>
            <input type="submit"/>
          </p>
        </fieldset>
        </form>
      </div>
    <div class="clearfooter"></div>
      
    </div>
    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

<script src="<?php echo URL.'public/js/ChapterForm.js' ?>"></script>
