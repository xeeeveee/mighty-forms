<?php
/**
 * Key Retirement Solutions Form Framework
 *
 * @package Keyrs Forms Framework
 * @subpackage Actions
 * 
 * @link http://www.keyrs.co.uk
 * @author Jack Neary
 */

class Attribute {
	
	/** 
	 * @var string - The attribute name
	 */
	protected $name;
	
	/**
	 * @var string - The value for the attribute
	 */
	protected $value;
	
	/**
	 * Attribute constructor
	 * 
	 * Converts the name and value parameters into object properties. The $name parameter represents
	 * the HTML attribute and the $value parameter represents the HTML attributes value.
	 * 
	 * @author Jack Neary
 	 * @since 1.0
	 * 
	 * @param string $name of the attribute to add
	 * @param string $value of the attribute to add
	 * 
	 * @return bool false on failure, true on success
	 */
	public function __construct( $name, $value ) {

		if( is_string( $name ) && is_string( $value ) ) {
			$this->name = $name;
			$this->value = $value;
			return true;
		} else {
			return false;
		}			
	}
	
	public function get_name() {
		return $this->name;
	}
	
	public function get_value() {
		return $this->value;
	}
}