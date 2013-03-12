<?php

require_once('/../../system/classes/request.php');
require_once('/../../system/classes/route.php');

/**
 * Generated by PHPUnit_SkeletonGenerator on 2013-02-06 at 16:12:22.
 */
class requestTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Request
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$route = (object) array('params' => array('controller' => 'test', 'action' => 'index', 'fairy_param' => 'Trixie'));
		$this->object = new Request($route, 'GET', array('fairy_post' => 'Trixie'), array('fairy_get' => 'Trixie'), array('fairy_server' => 'Trixie'));
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{

	}

	/**
	 * @covers Request::get
	 * @todo   Implement testGet().
	 */
	public function testGet()
	{
		$this->assertEquals($this->object->get('fairy_get'), 'Trixie');
		$this->assertEquals($this->object->get('bogus', 'default'), 'default');
	}

	/**
	 * @covers Request::post
	 * @todo   Implement testPost().
	 */
	public function testPost()
	{
		$this->assertEquals($this->object->post('fairy_post'), 'Trixie');
		$this->assertEquals($this->object->post('bogus', 'default'), 'default');
	}

	/**
	 * @covers Request::server
	 * @todo   Implement testServer().
	 */
	public function testServer()
	{
		$this->assertEquals($this->object->server('fairy_server'), 'Trixie');
		$this->assertEquals($this->object->server('bogus', 'default'), 'default');
	}

	/**
	 * @covers Request::param
	 * @todo   Implement testParam().
	 */
	public function testParam()
	{
		$this->assertEquals($this->object->param('fairy_param'), 'Trixie');
		$this->assertEquals($this->object->param('bogus', 'default'), 'default');
	}

	/**
	 * @covers Request::execute
	 * @todo   Implement testExecute().
	 */
	public function testExecute()
	{
		$this->object->execute();
	}

	/**
	 * @covers Request::execute
	 * @todo   Implement testExecute().
	 */
	public function testExecuteException()
	{
		$route = (object) array('params' => array('controller' => 'bogus', 'action' => 'bogus'));
		$req = new Request($route);
		$except = false;
		try {
			$req->execute();
		} catch (Exception $e) {
			$except = true;
		}
		$this->assertEquals($except, true);
	}

	/**
	 * @covers Request::create
	 * @todo   Implement testGetURI().
	 */
	public function testCreate()
	{
		Route::add('default', '/<controller>/<action>');
		Config::set('core.basepath', '/tester/');
		$_SERVER['REQUEST_URI'] = "/tester/home/index";
		$_POST['post'] = "test";
		$_GET['get'] = "test";
		$_SERVER['REQUEST_METHOD'] = "POST";
		$req = Request::create();
		$this->assertEquals($req->get('get'), 'test');
		$this->assertEquals($req->post('post'), 'test');
		$this->assertEquals($req->server('REQUEST_METHOD'), 'POST');
		$this->assertEquals($req->method, 'POST');
		$this->assertEquals($req->param('controller'), 'home');
		$this->assertEquals($req->param('action'), 'index');
	}

}
