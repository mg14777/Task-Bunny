<?php
	$clientManager = new ClientManager($db);
    $taskManager = new TaskManager($db);   
	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}

	if (isset($client)) {
            if (isset($_GET['id'])) {
                try {
                    if($client->level() == 'admin')
                        $task = $taskManager->deleteTaskAdmin($_GET['id']);
                    else
                        $task = $taskManager->deleteTask($_GET['id'], $client->id());
                    
                    if(isset($_GET['admin']))
                        header("Location: ./tablesAdmin.php");
                    else
                        header("Location: ./dashboard.php");
                }
                catch (Exception $e) {
                    $_SESSION['error'][] = $e->getMessage();
                    header("Location: ./dashboard.php");
                }
            }
            else {
                header("Location: ./index.php");
            }
    }
    else {
        header("Location: ./index.php");
    }
