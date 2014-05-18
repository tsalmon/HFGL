
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="content_big">
        <?php
        $create = 1;
        if($page == "CreateChapter"){
          echo '<h3>Création de chapitre</h3>';
        } else {
          $create = 0;
          echo '<h3>Modifier un chapitre</h3>';
        }
        ?>
        <p>Pour le cours "<?php echo $cours->title(); ?>" - partie "<?php echo $part->title();  ?>"</p>
        <?php
          //Controller::print_dbg($chp);
        ?>
        <form name="chpform" method="post" 
              action="<?php echo URL.'Professor/CreateChapter_ok?cours='.$_GET["cours"].'&part='.$_GET["part"]; ?>" 
              onsubmit="return chpValid();"
              enctype="multipart/form-data">
          <p>
          <input type="text" name="chp_name" placeholder="nom du chapitre" value="<?php if(!$create){ echo $chp->title(); }?>" required/>
          <div>
            <textarea name="chp_descr" placeholder="description"><?php  echo "description";  ?></textarea>
          </div>
          <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
          <label for="upload">Leçon :</label> <input type="file" id="upload" name="chp_file_lesson"/>
        </p>
          <label>A faire a partir du : </label>
            <select name="avalable_year" onchange="year(0);"></select>
           <select name="avalable_month" onchange="month(0);"></select>    
           <select name="avalable_day"></select>          

          <label>Jusqu'au : </label>
            <select name="deadline_year" onchange="year(1);"></select>
           <select name="deadline_month" onchange="month(1);"></select>    
           <select name="deadline_day"></select>          

           <p>
            <input type="submit"/>
          </p>
        </form>
      </div>
    </div>
    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

<script src="<?php echo URL.'public/js/ChapterForm.js' ?>"></script>
