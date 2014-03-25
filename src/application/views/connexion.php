<div id="middle">
	<form action="<?php echo URL; ?>Welcome/Connexion" method="POST" id="middleform">
		<h1 id="hfgl">Bienvenue sur HFGL</h1>
		<p id="quote">Have Fun, Good Learning</p>
		<a id="inscription" href="<?php echo URL; ?>Welcome/inscription">s'inscrire</a>
		<input type="text" name="user" id="username" placeholder="Nom d'utilisateur">
		<input type="hidden" name="connexion">
        <input type="password" name="pwd" id="pwd" placeholder="Mot de passe">
        <input type="submit" value="Connexion">
	</form>
</div>