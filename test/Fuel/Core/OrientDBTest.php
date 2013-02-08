<?php
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-07 at 03:55:02.
 */

use Fuel\Core\OrientDB\Query;
use Fuel\Core\PhpErrorException;
use Fuel\Core\OrientDB\NotSupportException;

class OrientDBTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var OrientDB
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
	}

	/**
	 * @covers Fuel\Core\OrientDB::get_manager
	 */
	public function testGet_manager()
	{
		$result = OrientDB::get_manager();
		$this->assertEquals(is_array($result), TRUE);
		$this->assertEquals(get_class($result["manager"]), "Doctrine\ODM\OrientDB\Manager");
		$this->assertEquals(get_class($result["binding"]), "Doctrine\OrientDB\Binding\HttpBinding");
		$this->assertEquals(get_class($result["mapper"]), "Doctrine\ODM\OrientDB\Mapper");
	}

	/**
	 * @covers Fuel\Core\OrientDB::last_query
	 * @todo   Implement testLast_query().
	 */
	public function testLast_query()
	{
		
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::query
	 */
	public function testQuery()
	{
		$result = OrientDB::query("SELECT a,b,c FROM OGraphVertex WHERE a=1 AND b='x' AND c='y'");
//		var_dump(get_class($result));
//		$this->assertEquals(is_a($result, "Doctrine\OrientDB\Query\Command"), TRUE);
//		$this->assertEquals($result->getTokenValue("Projections"), array('a', 'b', 'c'));
//		var_dump($result);
		$this->assertEquals(is_a($result, "Fuel\\Core\\Database_Query"), TRUE);
	}

	/**
	 * @covers Fuel\Core\OrientDB::error_info
	 * @todo   Implement testError_info().
	 */
	public function testError_info()
	{
		
//		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::select
	 */
	public function testSelect()
	{
		$result = OrientDB::select();
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Select");
		$this->assertEquals($result->getTokenValue("Projections"), array('*'));

		$result = OrientDB::select("test");
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Select");
		$this->assertEquals($result->getTokenValue("Projections"), array('test'));

		$result = OrientDB::select("test", "test2");
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Select");
		$this->assertEquals($result->getTokenValue("Projections"), array('test', 'test2'));

		$result = OrientDB::select(array("test", "test2"));
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Select");
		$this->assertEquals($result->getTokenValue("Projections"), array('test', 'test2'));
	}

	/**
	 * @covers Fuel\Core\OrientDB::select_array
	 */
	public function testSelect_array()
	{
		$result = OrientDB::select_array(array("test", "test2"));
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Select");
		$this->assertEquals($result->getTokenValue("Projections"), array('test', 'test2'));

		try {
			$result = OrientDB::select_array();
			$this->fail("Not occurs PhpErrorException");
		} catch (PhpErrorException $e) {
			// It's expected exception. Do nothing.
		} catch (Exception $e) {
			$name = get_class($e);
			$this->fail("Unexpected exception {$name}: {$e->getMessage()}");
		}
	}

	/**
	 * @covers Fuel\Core\OrientDB::insert
	 */
	public function testInsert()
	{
		$result = OrientDB::insert();
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Insert");
		$this->assertEquals($result->getTokenValue("Target"), array());

		$result = OrientDB::insert("table1");
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Insert");
		$this->assertEquals($result->getTokenValue("Target"), array("table1"));

		$result = OrientDB::insert("table2", array("column1", "column2"));
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Insert");
		$this->assertEquals($result->getTokenValue("Target"), array("table2"));
		$this->assertEquals($result->getTokenValue("Fields"), array("column1", "column2"));
	}

	/**
	 * @covers Fuel\Core\OrientDB::update
	 */
	public function testUpdate()
	{
		try {
			$result = OrientDB::update();
			$this->fail("Expected exception has not occured.");
		} catch (NotSupportException $e) {
			// It's expected exception. Do nothing.
		} catch (Exception $e) {
			$name = get_class($e);
			$this->fail("Unexpected exception {$name}: {$e->getMessage()}");
		}

		try {
			$result = OrientDB::update(123);
			$this->fail("Expected exception has not occured.");
		} catch (NotSupportException $e) {
			// It's expected exception. Do nothing.
		} catch (Exception $e) {
			$name = get_class($e);
			$this->fail("Unexpected exception {$name}: {$e->getMessage()}");
		}

		$result = OrientDB::update("table1");
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Update");
		$this->assertEquals($result->getTokenValue("Class"), array("table1"));

		$result = OrientDB::update(new NotSupportException());
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Update");
		$this->assertEquals($result->getTokenValue("Class"), array("NotSupportException"));

		$result = OrientDB::update("table1", array("column1" => "value1"));
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Update");
		$this->assertEquals($result->getTokenValue("Class"), array("table1"));
		$this->assertEquals($result->getTokenValue("Updates"), array("column1" => "value1"));
	}

	/**
	 * @covers Fuel\Core\OrientDB::delete
	 */
	public function testDelete()
	{
		try {
			$result = OrientDB::delete();
			$this->fail("Expected exception has not occured.");
		} catch (NotSupportException $e) {
			// It's expected exception. Do nothing.
		} catch (Exception $e) {
			$name = get_class($e);
			$this->fail("Unexpected exception {$name}: {$e->getMessage()}");
		}

		try {
			$result = OrientDB::delete(123);
			$this->fail("Expected exception has not occured.");
		} catch (NotSupportException $e) {
			// It's expected exception. Do nothing.
		} catch (Exception $e) {
			$name = get_class($e);
			$this->fail("Unexpected exception {$name}: {$e->getMessage()}");
		}

		$result = OrientDB::delete("table1");
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Delete");
		$this->assertEquals($result->getTokenValue("Class"), array("table1"));

		$result = OrientDB::delete(new NotSupportException());
		$this->assertEquals(get_class($result), "Doctrine\OrientDB\Query\Command\Delete");
		$this->assertEquals($result->getTokenValue("Class"), array("NotSupportException"));
	}

	/**
	 * @covers Fuel\Core\OrientDB::expr
	 * @todo   Implement testExpr().
	 */
	public function testExpr()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::quote
	 * @todo   Implement testQuote().
	 */
	public function testQuote()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::quote_identifier
	 * @todo   Implement testQuote_identifier().
	 */
	public function testQuote_identifier()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::quote_table
	 * @todo   Implement testQuote_table().
	 */
	public function testQuote_table()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::escape
	 * @todo   Implement testEscape().
	 */
	public function testEscape()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::table_prefix
	 * @todo   Implement testTable_prefix().
	 */
	public function testTable_prefix()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::list_columns
	 * @todo   Implement testList_columns().
	 */
	public function testList_columns()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::list_tables
	 * @todo   Implement testList_tables().
	 */
	public function testList_tables()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::datatype
	 * @todo   Implement testDatatype().
	 */
	public function testDatatype()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::count_records
	 * @todo   Implement testCount_records().
	 */
	public function testCount_records()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::count_last_query
	 * @todo   Implement testCount_last_query().
	 */
	public function testCount_last_query()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @covers Fuel\Core\OrientDB::set_charset
	 * @expectedException Fuel\Core\OrientDB\NotSupportException
	 */
	public function testSet_charset()
	{
		OrientDB::set_charset("utf8");
	}

	/**
	 * @covers Fuel\Core\OrientDB::in_transaction
	 * @expectedException Fuel\Core\OrientDB\NotSupportException
	 */
	public function testIn_transaction()
	{
		OrientDB::in_transaction();
	}

	/**
	 * @covers Fuel\Core\OrientDB::start_transaction
	 * @expectedException Fuel\Core\OrientDB\NotSupportException
	 */
	public function testStart_transaction()
	{
		OrientDB::start_transaction();
	}

	/**
	 * @covers Fuel\Core\OrientDB::commit_transaction
	 * @expectedException Fuel\Core\OrientDB\NotSupportException
	 */
	public function testCommit_transaction()
	{
		OrientDB::commit_transaction();
	}

	/**
	 * @covers Fuel\Core\OrientDB::rollback_transaction
	 * @expectedException Fuel\Core\OrientDB\NotSupportException
	 */
	public function testRollback_transaction()
	{
		OrientDB::rollback_transaction();
	}
}
