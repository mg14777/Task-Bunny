<?php
class DBFactory {
	public static function getPgsqlConnexion() {
		$db = pg_connect("host=localhost port=5432 dbname=CS2102 user=postgres password=12341234")
			or die('Could not connect: ' . pg_last_error());
		
		return $db;
	}
}