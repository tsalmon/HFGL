<?
session_start();

function connexion(){
	if(isset($_SESSION["user"])){
		return false;
	}
	$_SESSION["user"] = $_POST["user"];
	return true;
}

function inscription(){
}

function deconnexion(){
	
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/style.css">
		<title>Formation Avancée Professionalisante</title>
	</head>
	<body>
		<?
			if(!isset($_SESSION["user"]) && $_POST == null){ /* not connected */
				include("gestion_compte_connexion.html");
			} else if(array_key_exists("user", $_POST)){  /*try to login...*/
				if(connexion()){
					echo "bienvenue";
				} else {
					print_r($_SESSION);
					echo "<p>already connected</p>";
				}
			} else if(array_key_exists("inscr_name", $_POST)){/* try to sign up ...*/
				inscription();
			} else {
				include("accueil.php");
			}
		?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script src="js/mustache.js"></script>
	</body>
</html>