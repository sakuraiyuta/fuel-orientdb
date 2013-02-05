<?php

namespace Fuel\Core\OrientDB;

use \Fuel\Core\OrientDB;

class Query extends \Doctrine\OrientDB\Query\Query
{
	public function execute()
	{
		$manager = OrientDB::get_manager();
		$return = $manager->execute($this);
		return $return;
	}

	public function set(array $pairs)
	{
		$this->fields(array_keys($pairs));
		$this->values(array_values($pairs));

		return $this;
	}
}

