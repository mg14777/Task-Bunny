<?php
class TaskManager {
	private $_db;
	
	public function __construct($db) {
		$this->setDb($db);
	}
	
	public function addTask(Task $task) {
		$result = pg_prepare($this->_db, "", 'INSERT INTO task (creator, category, start_time, end_time, location, description, salary) VALUES ($1, $2, $3, $4, $5, $6, $7)');
		$result = pg_execute($this->_db, "", array(
			$task->creator(),
            $task->category(),
            $task->startDate(),
            $task->endDate(),
            $task->location(),
            $task->description(),
            $task->salary())) or die('Query failed: ' . pg_last_error($this->_db));
		pg_free_result($result);
	}
    
    public function editTask($id, Task $task) {
        $result = pg_prepare($this->_db, "", 'UPDATE task SET category = $1, start_time = $2, end_time = $3, location = $4, description = $5, salary = $6 WHERE creator = $7 AND id = $8');
        $result = pg_execute($this->_db, "", array(
            $task->category(),
            $task->startDate(),
            $task->endDate(),
            $task->location(),
            $task->description(),
            $task->salary(),
            $task->creator(),
            $id)) or die('Query failed: ' . pg_last_error($this->_db));
        pg_free_result($result);
    }
    
    public function editTaskAdmin($id, Task $task) {
        $result = pg_prepare($this->_db, "", 'UPDATE task SET category = $1, start_time = $2, end_time = $3, location = $4, description = $5, salary = $6 WHERE id = $7');
        $result = pg_execute($this->_db, "", array(
            $task->category(),
            $task->startDate(),
            $task->endDate(),
            $task->location(),
            $task->description(),
            $task->salary(),
            $id)) or die('Query failed: ' . pg_last_error($this->_db));
        pg_free_result($result);
    }
    
    public function deleteTask ($id, $creator) {
         $result = pg_prepare($this->_db, "", 'DELETE FROM task WHERE creator = $1 AND id = $2');
         $result = pg_execute($this->_db, "", array(
            $creator,
            $id)) or die('Query failed: ' . pg_last_error($this->_db));
         pg_free_result($result);          
    }
    
    public function deleteTaskAdmin ($id) {
         $result = pg_prepare($this->_db, "", 'DELETE FROM task WHERE id = $1');
         $result = pg_execute($this->_db, "", array($id)) or die('Query failed: ' . pg_last_error($this->_db));
         pg_free_result($result);          
    }
	
	public function getClientTasks($id) {
		$id = (int) $id;
		$result = pg_prepare($this->_db, '', "SELECT t.id, concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary FROM task t, task_category c, client u WHERE c.id = t.category AND t.creator = u.id AND t.creator = $1 ORDER BY t.id");
		$result = pg_execute($this->_db, '', array($id)) or die('Query failed: ' . pg_last_error($this->_db));
		
		$tasksArray = array();
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
            array_push($tasksArray, $line);
        }
		pg_free_result($result);
		
		return $tasksArray;
	}
    
    public function getAllTasksAdmin() {
		$result = pg_prepare($this->_db, '', "SELECT t.id, concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary FROM task t, task_category c, client u WHERE c.id = t.category AND t.creator = u.id ORDER BY t.id");
		$result = pg_execute($this->_db, '', array()) or die('Query failed: ' . pg_last_error($this->_db));
		
		$tasksArray = array();
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
            array_push($tasksArray, $line);
        }
		pg_free_result($result);
		
		return $tasksArray;
	}
    
    public function getTaskInfo($id, $creator) {
        $id = (int) $id;
        $result = pg_prepare($this->_db, '', "SELECT t.id,  concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary::money::numeric::float8 AS salary FROM task t, task_category c, client u WHERE c.id = t.category AND t.creator = u.id AND t.creator = $1 AND t.id = $2");
		$result = pg_execute($this->_db, '', array($creator, $id)) or die('Query failed: ' . pg_last_error($this->_db));
        
        $tasksArray = array();
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
            array_push($tasksArray, $line);
        }
		pg_free_result($result);
		
		return $tasksArray;
    }
    
    public function getTaskInfoAdmin($id) {
        $id = (int) $id;
        $result = pg_prepare($this->_db, '', "SELECT t.id,  concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary::money::numeric::float8 AS salary FROM task t, task_category c, client u WHERE c.id = t.category AND t.creator = u.id AND t.id = $1");
		$result = pg_execute($this->_db, '', array($id)) or die('Query failed: ' . pg_last_error($this->_db));
        
        $tasksArray = array();
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
            array_push($tasksArray, $line);
        }
		pg_free_result($result);
		
		return $tasksArray;
    }
    
    public function getAvailableTasks($id) {
		$id = (int) $id;
		$result = pg_prepare($this->_db, '', "SELECT t.id, t.creator, concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary 
        FROM task t, task_category c, client u
        WHERE c.id = t.category AND t.creator = u.id AND t.creator <> $1 AND NOT EXISTS (
        SELECT * FROM tasker t2 WHERE t2.task_id = t.id)");
		$result = pg_execute($this->_db, '', array($id)) or die('Query failed: ' . pg_last_error($this->_db));
		
		$tasksArray = array();
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
            array_push($tasksArray, $line);
        }
		pg_free_result($result);
		
		return $tasksArray;
	}
    
    public function getHelperTasks($id) {
		$id = (int) $id;
		$result = pg_prepare($this->_db, '', "SELECT t.id, t.creator, concat_ws(' ', u.firstname, u.lastname) AS name, c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary 
        FROM task t, task_category c, client u, tasker t2
        WHERE c.id = t.category AND t.creator = u.id AND t2.helper = $1 AND t2.task_id = t.id");
		$result = pg_execute($this->_db, '', array($id)) or die('Query failed: ' . pg_last_error($this->_db));
		
		$tasksArray = array();
        while($line = pg_fetch_array($result, null, PGSQL_ASSOC)){
            array_push($tasksArray, $line);
        }
		pg_free_result($result);
		
		return $tasksArray;
	}
    
	
	public function setDb($db) {
		$this->_db = $db;
	}
}