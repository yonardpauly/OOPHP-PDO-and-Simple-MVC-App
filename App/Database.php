<?php

class Database
{
	private static $servername = "localhost";
	private static $charset = "utf8mb4";	
	private static $username = "root";
	private static $dbname = "bongco";
	private static $dbType = "mysql";	
	private static $password = "eurobet";
# =================================================================================
	private static function connect() {

		$dsn = self::$dbType .":host=". self::$servername .";dbname=". self::$dbname .";charset=". self::$charset;
		$attribs = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
			PDO::ATTR_EMULATE_PREPARES => false
		];
		try {

			$pdo = new PDO ( $dsn, self::$username, self::$password, $attribs );
			return $pdo;

		} catch ( PDOException $e ) { $e->getMessage(); }
	}
# =================================================================================
	protected static function query( $query, $params = array() ) {

		try {
			
			$stmt = self::connect()->prepare( $query );
			$stmt->execute( $params );
			return $stmt;
			
		} catch ( PDOException $e ) { $e->getMessage(); }
	}
}