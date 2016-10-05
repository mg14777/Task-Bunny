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
				$success[] = 'User ' . $data['firstname'] . ' ' . $data['lastname'] . ' correctly added';
			}
			catch (Exception $e) {
				$error[] = $e->getMessage();
			}
		}
		include_once('./view/signup.php');
	}