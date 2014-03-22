<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<?
			if(isset($_GET["page"])){
				if($_GET["page"] == "inscription"){
					echo '<link rel="stylesheet" type="text/css" href="css/welcome.css">';
				}
				echo '<link rel="stylesheet" type="text/css" href="css/'.$_GET["page"].'.css">';
			} else{
				echo '<link rel="stylesheet" type="text/css" href="css/welcome.css">
				<link rel="stylesheet" type="text/css" href="css/connexion.css">';
			}
		?>
		<title>HFGL</title>
	</head>
	<body>
		<?
			if(isset($_POST["user"]) && isset($_POST["pwd"])){
				if(isset($_POST["connexion"])){
					if($_POST["user"] == "prof"){
						include("enseignant.php");
					} else {
						include("etudiant.php");
					}
				} else if($_POST["inscription"]){
					echo "vous venez de vous inscrire";
				} else{
					echo "???";
				}
			} else if(isset($_GET["page"])){
				include(($_GET["page"]).".php");
			} else{
				include("connexion.html");
			}
		?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="js/mustache.js"></script>
	</body>
</html>