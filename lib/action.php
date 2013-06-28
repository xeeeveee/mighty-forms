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

class Action {
	
	/**
	 * @var string - the name of this particular action
	 */
	protected $name;
	
	/**
	 * Action constructor
	 * 
	 * Intended to be extended by sub classes
	 * 
	 * @author Jack Neary
 	 * @since 1.0
	 * 
	 * @param string $name the name of this action
	 * @param array $config the configuration variables for the action
	 */
	public function __construct( $name, $config = null ) {

		if( is_string( $name ) ) {
			$this->name = $name;
		}
	}
	
	/**
	 * Returns the name of this action
	 * 
	 * @author Jack Neary
 	 * @since 1.0
	 * 
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}
}