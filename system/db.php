<?php
include 'Medoo.php';

// Using Medoo namespace
use Medoo\Medoo;

class DB
{
	protected static $database;

	public static function init()
	{
		self::$database = new Medoo(array(
			'database_type' => Config::db_type,
			'server' => Config::db_server,
			'database_name' => Config::db_name,
			'username' => Config::db_username,
			'password' => Config::db_password,
			'port' => Config::db_port,
			'charset' => 'utf8'
			
		));

		self::$database->query("SET time_zone='+07:00'");

		return self::$database;
	}

	public static function select($table, $columns = null, $where = null)
	{
		$result = self::$database->select($table, $columns, $where);
		return $result;
	}	

    public static function selectcomplex($query)
    {
        $result = self::$database->query($query)->fetchAll();
		return $result;
    }

	public static function insert($table, $data)
	{
		$result = self::$database->insert($table, $data);
		$result = self::isError() ? false : self::$database->id();
		return $result;
	}

	public static function insertId()
	{
		return self::$database->id();
	}

	public static function update($table, $data, $where)
	{

		$result = self::$database->update($table, $data, $where);
		$is_error = self::isError();
		$is_error = $is_error ? false : true;
		return $is_error;
	}

	public static function delete($table, $where = null)
	{
		$result = self::$database->delete($table, $where);
		$is_error = self::isError();
		$is_error = $is_error ? false : true;
		return $is_error;
	}

	public static function get($table, $columns, $where)
	{
		$result = self::$database->get($table, $columns, $where);
		return $result;
	}

	public static function has($table, $where)
	{
		$result = self::$database->has($table, $where);
		return $result;
	}

	public static function count($table, $where = null)
	{
		$result = self::$database->count($table, $where);
		return $result;
	}

	public static function max($table, $columns, $where)
	{
		$result = self::$database->max($table, $columns, $where);
		return $result;
	}

	public static function min($table, $columns, $where)
	{
		$result = self::$database->min($table, $columns, $where);
		return $result;
	}

	public static function avg($table, $columns, $where)
	{
		$result = self::$database->avg($table, $columns, $where);
		return $result;
	}

	public static function sum($table, $columns, $where)
	{
		$result = self::$database->sum($table, $columns, $where);
		return $result;
	}

	public static function query($query)
	{
		$result = self::$database->query($query);
		return $result;
	}


	public static function isError()
	{
		$ret = false;
		$error = self::$database->error();
		if ($error[1] != '' || $error[2] != '') {
			$ret = true;
		}
		return $ret;
	}

	public static function error()
	{
		return self::$database->error();
	}

	public static function lastQuery()
	{
		return self::$database->last();
	}
}

DB::init();
