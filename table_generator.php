<?php
	function table_generator($result) {
					$results = '';
					$numcolumn = pg_num_fields($result);
                    $results .= '<table width="50%" id="dataTables-example">';
                    $results .= '<thead>';
                    $results .= '<tr>';
                    for($i=0; $i < $numcolumn; $i++) {
                        $column_name = pg_field_name($result, $i);
                        $results .= '<th>'.$column_name.'</th>';
                    }
                    $results .= '</tr>';
                    $results .= '</thead>';
                    $tasksArray = array();
                    while($line = pg_fetch_array($result,null,PGSQL_ASSOC)) {
                        array_push($tasksArray,$line);
                    }

                    pg_free_result($result);
                    $myTasks = $tasksArray;

                    $count = 0;  
                    $results .= '<tbody>';
                    foreach ($myTasks as $task) {
                        
                        if($count % 2 == 0) $results .= '<tr class="odd">';
                        else $results .= '<tr class="even">';
                        $count++;
                        
                        foreach ($task as $column) {
                           $results .= '<td align="center">' . $column . '</td>';
                        }
            
                        $results .= '</tr>';
                        
                    }
                    $results .= '</tbody>'; 
                    $results .= '</table>';
                    return $results;
	}
?>