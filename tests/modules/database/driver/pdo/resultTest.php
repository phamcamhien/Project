<?php

require_once('/../../../../../modules/database/classes/database/result.php');
require_once('/../../../../../modules/database/classes/driver/pdo/result.php');

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-02-06 at 20:48:50.
 */
class Result_PDO_DriverTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Result_PDO_Driver
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$db = new PDO('sqlite::memory:');
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->exec("CREATE TABLE fairies(id INT,name VARCHAR(255))");

		$db->exec("INSERT INTO fairies (id,name) VALUES (1,'Tinkerbell')");
		$db->exec("INSERT INTO fairies (id,name) VALUES (2,'Trixie')");

		$q = $db->prepare("SELECT * from fairies");
		$q->execute();

		$this->object = new Result_PDO_Driver($q);
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{

	}

	/**
	 * @covers Result_PDO_Driver::rewind
	 * @todo   Implement testRewind().
	 */
	public function testRewind()
	{
		$except = false;
		$this->object->valid();
		$this->object->rewind();
		$this->object->next();
		try {
			$this->object->rewind();
		} catch (Exception $e) {
			$except = true;
		}
		$this->assertEquals(true, $except);
	}

	/**
	 * @covers Result_PDO_Driver::current
	 */
	public function testCurrent()
	{
		$this->assertEquals($this->object->current()->name, 'Tinkerbell');
	}

	/**
	 * @covers Result_PDO_Driver::valid
	 */
	public function testVaid()
	{
		$this->assertEquals($this->object->valid(), true);
	}

	/**
	 * @covers Result_PDO_Driver::key
	 */
	public function testKey()
	{
		$this->assertEquals($this->object->key(), 0);
	}

	/**
	 * @covers Result_PDO_Driver::key
	 */
	public function testGet()
	{
		$this->assertEquals($this->object->get('id'), 1);
	}

	/**
	 * @covers Result_PDO_Driver::as_array
	 */
	public function testAs_Array()
	{
		$arr = $this->object->as_array();
		$this->assertArrayHasKey(0, $arr);
		$this->assertArrayHasKey('name', (array) $arr[0]);
		$this->assertEquals($arr[0]->name, 'Tinkerbell');
		$this->assertArrayHasKey(1, $arr);
		$this->assertArrayHasKey('id', (array) $arr[1]);
		$this->assertEquals($arr[1]->id, 2);
	}

	public function testIterator()
	{
		$this->assertEquals($this->object->valid(), true);
		$this->assertEquals($this->object->get('id'), 1);
		foreach ($this->object as $key => $row)
		{
			if ($key == 0)
			{
				$this->assertEquals($row->name, 'Tinkerbell');
				$this->assertEquals($row->id, 1);
			}
			if ($key == 1)
			{
				$this->assertEquals($row->name, 'Trixie');
				$this->assertEquals(2, $this->object->get('id'));
				$this->assertEquals($row->id, 2);
			}
		}
		$this->assertEquals(false, $this->object->valid());
		$this->assertEquals(null, $this->object->get('id'));
		$this->assertEquals(null, $this->object->current());
		$this->object->next();
		$this->object->next();
		$this->object->next();
		$this->assertEquals(1, $this->object->key());
	}

}
