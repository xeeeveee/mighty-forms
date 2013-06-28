<?php
/**
 * Mighty Studios Form Framework
 *
 * @package Mighty Forms Framework
 * @subpackage Actions
 * 
 * @link http://www.mighty.co.uk
 * @author Jack Neary
 */

class Required extends Validation implements Validatable {
	
	/**
	 * @var string - the type of validation 
	 */
	protected $type = 'required';
	
	/**
	 * @var string - the default error message for this type
	 */
	protected $default_error = 'This field is required';
	
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
		
		if( isset( $value ) && !empty( $value ) ) {
			return true;
		} else {
			return false;
		}
	}
}