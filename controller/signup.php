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
		if (isset($_POST['email']) && isset($_POST['password']) &&
		   	isset($_POST['firstname']) && isset($_POST['lastname'])) {
			try {
				$data = array(
				'email' => $_POST['email'],
				'password' => Crypto::createHash($_POST['password']),
				'firstname' => $_POST['firstname'],
				'lastname' => $_POST['lastname']);
				
				$client = new Client($data);
				$clientManager->add($client);
				$success[] = 'Account, ' . $data['firstname'] . ' ' . $data['lastname'] . ', successfully created.';
			}
			catch (Exception $e) {
				$_SESSION['error'][] = $e->getMessage();
			}
		}
		include_once('./view/signup.php');
	}