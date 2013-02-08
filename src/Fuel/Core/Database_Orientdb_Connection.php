<?php

namespace Fuel\Core;

use \Exception;
use Doctrine\OrientDB\Binding\BindingParameters;
use Doctrine\OrientDB\Binding\HttpBinding;
use Doctrine\OrientDB\Query\Query;
use Doctrine\OrientDB\Query\Validator\Escaper;
use Doctrine\ODM\OrientDB\Manager;
use Doctrine\ODM\OrientDB\Mapper;
use Doctrine\ODM\OrientDB\Mapper\Annotations\Reader;
use Doctrine\Common\Cache\ArrayCache;

class Database_Orientdb_Connection extends \Fuel\Core\Database_Connection
{

	/**
	 * @var  string  OrientDB identifiers
	 */
	protected $_identifier = '';

	protected $_escaper;

	protected function __construct($name, array $config)
	{
		parent::__construct($name, $config);
		$this->_escaper = new Escaper();
	}

	public function connect()
	{
		if ($this->_connection)
		{
			return;
		}

		// parse dsn
		$config = $this->_config['connection'];
		$dsn = $this->_config["connection"]["dsn"];
		$dsn_temp = explode(':', $dsn);
		$this->_db_type = $dsn_temp[0];
		foreach ( explode(';', $dsn_temp[1]) as $row )
		{
			$row_temp = explode('=', $row);
			$config[$row_temp[0]] = $row_temp[1];
		}

		// regist namespace-path mapping to fuel as PSR-0 so Symfony\Finder can't find entities normally.
		$proxy_dir = APPPATH . "vendor" . DS . "sakuraiyuta" . DS . "fuel-orientdb" . DS . "tmp" . DS;
		$entity_dir = (isset($this->_config["entity_dir"]))
			? $this->_config["entity_dir"]
			: APPPATH . "classes" . DS . "Entity" . DS;
		\Autoloader::add_namespace("Doctrine", $proxy_dir . DS . "/Doctrine" . DS, TRUE);
		\Autoloader::add_namespace("Entity", $entity_dir, TRUE);

		// initialize ODM-Manager
		$parameters = BindingParameters::create(
			"http://{$config['username']}:{$config['password']}@{$config['host']}:{$config['port']}/{$config['dbname']}"
		);
		$binding = new HttpBinding($parameters);
		$reader = new Reader(new ArrayCache());
		$mapper = new Mapper($proxy_dir, $reader);
		$mapper->setDocumentDirectories(
			array($entity_dir => "Entity")
		);

		$manager = new Manager($mapper, $binding);

		// Prevent this information from showing up in traces
		unset($config['username'], $config['password']);

		$this->_connection = array(
			"manager" => $manager,
			"binding" => $binding,
			"mapper" => $mapper,
		);

		return $this->_connection;
	}

	public function disconnect()
	{
		if ( $this->_connection )
		{
			unset($this->_connection);
		}

		return TRUE;
	}

	public function set_charset($charset)
	{
		throw new Exception("this method is not supported.");
	}

	public function query($type, $sql, $as_object)
	{
		if ( is_string($type) )
		{
			$type = constant("\DB::{$type}");
		}
		elseif ( ! is_int($type) )
		{
			throw new Exception("Unknown type {$type}.");
		}

		if ( ! $this->_connection )
		{
			$this->connect();
		}

		if ( ! empty($this->_config['profiling']))
		{
			// Benchmark this query for the current instance
			$benchmark = \Profiler::start("Database ({$this->_instance})", $sql);
		}

		// Execute the query
		try {
			if ( $sql instanceof Query )
			{
				$result = $this->_connection["manager"]->execute($sql);
			}
			else
			{
				$result = $this->_connection["binding"]->query($sql);
			}
		} catch (Exception $e) {
			if (isset($benchmark))
			{
				// This benchmark is worthless
				\Profiler::delete($benchmark);
			}

			throw $e;
		}

		if (isset($benchmark))
		{
			\Profiler::stop($benchmark);
		}

		// Set the last query
		$this->last_query = $sql;

		if ($type === \DB::SELECT)
		{
			if ( is_object($result) )
			{
				return $result->getResult();
			}

			return $result;
		}
		elseif ($type === \DB::INSERT)
		{
			return $result;
			//TODO: implement when inserts record
//			throw new Exception("not implemented yet.");
//			// Return a list of insert id and rows created
//			return array(
//				$this->_connection->insert_id,
//				$this->_connection->affected_rows,
//			);
		}
		else
		{
			//TODO implement returning affected rows
			throw new Exception("not implemented yet.");
			// Return the number of rows affected
//			return $this->_connection->affected_rows;
		}
	}

	public function list_tables($like = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public function list_columns($table, $like = null)
	{
		//TODO: implement
		throw new Exception("not implemented yet.");
	}

	public function escape($value)
	{
		return $this->_escaper->check($value);
	}

	public function in_transaction()
	{
		throw new Exception("this method is not supported.");
	}

	public function start_transaction()
	{
		throw new Exception("this method is not supported.");
	}

	public function commit_transaction()
	{
		throw new Exception("this method is not supported.");
	}

	public function rollback_transaction()
	{
		throw new Exception("this method is not supported.");
	}
}
