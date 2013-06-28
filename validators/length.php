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

class Length extends Validation implements Validatable {
	
	/**
	 * @var string - the type of validation 
	 */
	protected $type = 'length';
	
	/**
	 * @var string - the default error message for this type
	 */
	protected $default_error = 'Value expected to be within specified range';
	
	/**
	 * @var int - the maximum length of the value
	 */
	protected $max_length;
	
	/**
	 * @var int - the minimum length of the value
	 */
	protected $min_length;
	
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
		
		if( isset( $config['min'] ) || isset( $config['max'] ) ) {
			if( isset( $config['min'] ) && is_int( $config['min'] ) ) {
				$this->min_length = $config['min'];
			}
			
			if( isset( $config['max'] ) && is_int( $config['max'] ) ) {
				$this->max_length = $config['max'];
			}			
		}
		
		$this->error = $this->default_error;
		parent::__construct( $name, $config );
	}
	
	/**
	 * Get the minimum length property
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return int the minimun length class property
	 */
	public function get_min() {
		return $this->min_length;
	}
	
	/**
	 * Get the maximum length property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return int the maximum length class property
	 */
	public function get_max() {
		return $this->max_length;
	}
	
	/**
	 * Set the minimum length property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param int $value the new minimum length
	 *
	 * @return boolean false on failure, true on success
	 */
	public function set_min( $value ) {
		
		if( is_int( $value ) ) {
			$this->min_length = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Set the maximum length property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param int $value the new maximum length
	 *
	 * @return boolean false on failure, true on success
	 */
	public function set_max( $value ) {
	
		if( is_int( $value ) ) {
			$this->max_length = $value;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Checks if a value passes this validation
	 * 
	 * Will compare against minimun AND maximum if both are set, if only one is set, will compare against the
	 * the set value only, if none are set, will return true.
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $value
	 * 
	 * @return boolean true for valid, false for invalid.
	 */
	public function check( $value ) {
		
		if( !isset( $this->min_length ) && !isset( $this->max_length ) ) {
			return true;
		}
		
		$length = count( $value );
		
		if( isset( $this->min_length ) && isset( $this->max_length) ) {
			if( $length >= $this->min_length && $length <= $this->max_length ) {
				return true;
			} else {
				return false;
			}
		}
		
		if( isset( $this->min_length ) ) {
			if( $length >= $this->min_length ) {
				return true;
			} else {
				return false;
			}
		}
		
		if( isset( $this->max_length) ) {
			if( $length <= $this->max_length ) {
				return true;
			} else {
				return false;
			}
		}
	}
}