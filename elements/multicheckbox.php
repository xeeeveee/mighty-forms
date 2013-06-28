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

class Multicheckbox extends Select implements Renderable {

	/**
	 * @var string - the type of element this is
	 */
	protected $type = 'multicheckbox';
	
	/**
	 * @var array - the options to create checkboxes for
	 */
	protected $options;
	
	/**
	 * Construct a new multi checkbox element
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
	 * @filesource elements/select.class.php
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the HTML to render this element
	 */
	public function get_html() {
		
		$html = '';
		
		if( isset( $this->label ) && $this->label->get_location() === true ) {
			$html .= $this->label->get_html();
		}

		$html .= '<input type="hidden" name="' . $this->name .'" value="0" />';
		
		foreach( $this->options as $key => $val ) {
		
			$html .= '<input';
			$html .= ' type="checkbox"';
			$html .= ' name="' . $this->name .'[]"';
			$html .= ' value="' . $key . '"';
			
			if( isset( $this->attributes ) ) {
				$html .= ' ';
				foreach( $this->attributes as $attribute ) {
					$html .= $attribute->name . '="' . $attribute->value . '" ';
				}
			}
			
			$html .= $this->_checked( $key );
			$html .= '/><span>' . $val . '</span>';
		}
		
		if( isset( $this->label ) && $this->label->get_location() === false ) {
			$html .= $this->label->get_html();
		}
		
		if( isset( $this->tooltip ) ) {
			$html .= $this->tooltip->get_html();
		}
		
		return $html;
	}
	
	/**
	 * Check if a option should be checked
	 *
	 * Checks if the current value exists within the value array
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string $value the value to check against
	 *
	 * @return string checked="checked" if they match, or '' if they don't
	 */
	protected function _checked( $value ) {
	
		if( !isset( $this->value ) ) {
			return '';
		}
	
		if( is_array( $this->value ) ) {
			if( in_array( $value, $this->value ) === true ) {
				return 'checked="checked"';
			} else {
				return '';
			}
		} else {
			return '';
		}
	}
}