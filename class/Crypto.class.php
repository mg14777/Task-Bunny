<?php
class Crypto {
	private static $key = '811e514b578965554873be16071ff5bc2688aa18'; //need a better solution
	
	public static function createHash($plainPassword) {
		if (!is_string($plainPassword) || strlen($plainPassword) < 8) {
			throw new Exception('Invalid Password');
		}
		
		$password = password_hash($plainPassword, PASSWORD_DEFAULT);
		if ($password == false) {
			throw new Exception('Problem happened while hashing');
		}
		
		return $password;
	}
	
	public static function verifyPassword($plainPassword, $hash) {
		if (!is_string($plainPassword) || !is_string($hash)) {
			return false;
		}
		
		return password_verify($plainPassword, $hash);
	}
	
	public static function generateRandomToken($length = 128){
		if(!isset($length) || intval($length) <= 128 ){
		  $length = 128;
		}
		if (function_exists('random_bytes')) {
			return bin2hex(random_bytes($length));
		}
		if (function_exists('mcrypt_create_iv')) {
			return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
		} 
		if (function_exists('openssl_random_pseudo_bytes')) {
			return bin2hex(openssl_random_pseudo_bytes($length));
		}
	}
	
	public static function mac($message) {
		return hash_hmac('sha256', $message, self::$key);
	}
	
	public static function compareHash($hash1, $hash2) {
		return hash_equals($hash1, $hash2);
	}
}