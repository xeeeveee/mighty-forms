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

abstract class Element extends Tag implements Renderable {

	/**
	 * @var array - an array of validation objects
	 */
	public $validation;
	
	/**
	 * @var string - the name for the element, this is also used as the name attribute
	 */
	protected $name;
	
	/**
	 * @var string - the type of the element, typically set by the extending objects
	 */
	protected $type;
	
	/**
	 * @var string - the existing value of the element
	 */
	protected $value;
	
	/**
	 * @var Label - an instance of a label object
	 */
	protected $label;
	
	/**
	 * @var Tooltip - an instance of a tooltip object
	 */
	protected $tooltip;
	
	/**
	 * @var array - the priority of this element
	 */
	protected $order;
	
	/**
	 * @var array - attribute names that are to be ignored
	 */
	protected $reserved_attributes = array( 'type', 'value', 'selected', 'checked' );
	
	/**
	 * Constructs a new base element
	 * 
	 * Elements are not intended to be created directly. A sub class extending Element should be used for
	 * each input type. 
	 * 
	 * Constructs a new base element based on the provided parameters, minimun requirements for creating
	 * a new element is the name.
	 * 
	 * Possible config parameters:
	 * - label
	 * - tooltip
	 * - validator
	 * - value
	 * 
	 * Additional configuration parameters may be supported by specific sub classes, see each sub class for
	 * specific requiremenets
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Tag::set_label()
	 * @uses Tag::set_tooltip()
	 * @uses Tag::add_attributes()
	 * 
	 * @param string $name the name of the element
	 * @param array $config configuration array for building a complete element
	 * @param array $attributes array of attribute objects to be added to this element
	 */
	public function __construct( $name, $config = NULL, $attributes = NULL ) {
		
		if( is_string( $name ) ) {
			$this->name = $name;
		}
		
		if( isset( $config ) ) {
			if( isset( $config['label'] ) ) {
				$this->set_label( $config['label'] );
			}
			
			if( isset( $config['tooltip'] ) ) {
				$this->set_tooltip( $config['tooltip'] );
			}
			
			if( isset( $config['validation'] ) ) {
				$this->add_validation( $config['validation'] );
			}
			
			if( isset( $config['value'] ) ) {
				$this->set_value( $config['value'] );
			}
			
			if( isset( $config['order'] ) ) {
				$this->set_order( $config['order'] );
			}
		}
		
		if( !isset( $this->order ) ) {
			$this->set_order( 20 );
		}
		
		if( !isset( $this->value ) ) {
			$this->set_value('');
		}
		
		if( isset( $attributes ) ) {
			$this->add_attributes( $attributes );
		}
	}
	
	/**
	 * Get the elements name property
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
	 * Get the elements type property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the elements type
	 */
	public function get_type() {	
		return $this->type;	
	}
	
	/**
	 * Get the elements value property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the elements value
	 */
	public function get_value() {
		return $this->value;
	}
	
