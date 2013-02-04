<?php

use Doctrine\OrientDB\Query\Query;

class OrientDB extends Fuel\Core\DB
{
	public static function query($sql, $type = NULL)
	{
		//TODO: implement if possible
		throw new Exception("this method is not supported.");
	}

	public static function error_info($db = NULL)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function select($columns = NULL)
	{
		$query = new Query();
		return $query->select(func_get_args());
	}

	public static function select_array(array $columns = NULL)
	{
		$query = new Query();
		return $query->select($columns);
	}

	public static function insert($table = NULL, array $columns = NULL)
	{
		$query = new Query();
		$query->insert();

		if ( $table )
		{
			$query = $query->into($table);
		}

		if ( $columns )
		{
			$query->fields($columns);
		}

		return $query;
	}

	public static function update($table = NULL)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function delete($table = NULL)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function expr($string)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}
}
