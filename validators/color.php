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

class Colour extends Validation implements Validatable {
	
	/**
	 * @var string - the type of validation 
	 */
	protected $type = 'colour';
	
	/**
	 * @var string - the default error message for this type
	 */
	protected $default_error = 'Valid hexadecimal colour code expected';
	
	/**
	 * @var string - the regular expresion to be used to check the colour
	 * 
	 * Regular expression used by Zend Framework 2.1.4
	 * @link http://framework.zend.com/
	 */
	protected $regex = '/^#[0-9a-fA-F]{6}$/';
	
	/**
	 * Overrides the parents constructor
	 * 
	 * The parents constructure is called to populate all the common elements between validation rules
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $name the name for this required rules
	 * @param array $config any additional configuration parameters - none required for this type
	 */
	public function __construct( $name, $config = null ) {
		
		$this->error = $this->default_error;
		parent::__construct( $name, $config );
	}
	
	/**
	 * Checks if a value passes this validation
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $value
	 * 
	 * @return boolean true for valid, false for invalid.
	 */
	public function check( $value ) {
		
		if( preg_match( $this->regex, $value ) ) {
			return true;
		} else {
			return false;
		}
	}
}