	/**
	 * Get the elements order property
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
	 * Get the HTML for rendering this element
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses Label::get_location
	 * @uses Label::get_html
	 * @uses Tooltip::get_html
	 *
	 * @return string the HTML to render this element
	 */
	public function get_html() {
	
		$html = '';
	
		if( isset( $this->label ) && $this->label->get_location() === true ) {
			$html .= $this->label->get_html();
		}
	
		$html .= '<input';
		$html .= ' type="' . $this->type .'"';
		$html .= ' name="' . $this->name .'"';
	
		if( isset( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->get_name() . '="' . $attribute->get_value() . '" ';
			}
		}
	
		if( !empty( $this->value ) ) {
			$html .= ' value="' . $this->value .'"';
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

	/**
	 * Sets the elements value property
	 *
	 * This will overwrite any existing value
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param mixed the new value for the element, all no object types are valid
	 * 
	 * @return boolean false on failure, true on success
	 */
	public function set_value( $value ) {
		
		if( !is_object( $value ) ) {
			$this->value = $value;
			return true;
		}
		return false;
	}
	
	/**
	 * Sets the elements order property
	 *
	 * This will overwrite any existing order
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param int the new order value for the element
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
	 * Set the elements label
	 * 
	 * This function will also overwrite any existing label. To update an existing label, use the Label
	 * object's methods to interact with it's properties.
	 * 
	 * Can accept either a premade Label object, a string for the label content, or an array of label properties
	 * 
	 * @see Label::__construct
	 * @filesource lib/label..php
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Label::set_element
	 * 
	 * @param Label|string|array - either a Label object, or data to create a new label object
	 */
	public function set_label( $label ) {
		
		if( $label instanceof Label ) {
			$this->label = $label;
			$this->label->set_element( $this->name );
		}
		
		if( is_string( $label ) ) {
			$object = new Label( $label );
			
			if( $object !== false ) {
				$this->label = $object;
				$this->label->set_element( $this->name );
			}
		}
		
		if( is_array( $label ) ) {
			if( isset( $label['content'] ) && is_string( $label['content'] ) ) {
				
				$content = $label['content'];
				
				if( isset( $label['attributes'] ) && is_array( $label['attributes'] ) ) {
					$attributes = $label['attributes'];
				} else {
					$attributes = null;
				}
				
				if( isset( $label['before'] ) && is_bool( $label['before'] ) ) {
					$before = $label['before'];
				} else {
					$before = null;
				}
				
				$object = new Label( $content, $attributes, $before );
				
				if( $object !== false ) {
					$this->label = $object;
					$this->label->set_element( $this->name );
				}
			}
		}
	}
	
	/**
	 * Removes the label from the element
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return boolean true on success or false on failure
	 */
	public function remove_label() {
		
		if( isset( $this->label ) ) {
			unset( $this->label );
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Set the elements tooltip
	 * 
	 * This function will also overwrite any existing tooltip. To update an existing tooltip, use the Tooltip
	 * object's methods to interact with it's properties.
	 * 
	 * Can accept either a premade Tooltip object, a string for the tooltip content, or an array of tooltip properties
	 * 
	 * @see Tooltip::__construct
	 * @filesource lib/tooltip..php
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param Tooltip|string|array - either a Tooltip object, or data to create a new tooltip object
	 * 
	 * @return boolean true on success or false on failure
	 */
	public function set_tooltip( $tooltip ) {
		
		if( $tooltip instanceof Tooltip ) {
			$this->tooltip = $tooltip;
			return true;
		}
		
		if( is_string( $tooltip ) ) {
			$object = new Tooltip( $tooltip );
			
			if( $object !== false ) {
				$this->tooltip = $object;
				return true;
			}
		}
		
		if( is_array( $tooltip ) ) {
			if( isset( $tooltip['content'] ) && is_string( $tooltip['content'] ) ) {
				
				$content = $tooltip['content'];
				
				if( isset( $tooltip['attributes'] ) && is_array( $tooltip['attributes'] ) ) {
					$attributes = $tooltip['attributes'];
				} else {
					$attributes = null;
				}
				
				$object = new Tooltip( $content, $attributes );
				
				if( $object !== false ) {
					$this->tooltip = $object;
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * Removes the tooltip from the element
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return boolean true on success or false on failure
	 */
	public function remove_tooltip() {
		
		if( isset( $this->tooltip ) ) {
			unset( $this->tooltip );
			return true;
		} else {
			return false;
		}
	}	
	
	/**
	 * Adds validation objects to the element
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param array|object $validation - either a configuration array for new objects, or existing validation objects
	 * 
	 * @return boolean|array false on failure, or an array of validation object names that where successfully added
	 */
	public function add_validation( $validation ) {		
		
		$validators = false;
		
		if( $validation instanceof Validation || is_subclass_of( $validation, 'Validation' ) ) {
			$validators[] = $validation;
		}
		
		if( !is_array( $validation ) ) {
			return false;
		}
		
		if( isset( $validation['name'] ) && isset( $validation['type'] ) ) {
			if( !isset( $validation['error'] ) ) {
				$validation['error'] = null;
			}
			if( !isset( $validation['config'] ) ) {
				$validation['config'] = null;
			}
			$validators[] = $this->_add_validation( $validation['name'], $validation['name'], $validation['error'], $validation['config'] );
		} else {
			foreach( $validation as $rule ) {				
				if( $rule instanceof Validation || is_subclass_of( $rule, 'Validation' ) ) {
					$validators[] = $rule;
				}
				
				if( isset( $rule['name'] ) && isset( $rule['type'] ) ) {
					if( !isset( $rule['error'] ) ) {
						$rule['error'] = null;
					}
					if( !isset( $rule['config'] ) ) {
						$rule['config'] = null;
					}
					$validators[] = $this->_add_validation( $rule['name'], $rule['type'], $rule['error'], $rule['config'] );
				}
			}
		}
		
		if( $validators === false ) {
			return $validators;
		}
		
		$this->validation = $validators;
		foreach( $validators as $validator ) {
			$added[] = $validator->get_name();
		}
		return $added;
	}
	
	/**
	 * Removes the specified validation objects
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param array $rules an array of validation rules to remove from the element
	 * 
	 * @return boolean|array false on failure, or an array of validation object names on success
	 */
	public function remove_validation( $rules ) {
		
		$removed = false;
		
		if( is_string( $rules ) ) {
			$result[] = $this->_remove_validation( $rules );
		}
		
		if( is_array( $rules ) ) {
			foreach( $rules as $rule ) {
				$result = $this->_remove_attribute( $rule );
				if( $result !== false ) {
					$removed[] = $result;
				}
			}
		}
		return $removed;
	}
	
	/**
	 * Validates the element against all attached rules
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return boolean $valid true if vaild, or false if validation errors are found
	 */
	public function validate() {
		
		$valid = true;
		
		foreach( $this->validation as $rule ) {
			$result = $rule->check( $this->value );
			if( $result === false ) {
				$valid = false;
			}
		}
		return $valid;
	}
	
	/**
	 * Get all current validation errors
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return boolean|array false if there are no errors, or an array of error messages if errors are found
	 */
	public function get_errors() {
		
		$errors = false;
		
		if( !isset( $this->validation ) ) {
			return false;
		}
		
		foreach( $this->validation as $rule ) {
			$result = $rule->check( $this->value );
			if( $result === false ) {
				$errors[] = $rule->get_error();
			}
		}
		return $errors;
	}
	
	/**
	 * Creates a new validation object for the element
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $name the name of the validation object
	 * @param string $type the type of validation object
	 * @param string $error the error message for the validation object
	 * @param array $config a configuration array for any additionally required parameters, see each sub class for full details
	 * 
	 * @return object|boolean false on failure, or a new validation object on success
	 */
	private function _add_validation( $name, $type, $error, $config = null ) {
	
		$class = ucfirst( strtolower( $type ) );
			
		if( class_exists( $class ) ) {
			$rule = new $class( $name, $error, $config );
			return $rule;
		}
		return false;
	}
	
	/**
	 * Removes and existing validation object from the element
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $name the name of the element to remove
	 * @return boolean, string false on failure to remove, or the name of the removed validation object on success
	 */
	private function _remove_validation( $name ) {
	
		$removed = false;
		
		if( isset( $this->validation[$name] ) ) {
			unset( $this->validation[$name] );
			$removed = $name;
		}
		return $removed;
	}
}