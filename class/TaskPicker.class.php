<?php
class TaskPicker {
    private $_db;
	
	public function __construct($db) {
		$this->setDb($db);
	}
    
    public function pick(Client $client, Task $task) {
        if ($this->checkOwnership($client, $task)) throw new Exception("Cannot pick own task");
        if (!$this->checkAvailability($client, $task)) throw new Exception("You already have some task on that time slot");
        
    }
    
    private function checkOwnership(Client $client, Task $task) {
        return $client->id == $task->owner;   
    }
    
    private function checkAvailability(Client $client, Task $task) {
        return true;
    }
    
    public function setDb($db) {
		$this->_db = $db;
	}
}