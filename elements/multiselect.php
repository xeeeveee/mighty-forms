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

class Multiselect extends Select implements Renderable {

	/**
	 * @var string - the type of element this is
	 */
	protected $type = 'multiselect';
	
	/**
	 * @var array - the options to populate the select with
	 */
	protected $options;
	
	/**
	 * Construct a new multi select element
	 *
	 * Overwrites Select::__construct()
	 * @see Element
	 * @filesource elements/select.php
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses Select::__construct()
	 *
	 * @param string $name the identifyer for this element
	 * @param array $config contains additional configuration options for the element
	 * @param array $attributes contains the attributes for this element
	 */
	public function __construct( $name, $config = NULL, $attributes = NULL ) {
		parent::__construct( $name, $config, $attributes );
	}
	
	/**
	 * Get the HTML for rendering this element
	 * 
	 * Overwrites Select::get_html()
	 * 
	 * @see Select::get_html
	 * @filesource elements/select.php
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return string the HTML to render this element
	 */
	public function get_html() {
		
		if( !isset( $this->options ) ) {
			return false;
		}
		
		$html = '';
		
		if( isset( $this->label ) && $this->label->get_location() === true ) {
			$html .= $this->label->get_html();
		}
		
		$html .= '<select multiple';		
		$html .= ' name="' . $this->name .'[]"';
		
		if( !empty( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->name . '="' . $attribute->value . '" ';
			}
		}
		
		$html .= '>';
		
		foreach( $this->options as $value => $label ) {
			$html .= '<option value="' . $value . '" ' . $this->_selected( $value ) . ' >' . $label . '</option>';
		}
		
		$html .= '</select>';
		
		if( isset( $this->label ) && $this->label->get_location() === false ) {
			$html .= $this->label->get_html();
		}
		
		if( isset( $this->tooltip ) ) {
			$html .= $this->tooltip->get_html();
		}
		
		return $html;	
	}
	
	/**
	 * Check if a option should be selected
	 * 
	 * Compares two passed values, if they are the same selected="selected" is returned
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string $value the value to check against
	 *
	 * @return string selected="selected" if they match, or '' if they don't
	 */
	protected function _selected( $value ) {
		
		if( !isset( $this->value ) ) {
			return '';
		}
		
		if( is_array( $this->value ) ) {
			if( in_array( $value, $this->value ) === true ) {
				return 'selected="selected"';
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}