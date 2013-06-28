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

class Label extends Form_Helper implements Renderable {
	
	/**
	 * @var string - The label's content
	 */
	protected $content;
	
	/**
	 * @var boolean - wheather to render the label before or after the Element
	 */
	protected $before;
	
	/**
	 * @var string - The name of the element this label is attached too
	 */
	protected $element;
	
	/**
	 * Label constructor
	 *
	 * Constructs a label object for an element. Minimun requires are the $content parameter which
	 * is the labels content, this must be of type string, or the method will return false as a 
	 * failure. The $before and $attributes parameters are optional. $before must be a boolean value
	 * and dictates whether the label is to be rendered before or after the element it's self. The
	 * $attributes parameter needs to match the $attributes parameter of the add_attribute method
	 * in the Form_Helper class.
	 *
	 * Exntends Form_Helper @filesource formhelper.class.php
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses add_attributes()
	 *
	 * @param string $content of the attribute to add
	 * @param bool $before of the attribute to add
	 * @param array $attributes the attributes to be added
	 *
	 * @return mixed false on failure or self on success
	 */
	public function __construct( $content, $attributes = NULL, $before = true ) {
	
		if( !is_string( $content ) ) {
			return false;
		} else {
			$this->content = $content;
		}
		
		if( isset( $before ) && is_bool( $before ) ) {
			$this->before = $before;
		} else {
			$this->before = true;
		}
		
		if( isset( $attributes ) ) {
			$this->add_attributes( $attributes );
		}
	}
	
	/**
	 * Gets the current element
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string The name of the assigned Element
	 */
	public function get_element() {
		return $this->element;
	}
	
	/**
	 * Gets the labels location
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return boolean true for before, false for after
	 */
	public function get_location() {
		return $this->before;
	}
	
	/**
	 * Generates the html for the label
	 *
	 * @see Renderable::get_html()
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the HTML for the label element
	 */
	public function get_html() {
	
		$html = '<label';
			
		if( isset( $this->element ) ) {
			$html .= ' for="' . $this->element . '"';
		}
	
		if( !empty( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->name . '="' . $attribute->value . '" ';
			}
		}
	
		$html .= '>' . $this->content . '</label>';
	
		return $html;
	}
	
	/**
	 * Sets the label's content
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
	
	/**
	 * Set's the labels location
	 * 
	 * This will always overwrite the existing location
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $content
	 * @return boolean false on failure, or true on success
	 */
	public function set_location( $before ) {
		
		if( is_bool( $before ) ) {
			$this->before = $before;
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Sets the labels element
	 * 
	 * Sets the labels element, this will always be overwrite any existing element.
	 * This is called automatically when adding a label to an element via Element::set_label()
	 * 
	 * @see Element::set_label()
	 * @filesource lib/element.class.php
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::get_name
	 * 
	 * @param unknown_type $element
	 * @return Element|boolean
	 */
	public function set_element( $element ) {
		
		if( $element instanceof Element ) {
			$this->element = $element->get_name();
			return $this->element;
		}
		
		if( is_string( $element ) ) {
			$this->element = $element;
			return $this->element;
		}
		return false;
	}	
}