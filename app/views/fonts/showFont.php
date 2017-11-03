<?php include __DIR__ . "/../header.php"; ?>

<h1 class="text-center">
	<span class="glyphicon glyphicon-hand-right"></span> <?= $model->results[0]->font_name ?> <span
		class="glyphicon glyphicon-hand-left"></span>
</h1>

<hr />

<?php include __DIR__ . "/../ui/alertBox.php"; ?>

<body>

	<hr class="col-xs-12" />

	<section class="container col-xs-8 col-xs-offset-2">

    <?php if(isset($charsFont->resultsLink)): ?>
        
    	<?php foreach ($charsFont->resultsLink as $key => $value): ?>
    	<div>
			<a class="btn btn-light col-xs-4 disabled" style="margin-bottom: 1em"><?= $value->characters_unicode_name ?></a>
			<a class="btn btn-light col-xs-4 disabled" style="margin-bottom: 1em"><?= $value->characters_unicode_value ?></a>
			<?php if(isset($model->autorisation) && ($model->autorisation === "OK")): ?>
			<a
				class="btn btn-danger col-xs-1 col-xs-offset-1 glyphicon glyphicon-minus"
				style="margin-bottom: 1em"
				href="./admin/fonts/<?= urlencode($model->results[0]->font_id) ?>?action=manage&delete_char_id=<?= urlencode($value->characters_id) ?>"></a>
			<?php endif; ?>
			<?php if(isset($model->autorisation) && ($model->autorisation === "KO")): ?>
			<a
				class="btn btn-danger col-xs-1 col-xs-offset-1 glyphicon glyphicon-minus disabled"
				style="margin-bottom: 1em"
				href="#"></a>
			<?php endif; ?>
		</div>
    	<?php endforeach; ?>
        
	<?php endif; ?>

	</section>
	
	<hr class="col-xs-12" />

	<section class="container col-xs-8 col-xs-offset-2">

    <?php if(isset($charsFont->resultsNoLink)): ?>
        
    	<?php foreach ($charsFont->resultsNoLink as $key => $value): ?>
    	<div>
			<a class="btn btn-light col-xs-4 disabled" style="margin-bottom: 1em"><?= $value->characters_unicode_name ?></a>
			<a class="btn btn-light col-xs-4 disabled" style="margin-bottom: 1em"><?= $value->characters_unicode_value ?></a>
			<?php if(isset($model->autorisation) && ($model->autorisation === "OK")): ?>
			<a	class="btn btn-info col-xs-1 col-xs-offset-1 glyphicon glyphicon-plus"
				style="margin-bottom: 1em"
				href="./admin/fonts/<?= urlencode($model->results[0]->font_id) ?>?action=manage&char_id=<?= urlencode($value->characters_id) ?>"></a>
			<?php endif; ?>
			<?php if(isset($model->autorisation) && ($model->autorisation === "KO")): ?>
			<a	class="btn btn-info col-xs-1 col-xs-offset-1 glyphicon glyphicon-plus disabled"
				style="margin-bottom: 1em"
				href="#"></a>
			<?php endif; ?>
		</div>
    	<?php endforeach; ?>
        
	<?php endif; ?>

	</section>
	

</body>

<?php include __DIR__ . "/../footer.php"; ?>