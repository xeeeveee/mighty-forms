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

class Form extends Tag implements Renderable {

	/**
	 * @var array - the elements assigned to the form
	 */
	public $elements;
	
	/**
	 * @var array - the groups assigned to the form
	 */
	public $groups;
	
	/**
	 * @var array of action objects for the form
	 */
	public $actions;
	
	/**
	 * @var string - the name for the element, this is also used as the name attribute
	 */
	protected $name;
	
	/**
	 * @var string - the method attribute for the form
	 */
	protected $method;
	
	/**
	 * @var string - the action attribute for the form
	 */
	protected $action;
	
	/**
	 * @var array - ordered groups and elements
	 */
	protected $components;

	/**
	 * @var array - attribute names that are to be ignored
	 */
	protected $reserved_attributes = array( 'method', 'action' );
	
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

			if( isset( $config['groups'] ) ) {
				$this->add_groups( $config['groups'] );
			}
			
			if( isset( $config['method'] ) ) {
				$this->set_method( $config['method'] );
			}
			
			if( isset( $config['action'] ) ) {
				$this->set_action( $config['action'] );
			}
		}
		
		if( isset( $this->elements ) || isset( $this->groups ) ) {
			$this->prepare_components();
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
	 * Get the forms elements
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return array of element objects assigned to the form
	 */
	public function get_elements() {	
		return $this->elements;	
	}
	
	/**
	 * Get the forms groups
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return array of group objects assigned to the form
	 */
	public function get_groups() {
		return $this->groups;
	}
	
	/**
	 * Get the forms method property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the forms method property
	 */
	public function get_method() {
		return $this->method;
	}
	
	/**
	 * Get the forms action property
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the forms action property
	 */
	public function get_form_action() {
		return $this->action;
	}
	
	/**
	 * Get a specific form action
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return boolean|object false if the action does not exist, or the action object on success
	 */
	public function get_action( $action ) {
		if( is_string( $action ) && isset( $this->$actions[$action] ) ) {
			return $this->$actions[$action];
		}
		return false;
	}
	
	/**
	 * Get the forms actions
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return array of action objects
	 */
	public function get_actions() {
		return $this->actions;
	}
	
	/**
	 * Gets the errors of a specified element
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $name the elements name to get errors for
	 * 
	 * @return Array|boolean false if there are no errors, or on failure, an array of errors if errors are found
	 */
	public function get_element_errors( $name ) {
		if( isset( $this->elements[$name] ) ) {
			return $this->elements[$name]->get_errors();
		}
	}
	
	/**
	 * Collect all the errors for the form
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return array|boolean false if there are no errors, or on failure, an array of errors if errors are found
	 */
	public function get_errors() {
	
		$errors = false;
	
		foreach( $this->elements as $element ) {
			$element_errors = $element->get_errors();
			if( $element_errors !== false ) {
				$errors[$element->get_name()] = $element_errors;
			}
		}
		return $errors;
	}
	
	/**
	 * Get the HTML for rendering this group
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses self::get_open_form_html
	 * @uses self::get_close_form_html
	 * @uses Element::get_html
	 *
	 * @return string the HTML to render this group
	 */
	public function get_html() {
	
		$html = $this->get_open_form_html();
		
		if( isset( $this->components ) ) {
			foreach( $this->components as $component ) {
				$html .= $component->get_html();
			}
		}
		
		$html .= $this->get_close_form_html();
		return $html;
	}
	
	/**
	 * Get the HTML to open a form
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @return string the HTML for the complete <form> tag
	 */
	public function get_open_form_html() {
		
		$html = '<form';
		
		if( isset( $this->action ) ) {
			$html .= ' action="' . $this->action .'"';
		}
		
		if( isset( $this->method ) ) {
			$html .= ' method="' . $this->method .'"';
		}
		
		if( !empty( $this->attributes ) ) {
			$html .= ' ';
			foreach( $this->attributes as $attribute ) {
				$html .= $attribute->name . '="' . $attribute->value . '" ';
			}
		}
		
		$html .= '>';
		
		return $html;
	}
	
	/**
	 * Get the HTML to close a form
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the HTML for closing a <form> tag
	 */
	public function get_close_form_html() {
		return '</form>';
	}
	
	/**
	 * Set the form method
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $method the new method for the form
	 * @return boolean true on success, false on failure
	 */
	public function set_method( $method ) {

		if( is_string( $method ) ) {
			$this->method = $method;
			return true;
		}
		return false;
	}
	
	/**
	 * Set the form action
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $action the new action for the form
	 * @return boolean true on success, false on failure
	 */
	public function set_action( $action ) {
		
		if( is_string( $action ) ) {
			$this->action = $action;
			return true;
		}
		return false;
	}
	
	/**
	 * Set the order of a element or group
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::set_order
	 * @uses Group::set_order
	 * 
	 * @param string $name
	 * @param int $order
	 * 
	 * @return boolean true on success, false on failure
	 */
	public function set_order( $name, $order ) {
		
		if( !is_string( $name ) ) {
			return false;
		}
		
		if( !is_numeric( $order ) ) {
			return false;
		}
		
		if( isset( $this->elements[$name] ) ) {
			$this->elements[$name]->set_order( $order );
			$this->prepare_components();
			return true;
		}
		
		if( isset( $this->groups[$name] ) ) {
			$this->groups[$name]->set_order( $order );
			$this->prepare_components();
			return true;
		}
		return false;		
	}
	
	/**
	 * Prepares the form componenets
	 * 
	 * Combines the elements array and the groups array, and then sorts the combined array by the order property of each element / group.
	 * Any elements with the same name as a group will be overwriten by the group
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Tag::_element_sort
	 */
	public function prepare_components() {
		
		$priorities = array();
		$order = array();
		
		if( isset( $this->elements ) && isset( $this->groups ) ) {
			$components = $this->elements + $this->groups;
		}
		
		if( isset( $this->elements ) ) {
			$components = $this->elements;
		}
				
		if( isset( $this->groups ) ) {
			$components = $this->groups;
		}
		
		foreach( $components as $component ) {	
			$priorities[$component->get_order()][] = $component;
		}
		
		ksort( $priorities );
		
		foreach( $priorities as $items ) {			
			foreach( $items as $item ) {
				$order[$item->get_name()] = $item;
			}
		}
		
		if( isset( $order ) ) {
			$this->components = $order;
		}
	}
	
	/**
	 * Add elements to the form
	 * 
	 * This method will overwrite any existing elements by default
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
						
						if( !isset( $element['config'] ) ) {
							$element['config'] = '';
						}
						
						if( !isset( $element['attributes'] ) ) {
							$element['attributes'] = '';
						}
						
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
		return $added;
	}
	
	/**
	 * Add groups to the form
	 * 
	 * This method will overwrite any existing groups by default
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Group::get_name
	 * 
	 * @param array $groups an array of groups, or group configurations to add to this group
	 * @param boolean $overwrite wheather a group with the same name as a existing group should overwrite that group
	 * 
	 * @return boolean|array
	 */
	public function add_groups( $groups, $overwrite = true  ) {
	
		$added = false;
		
		if( !is_array( $groups ) ) {
			return false;
		}
	
		foreach( $groups as $group ) {
			if( $group instanceof Group || is_subclass_of( $group, 'Group' ) ) {
				$this->groups[$group->get_name()] = $group;
				$added[] = $group->get_name();
			}
			
			if( is_array( $group ) ) {
				if( isset( $group['name'] ) && is_string( $group['name'] ) ) {
					if( class_exists( 'Group' ) ) {
						$object = new Group( $group['name'], $group['config'], $group['attributes'] );
						if( $object instanceof Group ) {
							if( !isset( $this->groups[$object->get_name()] ) || ( isset( $this->groups[$object->get_name()] ) && $overwrite === true ) ) {
								$this->groups[$object->get_name()] = $object;
								$added[] = $object->get_name();
							}
						}
					}
				}
			}
		}
		return $added;
	}
	
	/**
	 * Adds actions to the form
	 * 
	 * Will overwrite existing actions with the same name by default
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses self::_add_action()
	 * 
	 * @param array $actions an array of action configurations to be created an added
	 * @param boolean $overwrite whether to overwrite any existing actions with the same name
	 * 
	 * @return boolean|array false on failure, or an array of action identifyers that where successfully added
	 */
	public function add_actions( $actions, $overwrite = true ) {
		
		$added = false;
		
		if( !is_array( $actions ) ) {
			return $added;
		}
		
		foreach( $actions as $action ) {
			
			if( $action instanceof Action || is_subclass_of( $action, 'Action' ) ) {
				$result = $this->_add_action( $action['name'], $action['type'], $action['config'], $overwrite );
				$added[] = $result;
			}
			
			if( is_array( $action ) ) {
				if( isset( $action['name'] ) || isset( $action['type'] ) || isset( $action['config'] ) ) {
					$result = $this->_add_action( $action['name'], $action['type'], $action['config'], $overwrite );
				}
			}
			
			if( $result !== false ) {
				$added[] = $result;
			}
		}
		return $added;
	}
	
	/**
	 * Removes elements from the form
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::get_name()
	 * 
	 * @param array $elements array of element names and/or objects to be removed fromt he group
	 * 
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
	
	/**
	 * Remove groups from the form
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Group::get_name
	 * 
	 * @param array $groups an array of group names to be removed
	 * 
	 * @return boolean|array false on failure, or the group names that where removed on success
	 */
	public function remove_groups( $groups ) {
	
		$removed = false;
	
		if( !is_array( $groups ) ) {
			return $removed;
		}
	
		foreach( $groups as $group ) {
			if( is_string( $group ) ) {
				$name = $group;
			}
			if( $group instanceof Group ) {
				$name = $group->get_name();
			}
			if( isset( $this->groups[$name] ) ) {
				unset( $this->groups[$name] );
				$removed[] = $name;
			}
		}
		return $removed;
	}
	
	/**
	 * Removes existing actions from the form
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param array $actions an array of action names to be removed
	 * 
	 * @return boolean|array false on failure, or an array of action names that were removed
	 */
	public function remove_actions( $actions ) {
		
		$removed = false;
		
		if( !is_array( $actions ) ) {
			return $removed;
		}
		
		foreach( $actions as $action ) {
			
			if( !is_string( $action ) ) {
				continue;
			}
			
			if( isset( $this->actions[$action] ) ) {
				unset( $this->actions[$action] );
				$removed[] = $action;
			}
		}
		return $removed;
	}
	
	/**
	 * Match any POST data with this form
	 * 
	 * If any POST keys match any fields in this form, the elements value property will be updated to match
	 * what is stored in the post array
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Element::set_value()
	 */
	public function collect_post_data() {
		
		if( isset( $_POST ) ) {
			foreach( $_POST as $key => $val ) {
				if( isset( $this->elements[$key] ) ) {
					$this->elements[$key]->set_value( $val );
				}
			}
		}
	}
	
	/**
	 * Check to see if the form is valid
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses self::get_form_errors
	 * 
	 * @return boolean true if the form is valid, or false if there are errors
	 */
	public function validate() {
		
		$errors = $this->get_form_errors();
		
		if( $errors === false ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Adds an action to the form object
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @uses Action::get_name()
	 *
	 * @param string $name the name of the action to be added
	 * @param string $type the type of action to be added, this must match an existing actions class
	 * @param array $config any additional confiuration requirements for the specificed action type
	 * @param boolean $overwrite wheather to overwrite an existing action with the same name or not
	 * 
	 * @return boolean|string false on failure, or the name of the added action of success
	 */
	private function _add_action( $name, $type, $config, $overwrite = true ) {
		
		$result = false;
		
		if( !class_exists( $type ) || !is_subclass_of( $type, 'Action' ) ) {
			return false;
		}
		
		$action = new $type( $name, $config );
		
		if( isset( $action ) ) {
			if( $overwrite === true ) {
				$this->actions[$action->get_name()] = $action;
				$result = $action->get_name();
					
			} elseif( !isset( $this->actions[$action->get_name()] ) && $overwrite === false ) {
				$this->actions[$action->get_name()] = $action;
				$result = $action->get_name();
			}
		}
		return $result;
	}
	
	/**
	 * Performs all actions attached to the form
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @uses Action::do_action()
	 * 
	 * @return boolean|array false if no actions were run, or an associative array of actions return values on success
	 */
	public function do_actions() {
		
		$results = false;
		
		if( isset( $this->actions ) ) {
			foreach( $this->actions as $action ) {
				$results[$action->get_name()] = $action->do_action();
			}
		}
		return $results;
	}
}