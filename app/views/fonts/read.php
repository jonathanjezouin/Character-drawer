<?php include __DIR__ . "/../header.php"; ?>

<h1 class="text-center">
	<span class="glyphicon glyphicon-hand-right"></span> Fonts <span
		class="glyphicon glyphicon-hand-left"></span>
</h1>

<hr />

<body>

	<?php include __DIR__ . "/../ui/fontsCounter.php"; ?>

	<hr class="col-xs-12" />

	<section class="container col-xs-8 col-xs-offset-2">
	
    <?php if(isset($model->results)): ?>
    
		<?php foreach ($model->results as $key => $value): ?>
			<a class="btn btn-primary col-xs-3 col-xs-offset-1"
				style="margin-bottom: 1em"
				href="./admin/fonts/<?= urlencode($value->font_id) ?>?action=manage">
					<?= $value->font_name ?>
			</a>
		<?php endforeach; ?>
        
	<?php endif; ?>
	
	<?php if(isset($model->autorisation) && ($model->autorisation === "OK")): ?>
	<a class="btn btn-info col-xs-3 col-xs-offset-1 glyphicon glyphicon-plus"
    	style="margin-bottom: 1em"
		href="./admin/fonts?action=create">
	</a>
	<?php endif; ?>
	
	<?php if(isset($model->autorisation) && ($model->autorisation === "KO")): ?>
	<a class="btn btn-info col-xs-3 col-xs-offset-1 glyphicon glyphicon-plus disabled"
    	style="margin-bottom: 1em"
		href="#">
	</a>
	<?php endif; ?>
	
	</section>

</body>

<?php include __DIR__ . "/../footer.php"; ?>