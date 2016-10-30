<?php
class Task {
	private $_description;
	private $_creator;
	private $_startDate;
    private $_startTime;
	private $_endDate;
    private $_endTime;
	private $_category;
	private $_location;
    private $_salary;
	
	public function __construct() {
	}
	
	public function description() { return $this->_description; }
	public function creator() { return $this->_creator; }
	public function startDate() { return $this->_startDate; }
    public function startTime() { return $this->_startTime; }
	public function endDate() { return $this->_endDate; }
    public function endTime() { return $this->_endTime; }
	public function category() { return $this->_category; }
	public function location() { return $this->_location; }
    public function salary() { return $this->_salary; }
	
	public function setDescription($description) {
		$this->_description = $description;	
	}
	
	public function setCreator($creator) {
		$this->_creator = $creator;
	}
	
	public function setStartDate($startDate) {
        if((!is_null($this->_endDate) && $startDate > $this->_endDate) || !$this->isValidDate($startDate)) throw new Exception('Invalid Date');
		$this->_startDate = $startDate;
	}
    
    public function setStartTime($startTime) {
        if((!is_null($this->_startDate) && !is_null($this->_endDate) && !is_null($this->_endTime) && $this->_startDate == $this->_endDate && $startTime > $this->_endTime) || !$this->isValidTime($startTime)) throw new Exception('Invalid Time');
		$this->_startTime = $startTime;
	}
	
	public function setEndDate($endDate) {
        if((!is_null($this->_startDate) && $this->_startDate > $endDate) || !$this->isValidDate($endDate)) throw new Exception('Invalid Date');
		$this->_endDate = $endDate;
	}
    
	public function setEndTime($endTime) {
        if((!is_null($this->_startDate) && !is_null($this->_endDate) && !is_null($this->_startTime) && $this->_startDate == $this->_endDate && $this->_startTime > $endTime) || !$this->isValidTime($endTime)) throw new Exception('Invalid Time');
		$this->_endTime = $endTime;
	}
	
	public function setCategory($category) {
         if(!is_numeric($category) || $category < 0) throw new Exception('Please select a category.');
		$this->_category = $category;
	}
	
	public function setLocation($location) {
		$this->_location = $location;
	}
	
    public function setSalary($salary) {
        if(!is_numeric($salary)) throw new Exception('Renumeration is not a number.');
		$this->_salary = $salary;
	}
    
    private function isValidDate($date) {
        $pieces = explode("/", $date);
        return checkdate($pieces[1], $pieces[2], $pieces[0]);
    }
    
    private function isValidTime($time) {
        return strlen($time) == 4 && substr($time, 0, 2) < "24" && substr($time, 0, 2) >= "00" && substr($time, -2) < "60" && substr($time, -2) >= "00";
    }
}