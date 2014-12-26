<?php
namespace LisDev\Tests;
use LisDev\Delivery\DeliveryAutoApi2;
/**
 * phpUnit test class
 * 
 * @author lis-dev
 */
class DeliveryAutoApi2Test extends \PHPUnit_Framework_TestCase
{
	/**
	 * Instace of tested class
	 */
	private $da;
	
	/**
	 * Set up before class
	 */
	static function setUpBeforeClass() {
		// Disable notices
		error_reporting(E_ALL ^ E_NOTICE);
	}
	
	/**
	 * Set up before each test
	 */
	function setUp() {
		// Create new instance
		$this->da = new DeliveryAutoApi2();
	}
	
	/**
	 * Test GetRegionList result as array
	 */
	function testGetRegionListArray() {
		$result = $this
			->da
			->model('Public')
			->method('GetRegionList')
			// ->params()
			->execute();
		$this->assertTrue(is_array($result));
	}
	
	/**
	 * Test GetRegionList result as json
	 */
	function testGetRegionListJson() {
		$result = $this
			->da
			->setFormat('json')
			->model('Public')
			->method('GetRegionList')
			// ->params()
			->execute();
		$this->assertTrue(is_string($result));
	}
}