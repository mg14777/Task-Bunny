<?php
	$clientManager = new ClientManager($db);
	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}

	if (isset($client)) {
		header("Location: ./dashboard.php");
	}
	else {
		if (isset($_POST['email']) && isset($_POST['password'])) {
			try {
				$client = $clientManager->login($_POST['email'], $_POST['password']);
				header("Location: ./dashboard.php");
			}
			catch (Exception $e) {
				$_SESSION['error'][] = $e->getMessage();
			}
		}
		include_once('./view/login.php');
	}