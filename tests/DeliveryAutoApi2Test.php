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
	
	/**
	 * Test GetRegionList result as array
	 */
	function testGetRegionListArray() {
		$result = $this->da->getRegionList();
		$this->assertTrue($result['status']);
	}
	
	/**
	 * Test GetAreasList
	 */
	function testGetAreasList() {
		$result = $this->da->getAreasList();
		$this->assertTrue($result['status']);
	}
	
	/**
	 * Test GetWarehousesList
	 */
	function testGetWarehousesListList() {
		$result = $this->da->getWarehousesList(FALSE, '4fc948a7-3729-e311-8b0d-00155d037960', '');
		$this->assertTrue($result['status']);
	}
}