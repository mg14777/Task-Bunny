<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Login page</title>
	</head>
	<body>
		<h1>Login</h1>
		<?php include('flagHandler.php') ?>
		<form action="login_test.php" method="post">
		<p>
			<label for="email">Email : </label><input type="text" name="email" /><br />
			<label for="password">Password : </label><input type="password" name="password" /><br />
 			<input type="submit" value="Submit" />
		</p>
		</form>
	</body>
</html>