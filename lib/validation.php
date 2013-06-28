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

class Validation {

	/**
	 * @var string - the name of the validation object
	 */
	protected $name;
	
	/**
	 * @var string - the error message for the validation rule
	 */
	protected $error;
	
	/**
	 * Validation constructor
	 * 
	 * This is intended to be extended and is of little use when created directly
	 * 
	 * @param string $name the name of this validation object
	 * @param string $error the error message for validation failures
	 * @param array $config any additional configuration options required, see specific sub classes
	 */
	public function __construct( $name, $error = null, $config = null ) {

		if( is_string( $name ) ) {
			$this->name = $name;
		}
		
		if( isset( $error ) && is_string( $error ) ) {
			$this->set_error( $error );
		}	
	}
	
	/**
	 * Get the validations name property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the validations name
	 */
	public function get_name() {
		return $this->name;
	}
	
	/**
	 * Get the validations type property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the validations name
	 */
	public function get_type() {
		return $this->type;
	}
	
	/**
	 * Get the validations error property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the validations error
	 */
	public function get_error() {
		
		if( isset( $this->error ) ) {
			return $this->error->get_content();
		} else {
			return false;
		}
	}
	
	/**
	 * Set a new error message for the validation
	 * 
	 * Will create a new Tooltip object if $this->error does not already exist, or simply update the
	 * existing tooltips content if one already exists
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $error the new error message for this validation rule
	 * 
	 * @return boolean false on failure
	 */
	public function set_error( $error ) {
		
		if( is_string( $error ) ) {
			
			if( isset( $this->error ) && is_subclass_of( $this->error, 'Validation' ) ) {
				$this->error->set_content( $error );
			} else {
				$this->error = new Tooltip( $error );
				$this->error->remove_class( 'tooltip' );
				$this->error->add_class( array( 'validation', 'error' ) );
			}
			return true;	
		} else {
			return false;
		}
	}
}