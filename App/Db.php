<?php 

class Db {

	private static $connect;

	private static $host = 'localhost';
	private static $user = 'root';
	private static $password = 'password';
	private static $database = 'shop';

	public static function getConnect() {
		if (is_null(static::$connect)) {
			static::$connect = static::connect();
		}

		return static::$connect;
	}

	private static function connect() {
		$connect = mysqli_connect(static::$host, static::$user, static::$password, static::$database);

		if( mysqli_connect_errno() ) {

			var_dump(mysqli_connect_error());

			exit;
		}

		mysqli_set_charset($connect, 'utf8');

		return $connect;
	}

	public static function query($query) {
		$conn = static::getConnect();
		$result = mysqli_query($conn, $query);

		if (mysqli_errno($conn)) {
			var_dump(mysqli_error($conn));
			exit;
		}

		return $result;
	}

	public static function affectedRows() {
		$conn = static::getConnect();
		return mysqli_affected_rows($conn);
	}
}