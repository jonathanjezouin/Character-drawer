<?php include __DIR__ . "/../header.php"; ?>

<h1 class="text-center">
	<span class="glyphicon glyphicon-cloud"></span> Accueil <span
		class="glyphicon glyphicon-cloud"></span>
</h1>

<hr />

<?php include __DIR__ . "/../ui/alertBox.php"; ?>

<body>

	<section class="container col-xs-8 col-xs-offset-2">
		<a class="btn btn-primary col-xs-3 col-xs-offset-1"
			style="margin-bottom: 1em"
			href="./admin/fonts?action=read">
				Fonts
		</a>
		<a class="btn btn-primary col-xs-3 col-xs-offset-1"
			style="margin-bottom: 1em"
			href="./admin/chars?action=manage">
				Characters
		</a>
		<a class="btn btn-primary col-xs-3 col-xs-offset-1"
			style="margin-bottom: 1em"
			href="./admin/symbs?action=manage">
				Symbols
		</a>
	</section>

</body>

<?php include __DIR__ . "/../footer.php"; ?>