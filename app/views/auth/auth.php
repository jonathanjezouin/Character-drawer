<?php include __DIR__ . "/../header.php"; ?>

<h1 class="text-center">
	<span class="glyphicon glyphicon-cloud-upload"></span> Authentification <span
		class="glyphicon glyphicon-cloud-upload"></span>
</h1>

<hr />

<?php include __DIR__ . "/../ui/alertBox.php"; ?>

<body>
	<section class="container col-xs-8">
		<?php if(!$userLevel): ?>
		<!-- la propriete "name" est envoye en post lors du submit de la page -->
		<!-- dans le controller, on recupere ces donnees pour les travailler -->
		<form action="/ASCII/web/auth?action=auth" method="post">
			<div class="form-group col-xs-4 col-xs-offset-4">
				<label>User login</label> <input name="user_login"
					placeholder="Entrez votre email..." class="form-control">
			</div>
			<div class="form-group col-xs-4 col-xs-offset-4">
				<label>User password</label> <input name="user_password" placeholder=""
					class="form-control"> <input name="token" type="hidden" value="<?= $token ?>">
			</div>
			<button type="submit" class="btn btn-primary col-xs-4 col-xs-offset-4">Log in</button>

		</form>
		<?php endif; ?>
	</section>
</body>

<?php include __DIR__ . "/../footer.php"; ?>