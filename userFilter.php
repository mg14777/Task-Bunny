<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Available Tasks</title>
</head>
<body>
    <?php include("init.php");
          include './table_generator.php';
    ?>
    <a href="./dashboard.php">Back to Dashboard</a>
    <h2>User Task Filter</h2>
	<form action="./userFilter.php" method="GET">
		<select>
                        <option value="">Task Category</option>
                    <?php
                    $query = 'SELECT title FROM task_category';
                    $result = pg_query($query) or die('Query failed:'.pg_last_error());

                    while($row = pg_fetch_row($result)) {
                        echo"<option value=\"".$row[0]."\">".$row[0]."</option><br>";
                    }
                    pg_free_result($result);
                    ?>
        </select>
		<input type="text" id="startDate" name="startDate" placeholder="Start Date"/>
		<input type="text" id="endDate" name="endDate" placeholder="End Date"/><br><br>
		<input type="submit" value="Filter"/>

    </form>
        <table id="dataTables-example">
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
                                        $results = '';
                                        $result = NULL;
                                        try {
                                            $all_fields_empty = True;
                                            $startDate = NULL;
                                            $endDate = NULL;
                                            if(isset($_GET['startDate'])) {
                                                $startDate = date('Y-m-d', strtotime(str_replace('-', '/', $_GET['startDate'])));
                                            }
                                            else
                                                $startDate = 0001-01-01;

                                            if(isset($_GET['endDate'])) {
                                                $endDate = date('Y-m-d', strtotime(str_replace('-', '/', $_GET['endDate'])));
                                            }
                                            else
                                                $endDate = 9999-12-30;

                                            if(isset($_GET['startDate']) && isset($_GET['endDate'])) {
                                                $result = pg_query("SELECT t.id, concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id AND t.start_time >= '$startDate' AND t.end_time <= '$endDate'");
                                                
                                            }
                                            if($result != NULL) {
                                                $numcolumn = pg_num_fields($result);
                                                
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
                                                       $results .= '<td>' . $column . '</td>';
                                                    }
                                        
                                                    $results .= '</tr>';
                                                    
                                                }
                                                $results .= '</tbody>';

                                            }
                                            
                                        }
                                        catch (Exception $e) {
                                                $error[] = $e->getMessage();
                                        }                                        
                                    }
                                    else {
                                        header("Location: ./index.php");
                                    }
                                    
                                    echo $results; 
                                    ?>                                   
        </table>
        <h2>Statistics</h2>
        <form action="./userFilter.php" method="GET">
            <h3>Number of tasks per group (Group By)</h3>
            <select name='group_criteria'>
                        <option value="task_category">Task Category</option>
            </select>
            <input type="submit" value="Count"/>
        </form>
        <?php
            $results = '';
            $result = NULL;
            try {
                if(isset($_GET['group_criteria'])) {
                    
                    if($_GET['group_criteria'] == 'task_category')
                        $result = pg_query("SELECT c.title AS category, COUNT(*) AS Number_of_tasks  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id GROUP BY c.title");
                }
                else {
                    $results .= '<h3>Select grouping criteria !!</h3>';
                }

                if($result != NULL) {
                    $numcolumn = pg_num_fields($result);
                    $results .= '<table id="dataTables-example">';
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
                           $results .= '<td>' . $column . '</td>';
                        }
            
                        $results .= '</tr>';
                        
                    }
                    $results .= '</tbody>'; 
                    $results .= '</table>';
                }                                            
                
            }
            catch (Exception $e) {
                    $error[] = $e->getMessage();
            }                                                                            
            echo $results; 
        ?> 
        <form action="./userFilter.php" method="GET">
            <h3>Tasks with certain location pattern (Like)</h3>
            <input type="text" id="location" name="location" placeholder="Location">
            <input type="submit" value="Find"/>
        </form>   
        <?php
            $results = '';
            $result = NULL;
            try {
                
                if(isset($_GET['location'])) {
                    $location = $_GET['location'];
                    $result = pg_query("SELECT c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id AND (t.location LIKE '%'||'$location'||'%')");

                }
                else {
                    $results .= '<h3>Select grouping criteria !!</h3>';
                }

                if($result != NULL) {
                    $results = table_generator($result);
                }                                            
                
            }
            catch (Exception $e) {
                    $error[] = $e->getMessage();
            }                                                                            
            echo $results; 
        ?>  
        <form action="./userFilter.php" method="GET">
            <h3>Tasks with Max/Min salary per group (Having)</h3>
            <select name='group_criteria_having'>
                        <option value="" disabled selected>Group By</option>
                        <option value="task_category">Task Category</option>
            </select>
            <select name='max_or_min_having'>
                        <option value="max">Max</option>
                        <option value="min">Min</option>
            </select>
            <input type="submit" value="Find"/>
        </form>
        <?php
            $results = '';
            $result = NULL;
            try {
                //include './table_generator.php';
                if(isset($_GET['group_criteria_having'])) {

                    if($_GET['group_criteria_having'] == 'task_category') {
                        if($_GET['max_or_min_having'] == 'max')
                            $result = pg_query("SELECT c.title AS category, t.salary AS Max_Salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id GROUP BY c.title, t.salary HAVING t.salary >= ALL(SELECT t1.salary FROM task t1, client u1, task_category c1 WHERE t1.creator = u1.id AND c1.id = t1.category AND c1.title = c.title )");
                        if($_GET['max_or_min_having'] == 'min')
                            $result = pg_query("SELECT c.title AS category, t.salary AS Min_Salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id GROUP BY c.title, t.salary HAVING t.salary <= ALL(SELECT t1.salary FROM task t1, client u1, task_category c1 WHERE t1.creator = u1.id AND c1.id = t1.category AND c1.title = c.title )");
                    }
                }
                else {
                    //$results .= '<h3>Select grouping criteria !!</h3>';
                }

                if($result != NULL) {
                    $results = table_generator($result);
                }                                            
                
            }
            catch (Exception $e) {
                    $error[] = $e->getMessage();
            }                                                                            
            echo $results; 
        ?>
        <form action="./userFilter.php" method="GET">
            <h3>Tasks with max or min salary (ALL)</h3>
            <select name='max_or_min'>
                        <option value="max">Max</option>
                        <option value="min">Min</option>
            </select>
            <input type="submit" value="Find"/>
        </form> 
        <?php
            $results = '';
            $result = NULL;
            try {
                //include './table_generator.php';
                if(isset($_GET['max_or_min'])) {

                    if($_GET['max_or_min'] == 'max')
                        $result = pg_query("SELECT c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary AS Max_Salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id AND t.salary >= ALL(SELECT t1.salary FROM task t1, client u1 WHERE t1.creator = u1.id)");
                    if($_GET['max_or_min'] == 'min')
                        $result = pg_query("SELECT c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary AS Min_Salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id AND t.salary <= ALL(SELECT t1.salary FROM task t1, client u1 WHERE t1.creator = u1.id)");
                }
                else {
                    //$results .= '<h3>Select grouping criteria !!</h3>';
                }

                if($result != NULL) {
                    $results = table_generator($result);
                }                                            
                
            }
            catch (Exception $e) {
                    $error[] = $e->getMessage();
            }                                                                            
            echo $results; 
        ?>                             
</body>
</html>