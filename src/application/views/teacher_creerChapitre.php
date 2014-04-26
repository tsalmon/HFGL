<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
      <div class="content">
        <h3>Création de chapitre</h3>
        <p>Pour le cours "<?php echo $cours->title(); ?>" - partie "<?php echo $part->title();  ?>"</p>
        <form method="post" action="<?php echo URL.'Professor/CreateChapter_ok?cours='.$_GET["cours"].'&part='.$_GET["part"]; ?>" enctype="multipart/form-data">
          <input type="text" name="chp_name" placeholder="nom du chapitre" required/>
          <div>
            <textarea name="chp_descr" placeholder="description"></textarea>
          </div>
          <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
          <label for="upload">Leçon :</label> <input type="file" id="upload" name="chp_file_lesson"/>
          <p>
            <input type="submit"/>
          </p>
        </form>
      </div>
    </div>
    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>