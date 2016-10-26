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
            $myTasks = $taskManager->getHelperTasks($client->id());


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
                $results .= '<td class = "center">' . $task['startdate'] . '</td>';
                $results .= '<td class = "center">' . $task['enddate'] . '</td>';
                $results .= '<td class="center">';
                $results .= '<div>people on the task : ';
                $results .= $taskerManager->getCountHelperFor($task['id']) . '</p>';
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
