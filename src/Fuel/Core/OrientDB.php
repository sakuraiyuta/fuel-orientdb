<?php

namespace Fuel\Core;

use \Exception;
use Fuel\Core\OrientDB\Query as Query;
use Fuel\Core\OrientDB\NotSupportException as NotSupportException;

class OrientDB extends \Fuel\Core\DB
{
	public static function get_manager($db = NULL)
	{
		$connection = \Database_Connection::instance($db)->connection();
		return $connection;
	}

	public static function query($sql, $type = NULL)
	{
		//TODO: implement if possible
		throw new NotSupportException("this method is not supported.");
	}

	public static function error_info($db = NULL)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function select($columns = NULL)
	{
		$query = new Query();
		if (
			$columns
			and is_array($columns)
		)
		{
			return $query->select($columns);
		}
		elseif ( $columns )
		{
			return $query->select(func_get_args());
		}

		return $query->select(array('*'));
	}

	public static function select_array(array $columns = NULL)
	{
		$query = new Query();
		return $query->select($columns);
	}

	public static function insert($table = NULL, array $columns = NULL)
	{
		$query = new Query();
		$query = $query->insert();

		if ( $table )
		{
			$query->into($table);
		}

		if ( $columns )
		{
			$query->fields($columns);
		}

		return $query;
	}

	public static function update($table = NULL, array $values=NULL)
	{
		if ( ! $table )
		{
			throw new NotSupportException("UPDATE query needs table-name in OrientDB.");
		}

		if ( is_object($table) )
		{
			$full_ns_name = get_class($table);
			$ns_and_name = explode("\\", $full_ns_name);
			$table = array_pop($ns_and_name);
		}

		if ( ! is_string($table) )
		{
			$type = gettype($table);
			throw new NotSupportException("Not supported type: {$type}");
		}

		$query = new Query();
		$query = $query->update($table);

		if ( $values )
		{
			$query = $query->set($values);
		}

		return $query;
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

	public static function quote($string, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function quote_identifier($string, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function quote_table($string, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function escape($string, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public static function table_prefix($table = null, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	/**
	 * Lists all of the columns in a table. Optionally, a LIKE string can be
	 * used to search for specific fields.
	 *
	 *     // Get all columns from the "users" table
	 *     $columns = DB::list_columns('users');
	 *
	 *     // Get all name-related columns
	 *     $columns = DB::list_columns('users', '%name%');
	 *
	 * @param   string  table to get columns from
	 * @param   string  column to search for
	 * @param   string  the database connection to use
	 * @return  array
	 */
	public static function list_columns($table = null, $like = null, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	/**
	 * If a table name is given it will return the table name with the configured
	 * prefix.  If not, then just the prefix is returned
	 *
	 * @param   string  $table  the table name to prefix
	 * @param   string  $db     the database connection to use
	 * @return  string  the prefixed table name or the prefix
	 */
	public static function list_tables($like = null, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	/**
	 * Returns a normalized array describing the SQL data type
	 *
	 *     DB::datatype('char');
	 *
	 * @param   string  SQL data type
	 * @param   string  db connection
	 * @return  array
	 */
	public static function datatype($type, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

		/**
	 * Count the number of records in a table.
	 *
	 *     // Get the total number of records in the "users" table
	 *     $count = DB::count_records('users');
	 *
	 * @param   mixed    table name string or array(query, alias)
	 * @param   string  db connection
	 * @return  integer
	 */
	public static function count_records($table, $db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	/**
	 * Count the number of records in the last query, without LIMIT or OFFSET applied.
	 *
	 *     // Get the total number of records that match the last query
	 *     $count = $db->count_last_query();
	 *
	 * @param   string  db connection
	 * @return  integer
	 */
	public static function count_last_query($db = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	/**
	 * Set the connection character set. This is called automatically by [static::connect].
	 *
	 *     DB::set_charset('utf8');
	 *
	 * @throws  Database_Exception
	 * @param   string   character set name
	 * @param   string  db connection
	 * @return  void
	 */
	public static function set_charset($charset, $db = null)
	{
		throw new NotSupportException("this method is not supported.");
	}

	/**
	 * Checks whether a connection is in transaction.
	 *
	 *     DB::in_transaction();
	 *
	 * @param   string  db connection
	 * @return  bool
	 */
	public static function in_transaction($db = null)
	{
		throw new NotSupportException("this method is not supported.");
	}

	/**
	 * Begins a transaction on instance
	 *
	 *     DB::start_transaction();
	 *
	 * @param   string  db connection
	 * @return  bool
	 */
	public static function start_transaction($db = null)
	{
		throw new NotSupportException("this method is not supported.");
	}

	/**
	 * Commits all pending transactional queries
	 *
	 *     DB::commit_transaction();
	 *
	 * @param   string  db connection
	 * @return  bool
	 */
	public static function commit_transaction($db = null)
	{
		throw new NotSupportException("this method is not supported.");
	}

	/**
	 * Rollsback all pending transactional queries
	 *
	 *     DB::rollback_transaction();
	 *
	 * @param   string  db connection
	 * @return  bool
	 */
	public static function rollback_transaction($db = null)
	{
		throw new NotSupportException("this method is not supported.");
	}
}

