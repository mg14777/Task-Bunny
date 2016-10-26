<?php
	$clientManager = new ClientManager($db);
	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}

	if (isset($client)) {
		//Do something with client if connected
	}
	else {
		//Do something else if not
	}