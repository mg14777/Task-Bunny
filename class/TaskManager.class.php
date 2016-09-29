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
	
	public function getClientTasks($id) {
		$id = (int) $id;
		$result = pg_prepare($this->_db, '', "SELECT c.title AS category, to_char(t.start_time, 'YYYY/MM/DD') AS startdate, to_char(t.end_time, 'YYYY/MM/DD') AS enddate, t.location, t.description, t.salary FROM task t, task_category c WHERE c.id = t.category AND t.creator = $1");
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