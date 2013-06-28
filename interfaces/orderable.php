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

interface Orderable {
	
	public function set_order( $order );
	public function get_order();
	
}