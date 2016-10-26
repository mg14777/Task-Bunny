<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Available Tasks</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    
    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <nav class="nav">
                    <a href="./dashboard.php"><button class="btn btn-link">My tasks</button></a>
                    <a href="./availableTask.php"><button class="btn btn-link">Available tasks</button></a>
                    <a href="./helperTask.php"><button class="btn btn-link">Tasks I'm helping</button></a>
                </nav>
                <div class="col-lg-12">
                    <h1 class="page-header"></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row" id="search_row">
                <div class="col-md-1">
                    <a href="addTask.php"><button class="btn btn-default" type="button">Add Task</button></a>
                </div>
                <form action="filter.php" method="GET">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Start Date">
                </div>
                <div class="col-md-2">
                    <input type="text" class="form-control" id="endDate" name="endDate" placeholder="End Date">
                </div>
                <div class="col-md-2">
                    
                    <input class="form-control" type="submit" value="Filter"/>
                    
                </div>
                </form>
                <div class="col-md-2">
                    <div class="input-group">
                      <input id="search_filter" type="text" class="form-control" placeholder="Search for...">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Go!</button>
                      </span>
                    </div><!-- /input-group -->
                </div><!-- /.col-lg-6 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <!--<thead>
                                    <tr>
                                        <th>Task Category</th>
                                        <th>Creator</th>
                                        <th>Location</th>
                                        <th>Description</th>
                                        <th>Salary</th>
                                        <th>Start time</th>
                                        <th>End time</th>
                                        <th>Tools</th>
                                    </tr>
                                </thead>
                            -->
                                <tbody>
                                    <?php
                                    include($_SERVER['DOCUMENT_ROOT']."/class/ClientManager.class.php");
                                    include($_SERVER['DOCUMENT_ROOT']."/class/TaskManager.class.php");
                                    include($_SERVER['DOCUMENT_ROOT']."/class/DBFactory.class.php");
                                    $db = DBFactory::getPgsqlConnexion();
                                    $clientManager = new ClientManager($db);
                                    $taskManager = new TaskManager($db);   
                                    /*try {
                                        $client = $clientManager->session();
                                    }
                                    catch (Exception $e) {
                                        $error[] = $e->getMessage();
                                    }*/

                                    //if (isset($client)) {
                                        $results = '';
                                        try {
                                            $all_fields_empty = True;
                                            $startDate = NULL;
                                            $endDate = NULL;
                                            if(isset($_GET['startDate'])) {
                                                $startDate = date('Y-m-d', strtotime(str_replace('-', '/', $_GET['startDate'])));
                                            }
                                            if(isset($_GET['endDate'])) {
                                                $endDate = date('Y-m-d', strtotime(str_replace('-', '/', $_GET['endDate'])));
                                            }
                                            if(isset($_GET['startDate']) && isset($_GET['endDate'])) {
                                                $result = pg_query("SELECT t.id, concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary  FROM task t, task_category c, client u WHERE t.category = c.id AND t.creator = u.id AND t.start_time >= '$startDate' AND t.end_time <= '$endDate'");
                                                $numcolumn = pg_num_fields($result);
                                                $results .= '<thead>';
                                                $results .= '<tr>';
                                                for($i=0; $i < $numcolumn; $i++) {
                                                    $column_name = pg_field_name($result, $i);
                                                    $results .= '<th>'.$column_name.'</th>';
                                                }
                                                $results .= '<th>Tools</th>';
                                                $results .= '</tr>';
                                                $results .= '</thead>';
                                                $tasksArray = array();
                                                while($line = pg_fetch_array($result,null,PGSQL_ASSOC)) {
                                                    array_push($tasksArray,$line);
                                                }

                                                pg_free_result($result);
                                                $myTasks = $tasksArray; 
                                            }
                                            else
                                                $myTasks = $taskManager->getClientTasks($client->id());


                                            $count = 0;  
                                            foreach ($myTasks as $task) {
                                                if($count % 2 == 0) $results .= '<tr class="odd">';
                                                else $results .= '<tr class="even">';
                                                $count++;
                                                foreach ($task as $column) {
                                                   $results .= '<td>' . $column . '</td>';
                                                }
                                                /*
                                                $results .= '<td>' . $task['category'] . '</td>';
                                                $results .= '<td>' . $task['name'] . '</td>';
                                                $results .= '<td>' . $task['location'] . '</td>';
                                                $results .= '<td>' . $task['description'] . '</td>';
                                                $results .= '<td class = "center">' . $task['salary'] . '</td>';
                                                $results .= '<td class = "center">' . $task['startdate'] . '</td>';
                                                $results .= '<td class = "center">' . $task['enddate'] . '</td>';
                                                */
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
                                    /*}
                                    else {
                                        header("Location: ./index.php");
                                    }
                                    */
                                    echo $results; 
                                    ?>                                   
                                </tbody>
                            </table>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
    
    <script src="vendor/datatables/js/jquery.dataTables.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        oTable = $('#dataTables-example').DataTable({
            responsive: true
        });

        $('#search_filter').keypress(function (e) {
         var key = e.which;
         if(key == 13)  // the enter key code
        {
            //ping sql database to get most recent results
            oTable.search($(this).val()).draw();
            return true
        }
        });   
    });
    </script>

</body>

</html>