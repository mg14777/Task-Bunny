<?php
class TaskerManager {
	private $_db;
	
	public function __construct($db) {
		$this->setDb($db);
	}
	
	public function getForHelper($id) {
		return $this->get_helper($id, 'helper');
	}
	
	public function getForTask($id) {
		return $this->get_helper($id, 'task_id');
	}
	
	public function insert(Tasker $tasker) {
		$result = pg_prepare($this->_db, "", 'INSERT INTO tasker VALUES ($1, $2)');
		$result = pg_execute($this->_db, "", array(
			$tasker->helper(),
            $tasker->taskId())) or die('Query failed: ' . pg_last_error($this->_db));
		pg_free_result($result);
	}
	
	private function get_helper($id, $string) {
		$id = (int) $id;
		$result = pg_prepare($this->_db, '', 'SELECT helper, task_id AS taskId FROM tasker WHERE ' . $string . ' = $1');
		$result = pg_execute($this->_db, '', array($id)) or die('Query failed: ' . pg_last_error($this->_db));
		
		$array = array();
		while ($row = pg_fetch_array($result, null, PGSQL_ASSOC)) {
			$array[] = new Tasker($row);
		}
		pg_free_result($result);
		
		return $array;
	}
	
    public function getCountHelperFor($id) {
        $id = (int) $id;
        $result = pg_prepare($this->_db, '', 'SELECT COUNT(*) FROM tasker WHERE task_id = $1');
		$result = pg_execute($this->_db, '', array($id)) or die('Query failed: ' . pg_last_error($this->_db));
        
        return pg_fetch_result($result, 0, 0);
    }
    
	public function setDb($db) {
		$this->_db = $db;
	}
	
}