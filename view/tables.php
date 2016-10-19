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
    <?php include('flagHandler.php') ?>

    <div id="wrapper">

        <div id="page-wrapper">
            <div class="row">
                <nav class="nav">
                    <a href="./dashboard.php"><button class="btn btn-link">My tasks</button></a>
                    <a href="./availableTask.php"><button class="btn btn-link">Available tasks</button></a>
                    <a href="./helperTask.php"><button class="btn btn-link">Tasks I'm helping</button></a>
                    <?php if($client->level() == 'admin') { ?>
                        <a href="./tablesAdmin.php"><button class="btn btn-link">Task Administration</button></a>
                    <?php } ?>
                    <a href="./logout.php"><button class="btn btn-link navbar-right">Log out</button></a>

                </nav>
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $title ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            <div class="row" id="search_row">
                <?php if (isset($addButton)) { ?>
                    <div class="col-md-3">
                        <a href="addTask.php"><button class="btn btn-default" type="button">Add Task</button></a>
                    </div>
                <?php } else {?>
                    <div class="col-md-3"></div>
                <?php }?>
                <div class="col-md-6">
                </div>
                <div class="col-md-3">
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
                                <thead>
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
                                <tbody>
                
                                <?php echo $results; ?>             

                                    
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