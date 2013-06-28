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

class Tooltip extends Tag implements Renderable {
	
	/**
	 * @var string - The tooltip's content
	 */
	protected $content;
	
	/**
	 * Tooltip constructor
	 *
	 * Constructs a tooltip object for an element. Minimun requirements are the $content parameter which
	 * is the tooltips content, this must be of type string, or the method will return false as a 
	 * failure. The $attributes parameter needs to match the $attributes parameter of the add_attribute method
	 * in the Tag class.
	 *
	 * Exntends Tag @filesource tag..php
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses add_attributes
	 * @uses add_class
	 *
	 * @param string $content of the attribute to add
	 * @param array $attributes the attributes to be added
	 * 
	 * @return mixed false on failure or self on success
	 */
	public function __construct( $content, $attributes = NULL ) {
		
		if( !is_string( $content ) ) {
			return false;
		} else {
			$this->content = $content;
		}
		
		if( isset( $attributes ) ) {
			$this->add_attributes( $attributes );
		}
		
		$this->add_class( 'tooltip' );
	}
	
	/**
	 * Gets the tooltips content
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the content for this tooltip
	 */
	public function get_content() {
		return $this->content;
	}
	
	/**
	 * Generates the html for the tooltip
	 *
	 * @see Renderable::get_html()
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the HTML for the tooltip element
	 */
	public function get_html() {
	
		$html = '<div';
		if( !empty( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->name . '="' . $attribute->value . '" ';
			}
		}
		$html .= '>' . $this->content . '</div>';
	
		return $html;
	}
	
	/**
	 * Sets the tooltips content
	 *
	 * This will always overwrite any existing content
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string $content
	 * @return boolean false on failure, or true on success
	 */
	public function set_content( $content ) {
		
		if( is_string( $content ) ) {
			$this->content = $content;
			return true;
		} else {
			return false;
		}
	}
}