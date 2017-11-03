<?php include __DIR__ . "/../header.php"; ?>

<h1 class="text-center">
	<span class="glyphicon glyphicon-text-color"></span> Characters <span
		class="glyphicon glyphicon-text-background"></span>
</h1>

<hr />

<?php include __DIR__ . "/../ui/alertBox.php"; ?>

<body>

	<?php include __DIR__ . "/../ui/charsCounter.php"; ?>

	<hr class="col-xs-12" />

	<section class="container col-xs-8 col-xs-offset-2">

    <?php if(isset($model->results)): ?>
        
    	<?php foreach ($model->results as $key => $value): ?>
    	<div>
    			<a class="btn btn-light col-xs-4 disabled" style="margin-bottom: 1em"><?= $value->characters_unicode_name ?></a>
    			<a class="btn btn-light col-xs-4 disabled" style="margin-bottom: 1em"><?= $value->characters_unicode_value ?></a>
    			<?php if(isset($model->autorisation) && ($model->autorisation === "OK")): ?>
    			<a class="btn btn-danger col-xs-1 col-xs-offset-1 glyphicon glyphicon-remove" style="margin-bottom: 1em" href="./admin/chars?action=manage&unicode_to_delete=<?= urlencode($value->characters_id) ?>"></a>
    			<?php endif; ?>
    			<?php if(isset($model->autorisation) && ($model->autorisation === "KO")): ?>
    			<a class="btn btn-danger col-xs-1 col-xs-offset-1 glyphicon glyphicon-remove disabled" style="margin-bottom: 1em" href="#"></a>
    			<?php endif; ?>
		</div>
    	<?php endforeach; ?>
        
	<?php endif; ?>

	<?php if(isset($model->autorisation) && ($model->autorisation === "OK")): ?>
	</section>

	<hr class="col-xs-12" />

	<section class="container col-xs-8">
		<!-- la propriete "name" est envoye en post lors du submit de la page -->
		<!-- dans le controller, on recupere ces donnees pour les travailler -->
		<form action="" method="post">
			<div class="form-group col-xs-4 col-xs-offset-4">
				<label>Nom de la lettre</label> <input class="form-control"
					name="chars_uni_name" placeholder="Tapez une lettre">
			</div>
			<div class="form-group col-xs-4 col-xs-offset-4">
				<label>Valeur unicode</label> <input class="form-control"
					name="chars_uni_value">
			</div>
			<button type="submit"
				class="btn btn-primary col-xs-4 col-xs-offset-4">Valider</button>
		</form>
	</section>
	<?php endif; ?>

</body>

<?php include __DIR__ . "/../footer.php"; ?>