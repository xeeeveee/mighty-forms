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

class Integer extends Validation implements Validatable {
	
	/**
	 * @var string - the type of validation 
	 */
	protected $type = 'integer';
	
	/**
	 * @var string - the default error message for this type
	 */
	protected $default_error = 'Integer value expected';
	
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
		
		if( is_int( $value ) ) {
			return true;
		} else {
			return false;
		}
	}
}