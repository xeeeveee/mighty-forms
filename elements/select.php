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

class Select extends Element implements Renderable {

	/**
	 * @var string - the type of element this is
	 */
	protected $type = 'select';
	
	/**
	 * @var array - the options to populate the select with
	 */
	protected $options;
	
	/**
	 * Construct a new select element
	 * 
	 * Adds additional support the parent construct to include 'options' in the configuration array. Calls
	 * the parent method once options have been added.
	 * 
	 * Overwrites Element::__construct()
	 * 
	 * @see Element::__construct
	 * @filesource lib/element.php
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $name the identifyer for this element
	 * @param array $config contains additional configuration options for the element
	 * @param array $attributes contains the attributes for this element
	 */
	public function __construct( $name, $config = NULL, $attributes = NULL ) {
		
		foreach( $config['options'] as $key => $val ) {
			if( is_string( $val ) && ( !is_array( $key ) || is_object( $key ) ) ) {
				$options[$key] = $val;
			}
		}
		
		if( isset( $options ) ) {
			$this->options = $options;
		}
		
		parent::__construct( $name, $config, $attributes );
	}
	
	/**
	 * Get the HTML for rendering this element
	 * 
	 * Overwrites Element::get_html()
	 * 
	 * @see Element::get_html
	 * @filesource lib/element.class.php
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
		
		$html .= '<select';		
		$html .= ' name="' . $this->name .'"';
		
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
	 * Add options
	 * 
	 * This will overwrite any existing options of the same name
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param array $options associated array of options to add, the Key will be used as the options value, and the Value will be used at the label.
	 * 
	 * @return mixed boolean|array false if nothing is added, or an array of added option values on success
	 */
	public function add_options( $options ) {
		
		$added = false;
		
		foreach( $options as $key => $val ) {
			if( is_string( $val ) ) {
				$this->options[$key] = $val;
				$added[] = $key;
			}
		}
		return $added;
	}
	
	/**
	 * Remove options
	 * 
	 * Provide an array of option values (keys) to be removed
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param array $options
	 * 
	 * @return mixed boolean|array false if nothing is removed, or an array of removed option values on success
	 */
	public function remove_options( $options ) {
		
		$removed = false;
		
		foreach( $options as $option ) {
			if( isset( $this->options[$option] ) ) {
				unset( $this->options[$option] );
				$removed[$option];
			}
		}
		return $removed;
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
		
		if( $value == $this->value ) {
			return 'selected="selected"';
		} else {
			return '';
		}
	}
}