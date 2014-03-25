<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PHP MVC skeleton</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- css -->
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">
    <?php
        if($page == "connexion" || $page == "inscription"){ // if Welcome mode add him css  
            ?><link href="<?php echo URL; ?>public/css/welcome.css" rel="stylesheet"><?php
        }
    ?>
    <link href="<?php echo URL; ?>public/css/<?php echo $page ?>.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <!-- our JavaScript -->
    <script src="<?php echo URL; ?>public/js/application.js"></script>
</head>
<body>
