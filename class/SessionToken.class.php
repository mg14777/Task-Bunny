<?php
class SessionToken {
	private $_client_id;
	private $_token;
	
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
	
	public function client_id() { return $this->_client_id; }
	public function token() { return $this->_token; }
	
	public function setClient_id($id) {
		$this->_client_id = (int) $id;	
	}
	
	public function setToken($token) {
		if (!is_string($token)) throw new Exception('Invalid token');
		$this->_token = $token;
	}
	
	public function __toString() {
		return '{ client_id : ' . $this->client_id() . '<br />  token : ' . $this->token() . ' }';
	}
}