<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <div class="content">
        <h3>Création de chapitre</h3>
        <p>Pour le cours "<?php echo $cours->title(); ?>" - partie "<?php echo $part->title();  ?>"</p>
        <form name="chpform" method="post" action="<?php echo URL.'Professor/CreateChapter_ok?cours='.$_GET["cours"].'&part='.$_GET["part"]; ?>" enctype="multipart/form-data">
          <p>
          <input type="text" name="chp_name" placeholder="nom du chapitre" required/>
          <div>
            <textarea name="chp_descr" placeholder="description"></textarea>
          </div>
          <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
          <label for="upload">Leçon :</label> <input type="file" id="upload" name="chp_file_lesson"/>
        </p>
          <p>
          <label>A faire a partir du : </label>
            <select name="avalable_year" onchange="ava_year();"></select>
           <select name="avalable_month" onchange="ava_month();"></select>    
           <select name="avalable_day"></select>          
          </p>

          <p>
          <label>Jusq'au : </label>
            <select name="deadline_year" onchange="dead_year();"></select>
           <select name="deadline_month" onchange="dead_month();"></select>    
           <select name="deadline_day"></select>          
          </p>

           <p>
            <input type="submit"/>
          </p>
        </form>
      </div>
    </div>
    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

<script src="<?php echo URL.'public/js/ChapterForm.js' ?>"></script>