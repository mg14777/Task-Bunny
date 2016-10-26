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
		include_once('./view/index.php');
	}