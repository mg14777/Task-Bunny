<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Available Tasks</title>
</head>
<body>
    <?php include("init.php");?>
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
		<input type="text" id="startDate" name="startDate" placeholder="Start Date">
		<input type="text" id="endDate" name="endDate" placeholder="End Date"><br><br>
		<input type="submit" value="Filter"/>
	</form>
    <h2>Statistics</h2>

        <form action="./userFilter.php" method="GET">
            <h3>Number of tasks per group (Group By)</h3>
            <select name='group_criteria'>
                        <option value="" disabled selected>Group By</option>
                        <option value="task_category">Task Category</option>
            </select>
            <input type="submit" value="Count"/>
        </form>
        <form action="./userFilter.php" method="GET">
            <h3>Tasks with certain location pattern (Like)</h3>
            <input type="text" id="location" name="location" placeholder="Location">
            <input type="submit" value="Find"/>
        </form>
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
        <form action="./userFilter.php" method="GET">
            <h3>Tasks with max or min salary (ALL)</h3>
            <select name='max_or_min'>
                        <option value="max">Max</option>
                        <option value="min">Min</option>
            </select>
            <input type="submit" value="Find"/>
        </form>
</body>
</html>