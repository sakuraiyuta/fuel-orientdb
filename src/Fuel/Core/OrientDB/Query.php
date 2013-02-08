<?php

namespace Fuel\Core\OrientDB;

use \PHPSQLParser;
use \Fuel\Core\OrientDB;

class Query extends \Doctrine\OrientDB\Query\Query
{
	public function execute($db=NULL)
	{
		if ( ! $db )
		{
			$db = OrientDB::get_manager();
		}
		$return = $db->execute($this);

		return $return;
	}

	public function set(array $pairs)
	{
		$this->fields(array_keys($pairs));
		$this->values(array_values($pairs));

		return $this->command;
	}

	public function parse_sql($sql)
	{
		$this->parser = new PHPSQLParser($sql, TRUE);
		$this->_build_query($this->parser->parsed);

		return $this->command;
	}

	protected function _build_query($entities, &$args=array())
	{
		foreach ($entities as $method => $details)
		{
			if ( is_string($method) )
			{
				$method = strtolower($method);
				$self_args = array();
				$this->_build_query($details, $self_args);
				if ( $method == "where" ) var_dump($details);
				$this->command->$method($self_args);
			}
			elseif ( is_array($details) )
			{
				if ( count($args) )
				{
					$args[count($args)-1] .= " {$details["base_expr"]}";
				}
				else
				{
					$args[] = $details["base_expr"];
				}

				if ( $details["sub_tree"] )
				{
					$this->_build_query($details, $args);
				}
			}
		}
	}
}

