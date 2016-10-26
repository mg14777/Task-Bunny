<?php
	$clientManager = new ClientManager($db);
    $taskManager = new TaskManager($db);
    $taskerManager = new TaskerManager($db);
	try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}

	if (isset($client)) {
		$results = '';
        try {
            $myTasks = $taskManager->getClientTasks($client->id());


            $count = 0;  
            foreach ($myTasks as $task) {
                $helperArray = array();
                foreach ($taskerManager->getForTask($task['id']) as $t) {
                    $helperArray[] = $clientManager->get($t->helper());
                }
                if($count % 2 == 0) $results .= '<tr class="odd">';
                else $results .= '<tr class="even">';
                $count++;

                $results .= '<td>' . $task['category'] . '</td>';
                $results .= '<td>' . $task['name'] . '</td>';
                $results .= '<td>' . $task['location'] . '</td>';
                $results .= '<td>' . $task['description'] . '</td>';
                $results .= '<td class = "center">' . $task['salary'] . '</td>';
                $results .= '<td class = "center">' . $task['startdate'] . '</td>';
                $results .= '<td class = "center">' . $task['enddate'] . '</td>';
                $results .= '<td class="center">';
                $results .= '<a href = "./editTask.php?id=' . $task['id'] . '">
                                <button type="button" class="btn btn-default glyphicon glyphicon-pencil" title ="Edit"/></button>
                            </a>';
                $results .= '<a href = "./deleteTask.php?id=' . $task['id']. '" onclick="return confirm(\'Are you sure you want to delete?\')">
                                <button type="button" class="btn btn-default glyphicon glyphicon-remove" title ="Delete"></button>
                            </a>';
                foreach ($helperArray as $helper) {
                    $results .= '<div class="contact"><a href="mailto:';
                    $results .= $helper->email() . '"</a>';
                    $results .= '<button type="button" class="btn btn-default">';
                    $results .= 'Contact ' . $helper->firstname() . ' ' . $helper->lastname() . '</button></a></div>';
                }
                $results .= '</td>';
                $results .= '</tr>';
            }
        }
        catch (Exception $e) {
				$_SESSION['error'][] = $e->getMessage();
        }
        
        include_once('./view/tables.php');
        
	}
    else {
        header("Location: ./index.php");
    }
