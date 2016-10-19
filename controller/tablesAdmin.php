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
        if($client->level() == 'admin')
            echo '<a href = "./admin.php" style = "margin: 10px"> 
                    <button type="button" class="btn btn-default" title ="Admin"/>Go to Admin Page</button>
                  </a>';
        
		$results = '';
        try {
            $myTasks = $taskManager->getClientTasksAdmin();


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
                $results .= '<a href = "./editTask.php?id=' . $task['id'] . '">
                                <button type="button" class="btn btn-default glyphicon glyphicon-pencil" title ="Edit"/></button>
                            </a>';
                $results .= '<a href = "./deleteTask.php?id=' . $task['id']. '" onclick="return confirm(\'Are you sure?\')">
                                <button type="button" class="btn btn-default glyphicon glyphicon-remove" title ="Delete"></button>
                            </a>';
                $results .= '</td>';
                $results .= '</tr>';
            }
        }
        catch (Exception $e) {
				$error[] = $e->getMessage();
        }
        
        include_once('./view/tablesAdmin.php');
        
	}
    else {
        header("Location: ./index.php");
    }
