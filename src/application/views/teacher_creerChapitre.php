<?php $create = ($page === "CreateChapter"?True:False);?>
<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>
      <div class="form_settings">
        <form name="chpform" method="post" id="chapterForm"
              action="" 
              onsubmit="return chpValid();"
              enctype="multipart/form-data">
        <fieldset>
          <legend> 
            <?php if ($create){
                    echo '<h3>Création de chapitre</h3>';
                  }else{
                    echo '<h3>Modifier un chapitre</h3>';
                  } ?>
          </legend>
          <p>Pour le cours "<?php echo $cours->title(); ?>" - partie "<?php echo $part->title();  ?>"</p>

          <p>
            <p><span>Nom du chapitre</span>
              <input type="text" name="chp_name" placeholder="Chapitre..." value="<?php if(!$create){ echo $chp->title(); }?>" required/>
            </p>

            <p><span>Description du chapitre</span>
              <textarea name="chp_descr" placeholder="Description..."><?php if(!$create){ echo $chp->description();}?></textarea>
            </p>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
            <p>
              <span>Leçon :</span>
              <input type="file" id="upload" name="chp_file_lesson"/>
            </p>
            <p>
              <?php 
                if(!$create){ 
                  echo "<span>Fichier chargé:</span>";
                  if (null !== $chp->courseNotes() && null !== $chp->courseNotes()->getURL()) {
                    echo $chp->courseNotes()->getURL();
                  }else{
                    echo "Aucun";
                  }
                }
              ?>
            </p>
          </p>
          

         <p class="pbouton" align="center">
          <input class="bouton" type="submit" value="Retourner" formaction="<?php echo URL.'Professor/?cours='.$_GET["cours"]; ?>"/>
          <input class="bouton" type="submit" value="Sauvegarder" formaction="
                  <?php 
                  if ($create) {
                    echo URL.'Professor/CreateChapter_ok?cours='.$_GET["cours"].'&part='.$_GET["part"]; 
                  } else {
                    echo URL.'Professor/ModifyChapter?cours='.$_GET["cours"].'&part='.$_GET["part"].'&chapter='.$_GET["chp"];
                  }
                  ?>"
                />
         </p>

         <p class="pbouton" align="center">
          <?php 
            if (!$create) {
              $deleteURL = URL.'Professor/DeleteChapter?cours='.$_GET["cours"].'&part='.$_GET["part"].'&chapter='.$_GET["chp"]; 
              echo '<input class="bouton" 
                            type="submit" 
                           value="Supprimer" 
                      formaction="'.$deleteURL.'" 
                         onclick="return confirm(\'Etes-vous sûr de vouloir supprimer ce chapitre?\');">';
          ?>
          
          <?php
              $addExerciceURL = URL.'Professor/AddChapterExercice?cours='.$_GET["cours"].'&part='.$_GET["part"].'&chapter='.$_GET["chp"];
              echo '<input class="bouton" 
                            type="submit" 
                           value="Ajouter un exercice" 
                      formaction="'.$addExerciceURL.'">';
            }
          ?>
         </p>


        </fieldset>
        </form>
      </div>
    <div class="clearfooter"></div>
      
    </div>
    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>