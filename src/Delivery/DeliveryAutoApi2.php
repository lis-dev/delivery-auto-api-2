<?php
namespace LisDev\Delivery;
/**
 * Delivery Auto API 2 Class
 * 
 * @author lis-dev
 * @see http://goo.gl/s5L7qm
 * @see https://github.com/lis-dev
 * @license MIT
 */
class DeliveryAutoApi2 {
	/**
	 * @var bool $throwErrors Throw exceptions when in response is error
	 */
	protected $throwErrors = FALSE;
	
	/**
	 * @var string $format Format of returned data - array, json
	 */
	protected $format = 'array';
	
	/**
	 * @var string $culture Language of response (en-US, ru-RU, uk-UA)
	 */
	protected $culture = 'ru-RU';
	
	/**
	 * @var string $model Set current model 
	 */
	protected $model = 'Public';
	
	/**
	 * @var string $method Set method of current model
	 */
	protected $method;
	
	/**
	 * @var array $params Set params of current method of current model
	 */
	protected $params;

	/**
	 * Default constructor
	 * 
	 * @param string $culture Default Language
	 * @param bool $throwErrors Throw request errors as Exceptions
	 * @return this 
	 */
	function __construct($throwErrors = FALSE) {
		$this->throwErrors = $throwErrors;
		return $this;
	}
	
	/**
	 * Setter for culture property
	 * 
	 * @param string $culture
	 * @return this
	 */
	function setCulture($culture) {
		$this->culture = $culture;
		return $this;
	}
	
	/**
	 * Getter for culture property
	 * 
	 * @return string
	 */
	function getCulture() {
		return $this->culture;
	}
	
	/**
	 * Setter for format property
	 * 
	 * @param string $format Format of returned data by methods (json, array)
	 * @return this 
	 */
	function setFormat($format) {
		$this->format = $format;
		return $this;
	}
	
	/**
	 * Getter for format property
	 * 
	 * @return string
	 */
	function getFormat() {
		return $this->format;
	}
	
	/**
	 * Prepare data before return it
	 * 
	 * @param json $data
	 * @return mixed
	 */
	private function prepare($data) {
		//Returns array
		if ($this->format == 'array') {
			$result = is_array($data)
				? $data
				: json_decode($data, 1);
			// If error exists, throw Exception
			if ($this->throwErrors AND $result['errors'])
				throw new \Exception(is_array($result['errors']) ? implode("\n", $result['errors']) : $result['errors']);
			return $result;
		}
		// Returns json
		return $data;
	}
	
	/**
	 * Make request to NovaPoshta API
	 * 
	 * @param string $model Model name
	 * @param string $method Method name
	 * @param array $params Required params
	 */
	private function request($model, $method, $params = NULL) {
		// Get json result
		$params['culture'] = $this->culture;
		$uri_part = '';
		foreach($params as $value => $param) {
			$uri_part .= $value.'='.$param.'&';
		}
		$result = file_get_contents('http://www.delivery-auto.com.ua/api/'.$model.'/'.$method.'?'.$uri_part);
		return $this->prepare($result);
	}

	/**
	 * Set current model and empties method and params properties
	 * 
	 * @param string $model
	 * @return mixed
	 */
	function model($model = '') {
		if ( ! $model) 
			return $this->model;

		$this->model = $model;
		$this->method = NULL;
		$this->params = NULL;
		return $this;
	}

	/**
	 * Set method of current model property and empties params properties
	 * 
	 * @param string $method
	 * @return mixed
	 */
	function method($method = '') {
		if ( ! $method) 
			return $this->method;

		$this->method = $method;
		$this->params = NULL;
		return $this;
	}
	
	/**
	 * Set params of current method/property property
	 * 
	 * @param array $params
	 * @return mixed
	 */
	function params($params) {
		$this->params = $params;
		return $this;
	}
	
	/**
	 * Execute request to NovaPoshta API
	 * 
	 * @return mixed
	 */
	function execute() {
		return $this->request($this->model, $this->method, $this->params);
	}
	
	/**
	 * GetRegionList
	 * 
	 * @return mixed
	 */
	function getRegionList() {
		return $this->request('Public', 'GetRegionList');
	}
	
	/**
	 * GetAreasList
	 * 
	 * @return mixed
	 */
	function getAreasList() {
		return $this->request('Public', 'GetAreasList');
	}
	
	/**
	 * GetWarehousesList
	 * 
	 * @param string $includeRegionalCenters Show offices
	 * @param string $cityId ID of the city
	 * @param string $regionId ID of the region
	 * @return mixed
	 */
	function getWarehousesList($includeRegionalCenters = FALSE, $cityId = NULL, $regionId = NULL) {
		$params['includeRegionalCenters'] = $includeRegionalCenters ? 'true' : 'false';
		$cityId AND $params['cityId'] = $cityId;
		$regionId AND $params['regionId'] = $regionId;
		return $this->request('Public', 'GetWarehousesList', $params);
	}
	
	/**
	 * GetWarehousesInfo
	 * 
	 * @param string $warehousesId
	 * @return mixed
	 */
	function getWarehousesInfo($warehousesId) {
		return $this->request('Public', 'GetWarehousesInfo', array(
			'WarehousesId' => $warehousesId
		));
	}
}
