<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>ASCII</title>
<base href="http://localhost/ASCII/web/" />
<link rel="stylesheet" type="text/css"
	href="./node_modules/bootstrap/dist/css/bootstrap.css" />
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="./auth?action=accueil">ASCII</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li><a href="./admin/fonts?action=read">Fonts</a></li>
					<li><a href="./admin/chars?action=manage">Characters</a></li>
					<li><a href="./admin/symbs?action=manage">Symbols</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php if(isset($userLevel) && $userLevel): ?>
						<li>
						<a><span class="text-muted">Niveau : 
						<?php if($userLevel === "superadmin"): ?>
						Super Admin
						<?php endif; ?>
						<?php if($userLevel === "admin"): ?>
						Admin
						<?php endif; ?>
						<?php if($userLevel === "user"): ?>
						User
						<?php endif; ?>
						</span></a>
						</li>
						<li>
						<a href="./auth?action=destroy">
    						<span class="glyphicon glyphicon-cloud-download"></span>
    						 Deconnexion 
    						<span class="glyphicon glyphicon-cloud-download"></span>
						</a>
						</li>
					<?php endif; ?>
					<?php if(!isset($userLevel) || !$userLevel): ?>
						<li class="text-right">
						<a href="./auth?action=auth">
							<span class="glyphicon glyphicon-cloud-upload"></span>
							 Connexion 
							<span class="glyphicon glyphicon-cloud-upload"></span>
						</a>
						</li>
					<?php endif; ?>	
				</ul>
			</div>
		</div>
	</nav>

</body>
</html>