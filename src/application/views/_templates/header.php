<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HFGL - Have Fun, Good Learning</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">

    <?php
        if((isset($page)) && ($page == "connexion" || $page == "inscription" || $page == "inscription_failed" || $page == "inscription_ok")){ // if Welcome mode add him css  
            ?><link href="<?php echo URL; ?>public/css/welcome.css" rel="stylesheet"><?php
        } else {
            ?>
            <link href="<?php echo URL; ?>public/css/board.css" rel="stylesheet">
            <link href="<?php echo URL; ?>/public/css/navigation.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo URL; ?>/public/css/etudiant.css" rel="stylesheet" type="text/css">
            <?php
        }
        
        if(isset($page)){
            if($page == "inscription_ok" || $page == "inscription_failed"){
                $page_css = "connexion";
                echo '<link href="'.URL.'public/css/inscription.css" rel="stylesheet">';
            } else {
            echo '<link href="'.URL.'public/css/'.$page_css.'.css" rel="stylesheet">';
                $page_css = $page;
            }
            echo '<link href="'.URL.'public/css/'.$page_css.'.css" rel="stylesheet">';
        }
    ?>

    <!-- jQuery 
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <!-- our JavaScript -->
    <?php 
        if(isset($page) && $page == "CreateExercice"){
            echo '<script src="'.URL.'public/js/exercice.js"></script>';
        } elseif(isset($page) && $page == "prof"){
            echo '<script>
            xmlhttp = new XMLHttpRequest();

            function createPart(id_cours){
                var nom_partie=prompt("Entrez le nom de la partie");
                xmlhttp.onreadystatechange = function(){
                    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
                       var t = xmlhttp.responseText.split(" ");
                       if(t[0] == "error"){
                            alert("La partie existe deja");
                       } else {
                            location.reload();
                       }
                    }
                }
                xmlhttp.open("GET", "'.URL.'Professor/CreatePart?cours="+id_cours+"&part="+nom_partie+"");
                xmlhttp.send();
            }
            </script>';
        }
    ?>
        <!--<script src="<?php /*echo URL;*/ ?>public/js/application.js"></script>-->
</head>
<body>