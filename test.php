<?php
function loadClass($class) {
	require '/class/' . $class . '.class.php';
}

spl_autoload_register('loadClass');

$data = array('email' => 'timote.vaucher@u.nus.edu',
			  'password' => Crypto::createHash('myPassword'));

try {
	$client = new Client($data);
}
catch (Exception $e) {
	echo $e->getMessage() . '<br />';
}

$clientManager = new ClientManager(DBFactory::getPgsqlConnexion());
if (isset($client)) {
	try {
		$clientManager->add($client);
	}
	catch (Exception $e) {
		echo $e->getMessage() . '<br />';
	}
}

$client2 = $clientManager->get(3);
echo '<br /><br />' . $client2;

$client2->setPassword(Crypto::createHash('newPassword'));
$client2->setLevel('user');
$clientManager->persist($client2);

$client3 = $clientManager->get(3);
echo '<br /><br />' . $client3;

try {
	$client4 = $clientManager->session();
	echo '<br /> valid session';
}
catch (Exception $e) {
	echo $e->getMessage() . '<br />';
}

if (!isset($client4)) {
	try {
		$client4 = login('timote.vaucher@comp.nus.edu', 'newPassword');
		echo ' <br /> connected sucessfully';
	}
	catch (Exception $e) {
		echo $e->getMessage() . '<br />';
	}
}
echo '<br /><br />' . $client4;