<?php

namespace App\Db;

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

	public static function lastInsertID() {
		$conn = static::getConnect();
		return mysqli_insert_id($conn);
	}

	public static function fetchAll(string $query): array 
	{
		$request = static::query($query); 

		$result = [];

		while ($row = static::fetchAssoc($request)) {
			$result[] = $row;
		}

		return $result;
	}

	public static function fetchAssoc($result): ?array
	{
		return mysqli_fetch_assoc($result);
	}

	public static function fetchOne(string $query): string 
	{
		$request = Db::query($query); 

		$row = mysqli_fetch_row($request);

		return (string) ($row[0] ?? 0);	
	}

	public static function fetchRow(string $query): array 
	{
		$request = Db::query($query);

		$result = mysqli_fetch_assoc($request);

		if (is_null($result)) {
			return [];
		}

		return $result;
	}

	public static function delete(string $table, string $where) {
		$query = "DELETE FROM " . $table;

		if ($where) {
			$query .= ' WHERE ' . $where;
		}

		$request = Db::query($query);

		return static::affectedRows();
	}

	public static function update(string $table, array $fields, string $where) {

		$set_fields = [];

		foreach ($fields as $key => $value) {
			if ($value instanceof DbExp) {
				$set_fields[] = "`$key` = $value";
			} else {
				$set_fields[] = "`$key` = '$value'";
			}
		}

		$set_fields = implode(", ", $set_fields);

		$query = "UPDATE " . $table ." SET " . $set_fields;

		if ($where) {
			$query .= ' WHERE ' . $where;
		}

		Db::query($query);

		return static::affectedRows();
	}

	public static function insert(string $table, array $fields) {

		$fieldsName = [];
		$fieldsValue = [];

		foreach ($fields as $key => $value) {
			$fieldsName[] = "`$key`";
			if ($value instanceof DbExp) {
				$fieldsValue[] = "$value";
			} else {
				$fieldsValue[] = "'$value'";
			}
		}

		$fieldsName = implode(', ', $fieldsName);
		$fieldsValue = implode(', ', $fieldsValue);

		$query = "INSERT INTO " . $table ." ($fieldsName) VALUES ($fieldsValue)";

		Db::query($query);

		return static::lastInsertID();
	}

	public static function escape(string $value) {
        $connect = static::getConnect();
	    return mysqli_real_escape_string($connect, $value);
    }

	public static function expr(string $value) {
		return new DbExp($value);
	}

}