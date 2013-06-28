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

class Group extends Tag implements Renderable, Orderable {

	/**
	 * @var array - the elements assigned to the group
	 */
	public $elements;
	
	/**
	 * @var string - the name for the element, this is also used as the name attribute
	 */
	protected $name;
	
	/**
	 * @var array - the priority of this group
	 */
	protected $order;
	
	/**
	 * Constructs a new group element
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 */
	public function __construct( $name, $config = NULL, $attributes = NULL ) {
		
		if( is_string( $name ) ) {
			$this->name = $name;
		}
		
		if( isset( $config ) ) {
			if( isset( $config['elements'] ) ) {
				$this->add_elements( $config['elements'] );
			}
		
			if( isset( $config['order'] ) ) {
				$this->set_order( $config['order'] );
			}
		}
		
		if( !isset( $this->order ) ) {
			$this->set_order( 20 );
		}
		
		if( isset( $attributes ) ) {
			$this->add_attributes( $attributes );
		}
	}
	
	/**
	 * Get the groups name property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the elements name
	 */
	public function get_name() {
		return $this->name;
	}
	
	/**
	 * Gets the groups elements
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the elements type
	 */
	public function get_elements() {	
		return $this->elements;	
	}
	
	/**
	 * Get the groups order property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return int the elements priority:
	 */
	public function get_order() {
		return $this->order;
	}
	
	/**
	 * Get the HTML for rendering this group
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses Element::get_html
	 *
	 * @return string the HTML to render this group
	 */
	public function get_html() {
	
		$html = '<div';
		
		if( isset( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->name . '="' . $attribute->value . '" ';
			}
		}
		
		$html .= '>';
		
		if( isset( $this->elements ) ) {
			foreach( $this->elements as $element ) {
				$html .= $element->get_html();
			}
		}
		
		$html .= '</div>';
	
		return $html;
	}
	
	/**
	 * Sets the groups order property
	 *
	 * This will overwrite any existing order
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param int the new order value for the group
	 *
	 * @return boolean false on failure, true on success
	 */
	public function set_order( $order ) {
	
		if( is_numeric( $order ) ) {
			$this->order = $order;
			return true;
		}
		return false;
	}
	
	/**
	 * Add elements to the group
	 * 
	 * This function will overwrite any existing elements by default
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::get_name
	 * 
	 * @param array $elements an array of elements, or element configurations to add to this group
	 * @param boolean $overwrite wheather an element with the same name as an existing element should overwrite that element
	 * 
	 * @return boolean|array false on failure, or an array of added element names on success
	 */
	public function add_elements( $elements, $overwrite = true  ) {
		
		$added = false;
		
		if( !is_array( $elements ) ) {
			return false;
		}
		
		foreach( $elements as $element ) {
			if( $element instanceof Element || is_subclass_of( $element, 'Element' ) ) {
				$added[] = $element;
			}
			
			if( is_array( $element ) ) {
				if( ( isset( $element['name'] ) && is_string( $element['name'] ) ) && ( isset( $element['type'] ) && is_string( $element['type'] ) ) ) {
			
					$name = $element['name'];
					$type = $element['type'];
					$class = ucfirst( strtolower( $type ) );
					
					if( class_exists( $class ) ) {
						$object = new $class( $name, $element['config'], $element['attributes'] );
						if( $object instanceof $class ) {
							if( !isset( $this->elements[$object->get_name()] ) || ( isset( $this->elements[$object->get_name()] ) && $overwrite === true ) ) {
								$this->elements[$object->get_name()] = $object;
								$added[] = $object->get_name();
							}
						}
					}
				}
			}
		}
		
		if( $added !== false ) {
			$this->sort_elements();
		}
		return $added;
	}
	
	/**
	 * Removes elements from the group
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::get_name
	 * 
	 * @param array $elements array of element names and/or objects to be removed fromt he group
	 * @return boolean|array false on failure or an array of removed element names on success
	 */
	public function remove_elements( $elements ) {
		
		$removed = false;
		
		if( !is_array( $elements ) ) {
			return $removed;
		}
		
		foreach( $elements as $element ) {
			if( is_string( $element ) ) {
				$name = $element;
			}
			if( $element instanceof Element || is_subclass_of( $element, 'Element' ) ) {
				$name = $element->get_name();
			}
			if( isset( $this->elements[$name] ) ) {
				unset( $this->elements[$name] );
				$removed[] = $name;
			}
		}
		return $removed;
	}
	
	public function sort_elements() {
		usort( $this->elements, array( &$this, '_element_sort' ) );
	}
}