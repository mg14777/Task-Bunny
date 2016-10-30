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
		if (isset($_POST['description']) && isset($_POST['location']) && isset($_POST['startDate']) && isset($_POST['startTime']) && isset($_POST['endDate']) && isset($_POST['endTime']) && isset($_POST['salary']) && isset($_POST['category'])) {
			try {
				$task = new Task();
                $task->setCreator($client->id());
                $task->setDescription($_POST['description']);
                $task->setLocation($_POST['location']);
                $task->setStartDate($_POST['startDate']);
                $task->setEndDate($_POST['endDate']);
                $task->setStartTime($_POST['startTime']);
                $task->setEndTime($_POST['endTime']);
                $task->setSalary($_POST['salary']);
                $task->setCategory($_POST['category']);
                
                $taskManager->addTask($task);
                
				header("Location: ./dashboard.php");
			}
			catch (Exception $e) {
				$_SESSION['error'][] = $e->getMessage();
			}
		}
        $categories = $taskManager->getCategories();
        include_once('./view/addTask.php');
	}
    else {
        header("Location: ./index.php");
    }
