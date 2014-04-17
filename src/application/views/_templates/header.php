<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HFGL - Have Fun, Good Learning</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">

    <?php
        if((isset($page)) && ($page == "connexion" || $page == "inscription")){ // if Welcome mode add him css  
            ?><link href="<?php echo URL; ?>public/css/welcome.css" rel="stylesheet"><?php
        } else {
            ?>
            <link href="<?php echo URL; ?>public/css/board.css" rel="stylesheet">
            <link href="<?php echo URL; ?>/public/css/navigation.css" rel="stylesheet" type="text/css" />
            <link href="<?php echo URL; ?>/public/css/etudiant.css" rel="stylesheet" type="text/css">
            <?php
        }
        
        if(isset($page)){
            echo '<link href="'.URL.'public/css/'.$page.'.css" rel="stylesheet">';
        }
    ?>

    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <!-- our JavaScript -->
    <script src="<?php echo URL; ?>public/js/application.js"></script>
</head>
<body>
