<?php
	$clientManager = new ClientManager($db);
	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$error[] = $e->getMessage();
	}

	if (isset($client)) {
		echo '<p>already connected <br /> <a href=/logout.php>logout ?</a></p>';
		echo '<p><a href="/dashboard.php">or go to your dashboard ?</a></p>';
	}
	else {
		if (isset($_POST['email']) && isset($_POST['password'])) {
			try {
				$client = $clientManager->login($_POST['email'], $_POST['password']);
				header("Location: ./dashboard.php");
			}
			catch (Exception $e) {
				$error[] = $e->getMessage();
			}
		}
		include_once('/view/login.php');
	}