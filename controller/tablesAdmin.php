<?php
	$clientManager = new ClientManager($db);
    $taskManager = new TaskManager($db);
    try {
		$client = $clientManager->session();
	}
	catch (Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}

	if (isset($client) && $client->level() == 'admin') {
		$results = '';
        try {
            $myTasks = $taskManager->getAllTasksAdmin();


            $count = 0;  
            foreach ($myTasks as $task) {
                if($count % 2 == 0) $results .= '<tr class="odd">';
                else $results .= '<tr class="even">';
                $count++;

                $results .= '<td>' . $task['category'] . '</td>';
                $results .= '<td>' . $task['name'] . '</td>';
                $results .= '<td>' . $task['location'] . '</td>';
                $results .= '<td>' . $task['description'] . '</td>';
                $results .= '<td class = "center">' . $task['salary'] . '</td>';
                $results .= '<td class = "center">' . $task['startdate'] . " " . $task['starttime'] . '</td>';
                $results .= '<td class = "center">' . $task['enddate'] . " " . $task['endtime'] . '</td>';
                $results .= '<td class="center">';
                $results .= '<a href = "./editTask.php?id=' . $task['id'] . '&admin=true">
                                <button type="button" class="btn btn-default glyphicon glyphicon-pencil" title ="Edit"/></button>
                            </a>';
                $results .= '<a href = "./deleteTask.php?id=' . $task['id']. '&admin=true" onclick="return confirm(\'Are you sure?\')">
                                <button type="button" class="btn btn-default glyphicon glyphicon-remove" title ="Delete"></button>
                            </a>';
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
