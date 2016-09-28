<?php
	$clientManager = new ClientManager($db);

	if (isset($_POST['email']) && isset($_POST['password'])) {
		try {
			$client = $clientManager->login($_POST['email'], $_POST['password']);
			header("Location: /");
		}
		catch (Exception $e) {
			$error[] = $e->getMessage();
		}
	}
	else {
		try {
			$client = $clientManager->session();
		}
		catch (Exception $e) {
			$error[] = $e->getMessage();
		}
	}
	
	if (isset($client)) {
		echo 'already connected';
	}
	else {
		include_once('/view/login_test.php');
	}