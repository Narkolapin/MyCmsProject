<!DOCTYPE html>

<?php require_once("/cms/bin/myCms.php"); ?>

<html>
	<head>
		<title>Noyau CMS</title>
	</head>

	<body>
		<header>
			<h1><a href="/">Test du noyeau</a></h1>
			<ul>
				<li><a href="/section01">Section01</a></li>
				<ul>
					<li><a href="/section01/test-de-nom-d-article-2-la-section01">Test avec le nom</a></li>
					<li><a href="/section01/12">Test avec Id</a></li>
					<li><a href="/section01/lol">Test</a></li>
				</ul>
				<li><a href="/section02">Section02</a></li>
				<li><a href="/section03">Section03</a></li>
				<li><a href="/admin">Admin</a></li>
			</ul>	
		</header>

		<section>
			<?php 
				$cms = new Cms(); 
				echo $cms->Main();
			?>
		</section>

		<footer>
			<?php var_dump($cms->getUrlParameters($_SERVER['REQUEST_URI']), $_SERVER["SERVER_PROTOCOL"]); ?>
		</footer>
	</body>
</html>