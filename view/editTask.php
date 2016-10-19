<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Task Bunny</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/datepicker/css/datepicker.css" rel="stylesheet">

    <!-- Custom CSS -->

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="index.php">Task Bunny</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href=<?php if(isset($_GET['admin'])) {?>"tablesAdmin.php"<?php } else { ?>"dashboard.php"<?php } ?>>Return to Task List</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	<?php include('flagHandler.php') ?>
    <div class="container">
      <h2>Edit Task</h2>
      <form method ="post" class="form-horizontal">
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Task Description:</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="description" name="description" placeholder="Write something about your task." value =<?php echo $task[0]['description']?>>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="loc">Location:</label>
          <div class="col-sm-10">          
            <input type="text" class="form-control" id="location" name="location" placeholder="Where will it be held?" value =<?php echo $task[0]['location']?>>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="cat">Category:</label>
          <div class="col-sm-10">          
            <input type="text" class="form-control" id="category" name="category" placeholder="???" value =<?php echo $task[0]['category']?>>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="start">Start Date:</label>
          <div class="col-sm-4">          
            <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Choose task start date" value =<?php echo $task[0]['startdate']?>>
          </div>
          <label class="control-label col-sm-2" for="end">End Date:</label>
          <div class="col-sm-4">          
            <input type="text" class="form-control" id="endDate" name="endDate" placeholder="Choose task end date" value =<?php echo $task[0]['enddate']?>>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="sal">Remuneration (if any):</label>
          <div class="col-sm-4">          
            <input type="text" class="form-control" id="salary" name="salary" min='0' value =<?php echo $task[0]['salary']?>>
          </div>
        </div>
        <div class="form-group">        
          <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">Edit Task</button>
          </div>
        </div>
      </form>
    </div>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
    <script src="vendor/datepicker/js/bootstrap-datepicker.js"></script>
    
<script>

    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
     
    var startDateInst = $('#startDate').datepicker({
        format: 'yyyy/mm/dd',
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
      if (ev.date.valueOf() > endDateInst.date.valueOf()) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate());
        endDateInst.setValue(newDate);
      }
      startDateInst.hide();
      $('#endDate')[0].focus();
    }).data('datepicker');
    
    var endDateInst = $('#endDate').datepicker({
        format: 'yyyy/mm/dd',
        onRender: function(date) {
            return date.valueOf() < startDateInst.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
      endDateInst.hide();
    }).data('datepicker');
    
</script>
</body>
</html>