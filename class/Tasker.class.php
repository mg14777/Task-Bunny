<?php
class Tasker {
	private $_helper;
	private $_taskId;
	
	public function __construct(array $data) {
		$this->hydrate($data);
	}
	
	public function hydrate(array $data) {
	  foreach ($data as $key => $value) {
		$method = 'set'.ucfirst($key);

		if (method_exists($this, $method)) {
		  $this->$method($value);
		}
	  }
	}
	
	public function helper() { return $this->_helper; }
	public function taskId() { return $this->_taskId; }
	
	public function setHelper($id) {
		$this->_helper = (int) $id;	
	}
	
	public function setTaskId($id) {
		$this->_taskId = (int) $id;	
	}
	
	public function __toString() {
		return '{ helper : ' . $this->helper() . '<br />  task_id : ' . $this->taskId() . ' }';
	}
}