<?php include __DIR__ . "/../header.php"; ?>

<h1 class="text-center">
	<span class="glyphicon glyphicon-hand-right"></span> Fonts <span
		class="glyphicon glyphicon-hand-left"></span>
</h1>

<hr />

<?php include __DIR__ . "/../ui/alertBox.php"; ?>

<body>
	<section class="container col-xs-8">
		<!-- la propriete "name" est envoye en post lors du submit de la page -->
		<!-- dans le controller, on recupere ces donnees pour les travailler -->
		<form action="" method="post">
			<div class="form-group col-xs-4 col-xs-offset-4">
				<label>Nom de la font</label> <input class="form-control" name="fonts_name"
					placeholder="Tapez une font">
			</div>
			<div class="form-group col-xs-4 col-xs-offset-4">
				<label>Hauteur</label> <input class="form-control"
					name="fonts_height" type="number">
			</div>
			<?php if(isset($model->autorisation) && ($model->autorisation === "OK")): ?>
			<button type="submit" class="btn btn-primary col-xs-4 col-xs-offset-4">Valider</button>
			<?php endif; ?>
			<?php if(isset($model->autorisation) && ($model->autorisation === "KO")): ?>
			<button type="submit" class="btn btn-primary col-xs-4 col-xs-offset-4 disabled">Valider</button>
			<?php endif; ?>
		</form>
	</section>

</body>

<?php include __DIR__ . "/../footer.php"; ?>
