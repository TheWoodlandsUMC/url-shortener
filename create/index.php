<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once getcwd().'/php/index.php';
?>
<html>
	<head>
		<title>Title</title>
		<link rel="stylesheet" href="css/foundation.css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	</head>
	<body>
	<!-- Header and Nav -->
	
	<div class="row">
		<div class="large-12 columns">
		<div class="panel">
			<h1>URL Shortener</h1>
		</div>
		</div>
	</div>
	<!-- End Header and Nav -->
	<div class="row">
	<!-- Nav Sidebar -->
		<!-- This is source ordered to be pulled to the left on larger screens -->
		<div class="large-12 columns ">
		<div class="panel">
			<h5>Options</h5>
	
				<form action="" method="post">
				URL: <input id="url" type="text" name="url"><br />
				Rewrite (9 char max): <input type="text" maxlength="9" name="rw"><br />
				<input name="submit" type="submit">
				</form>
	
	
		</div>
		</div>
	
	</div>
	
	<?php echo $shortened; ?>
	
	<!-- Footer -->
	
	<footer class="row">
		<div class="large-12 columns">
		<hr />
		<div class="row">
			<div class="large-5 columns">
			<p>&copy; Copyright</p>
			</div>
		</div>
		</div>
	</footer>
	<script src="js/main.js"></script>
	</body>
</html>
