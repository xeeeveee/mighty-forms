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

class Checkbox extends Element implements Renderable {

	/**
	 * @var string - the type of element this is
	 */
	protected $type = 'checkbox';
	
	/**
	 * @var array - attribute names that are to be ignored
	 */
	protected $reserved_attributes = array( 'type', 'value' );
	
	/**
	 * Construct a new checbox element
	 * 
	 * Overwrites Element::__construct()
	 * @see Element
	 * @filesource lib/element.php
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::__construct()
	 * 
	 * @param string $name the identifyer for this element 
	 * @param array $config contains additional configuration options for the element
	 * @param array $attributes contains the attributes for this element
	 */
	public function __construct( $name, $config = NULL, $attributes = NULL ) {
		
		if( isset( $config['checked'] ) == true ) {
			$this->checked = true;
		} else {
			$this->checked = false;
		}
		
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
		$html .= '<input';
		$html .= ' type="' . $this->type .'"';
		$html .= ' name="' . $this->name .'"';
		$html .= ' value="1"';
		
		if( isset( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->name . '="' . $attribute->value . '" ';
			}
		}
		
		if( !empty( $this->value ) && $this->value == true ) {
			$html .= ' checked="checked"';
		}
		
		$html .= '/>';
		
		if( isset( $this->label ) && $this->label->get_location() === false ) {
			$html .= $this->label->get_html();
		}
		
		if( isset( $this->tooltip ) ) {
			$html .= $this->tooltip->get_html();
		}
		
		return $html;
	}
}