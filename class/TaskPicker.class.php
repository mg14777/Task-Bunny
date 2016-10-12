<?php
class TaskPicker {
    private $_db;
    private $_taskerManager;
	
	public function __construct($db) {
		$this->setDb($db);
        $this->_taskerManager = new TaskerManager($db);
	}
    
    public function pick(Client $client, $task) {
        if ($this->checkOwnership($client, $task)) throw new Exception("Cannot pick own task");
        if (!$this->checkAvailability($client, $task)) throw new Exception("You already have some task on that time slot");
        $data = array("helper" => $client->id(), "taskId" => $task['id']);
        $this->_taskerManager->insert(new Tasker($data));
    }
    
    private function checkOwnership(Client $client, $task) {
        return $client->id() == $task['creator'];   
    }
    
    private function checkAvailability(Client $client, $task) {
        $query = 'SELECT * FROM tasker t1, task t2
            WHERE t1.helper = $1 AND t1.task_id = t2.id AND
            ((t2.start_time >= $2 AND t2.start_time <= $3) OR
            (t2.end_time >= $2 AND t2.end_time <= $3) OR
            (t2.start_time <= $2 AND t2.end_time >= $3))';
        $result = pg_prepare($this->_db, "", $query);
		$result = pg_execute($this->_db, "", array($client->id(), $task['startDate'], $task['endDate']));
        return pg_num_rows($result) == 0;
    }
    
    public function setDb($db) {
		$this->_db = $db;
	}
}