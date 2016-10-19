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
                
                if($client->level() == 'admin')
                    $taskManager->editTaskAdmin($_GET['id'], $task);
                else
                    $taskManager->editTask($_GET['id'], $task);
                
				if(isset($_GET['admin']))
                    header("Location: ./tablesAdmin.php");
                else
                    header("Location: ./dashboard.php");
			}
			catch (Exception $e) {
				$error[] = $e->getMessage();
			}
		}
        else {
            if (isset($_GET['id'])) {
                try {
                    if($client->level() == 'admin')
                        $task = $taskManager->getTaskInfoAdmin($_GET['id']);
                    else
                        $task = $taskManager->getTaskInfo($_GET['id'], $client->id());
                    
                    if(!count($task))
                        throw new Exception('Illegal Operation. You\'ll get nowhere.');
                }
                catch (Exception $e) {
                    $error[] = $e->getMessage();
                }
            }
            else {
                header("Location: ./index.php");
            }
        }
        include_once('./view/editTask.php');
	}
    else {
        header("Location: ./index.php");
    }
