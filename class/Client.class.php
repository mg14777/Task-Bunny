<?php
class Client {
	private $_id;
	private $_email;
	private $_password;
	private $_level;
	
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
	
	public function id() { return $this->_id; }
	public function email() { return $this->_email; }
	public function password() { return $this->_password; }
	public function level() { return $this->_level; }
	
	public function setId($id) {
		$this->_id = (int) $id;	
	}
	
	public function setEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception('Invalid email');
		}
		$this->_email = $email;
	}
	
	public function setPassword($password) {
		if (!is_string($password)) throw new Exception('Invalid password');
		$this->_password = $password;
	}
	
	public function setLevel($level) {
		if ($level == 'admin') $this->_level = 'admin';
		else $this->_level = 'user';
	}
	
	public function __toString() {
		return '{ id : ' . $this->id() . '<br />  email : ' . $this->email() . '<br />  password : ' . $this->password() .'<br /> level : ' . $this->level() . ' }';
	}
}