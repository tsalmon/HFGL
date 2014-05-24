<!-- pour consulter les memoires ou les notes d'un cours -->

<div id="main">

    <?php include("_templates/nav_etudiant.php"); ?>

    <div id="site_content">

      <?php include("_templates/bienvenue_title.php"); ?>

      <div class="content_big">
        
        <h1><?php echo $courseTitle." : ".$partTitle." – ".$chapterTitle;?></h1>
        <div id="div_scroll">
            <p>
      
              <iframe src="<?php echo $url; ?>" height="1000" seamless/>
                Votre navigateur ne supporte pas des iframes. Pensez à le jeter et installer un autre!
              </iframe>
            </p>
        </div>

        <a href="<?php echo URL; ?>Student/">
          <p>
            <span>&nbsp;</span>
            <input class="bouton" value="Traveaux de cours" />
          </p>
        </a>

        <p>
          <span>&nbsp;</span>
          <a href="<?php echo $url;?>"><button class="bouton">Enregistrer</button></a>
        </p>
          
      </div>

      
    <div class="clearfooter"></div>

 </div>
    
    <?php include("_templates/nav_footer_etudiant.php"); ?>
</div>


