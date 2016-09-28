<?php
	include_once('init.php');
	$clientManager = new ClientManager($db);
	$clientManager->logOut();
	header("Location: /");