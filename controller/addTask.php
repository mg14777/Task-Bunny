<?php
	$clientManager = new ClientManager($db);
    $taskManager = new TaskManager($db);   
	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$error[] = $e->getMessage();
	}

	if (isset($client)) {
		if (isset($_POST['description']) && isset($_POST['location']) && isset($_POST['startDate']) && isset($_POST['endDate']) &&
           isset($_POST['salary'])) {
			try {
				$task = new Task();
                $task->setCreator($client->id());
                $task->setDescription($_POST['description']);
                $task->setLocation($_POST['location']);
                $task->setStartDate($_POST['startDate']);
                $task->setEndDate($_POST['endDate']);
                $task->setSalary($_POST['salary']);
                $task->setCategory($_POST['category']);
                
                $taskManager->addTask($task);
                
				header("Location: ./dashboard.php");
			}
			catch (Exception $e) {
				$error[] = $e->getMessage();
			}
		}
        include_once('./view/addTask.php');
	}
    else {
        header("Location: ./index.php");
    }
