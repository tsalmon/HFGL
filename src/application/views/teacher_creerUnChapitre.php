<div id="main">
    <?php include("_templates/nav_enseignant.php"); ?>
    <div id="site_content">
<<<<<<< HEAD
      <?php include("_templates/bienvenue_title.php"); ?>
=======
      <div id="welcome"><h3>Bienvenue</h3></div>
>>>>>>> f5b7b21adece7fa7f25cc0ecbd4b320f90ec6848
      <div class="content_big">
      		<form method="post" action="<?php echo URL; ?>Professor/CreateChapter_ok?cours=<?php echo $_GET["part"]; ?>&part=<?php echo $_GET["part"]; ?>" enctype="multipart/form-data">
      			<?php 
      				if(isset($error)){
      					echo '<p class="error">'.$error."</p>";
      				}
      			?>
      			<section>
      			<input type="text" name="chp_name" placeholder="Nom du chapitre" required/>
				</section>
      			<section>
      			<textarea name="chp_descr" placeholder="description"></textarea>
      			</section>
      			<section>
      				<label>Leçon</label>
      				<input type="hidden" name="MAX_FILE_SIZE" value="10000000"/>
      				<input name="chp_file_lesson" type="file" required/>
      			</section>
      			<section>
      				<input type="submit" value="Ajouter le chapitre"/>
      			</section>
      		</form>
      </div>
    </div>

    <?php include("_templates/nav_footer_enseignant.php"); ?>
</div>

