<!DOCTYPE html>

<?php 
	require_once("/cms/bin/myCms.php"); 
	$cms = new Cms(); 
	$cms->Main();
?>

<html>
	<head>
		<title>Noyau CMS</title>
		<meta charset="UTF-8">
	</head>

	<body>
		<header>
			<h1><a href="/">Test du noyau</a></h1>
			<ul>
				<li><a href="/sectionA">SectionA</a></li>
				<ul>
					<li><a href="/sectionA/test-de-nom-d-article-2-la-section01">Test avec le nom</a></li>
					<li><a href="/sectionA/12">Test avec Id</a></li>
					<li><a href="/sectionA/lol">Test</a></li>
				</ul>
				<li><a href="/sectionB">SectionB</a></li>
				<li><a href="/sectionC">SectionC</a></li>
				<li><a href="/admin">Admin</a></li>
				<ul>
					<li><a href="/Admin/action?section=sectionA">Admin Index</a></li>
					<li><a href="/Admin?section=sectionA&action=add">Admin Add</a></li>
					<li><a href="/Admin?section=sectionA&action=edit&id=1">Admin Edit</a></li>
					<li><a href="/Admin?section=sectionA&action=delete&id=1">Admin Delete</a></li>
				</ul>
			</ul>	
		</header>

		<section>
			<?php echo $cms->GetContent(); ?>
		</section>

		<footer>
			<?php var_dump($t = $cms->getUrlParameters($_SERVER['REQUEST_URI']), $_SERVER["SERVER_PROTOCOL"], is_file("cms/controller/".$t[0]."Controller.php")); ?>
		</footer>
	</body>
</html>