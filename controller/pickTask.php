<?php
	$clientManager = new ClientManager($db);
    $taskManager = new TaskManager($db);
    $taskPicker = new TaskPicker($db);

	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}

	if (isset($client)) {
		if (isset($_GET['id']) && isset($_GET['creator'])) {
                try {
                    $taskArray = $taskManager->getTaskInfo($_GET['id'], $_GET['creator']);
                    $task = array('id' => $_GET['id'],
                                  'creator' => $_GET['creator'],
                                  'startDate' => $taskArray[0]['startdate'],
                                  'endDate' => $taskArray[0]['enddate']);
                    $taskPicker->pick($client, $task);
                    header("Location: ./helperTask.php");
                }
                catch (Exception $e) {
                    $_SESSION['error'][] = $e->getMessage();
                    header("Location: ./availableTask.php");
                }
            }
            else {
                header("Location: ./index.php");
            }
    }
    else {
        header("Location: ./index.php");
    }
	