<?php
/**
 * Key Retirement Solutions Form Framework
 *
 * @package Keyrs Forms Framework
 * @subpackage Actions
 * 
 * @link http://www.keyrs.co.uk
 * @author Jack Neary
 */

abstract class Form_Helper {
	
	/**
	 * @var array - Array of attribute objects
	 */
	protected $attributes;
	
	/**
	 * Adds additional attributes
	 * 
	 * Is used to add either a single or multiple attributes. The attributes parameter must be a single dimensional array where the key equals the name of
	 * the attribute, and the value equals the attributes value, which equate to the following attribute HTML: key="value". This method can be used to update
	 * existing attributes, but no checks will be done on whether the attribute already exists. If this functionality is required, used update_attributes
	 * instead. The default behaviour is to overwrite existing attributes, but this can be disabled by passing anything other than true ( ideally false )
	 * as the $overwrite parameter.
	 * 
	 * This is a wrapper method for _add_attribute
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @uses _add_attribute
	 * 
	 * @param array $attributes an array of arrtibutes to be added
	 * @param bool $overwrite whether to overwrite existing attributes if they are provided, defaults to true
	 * 
	 * @return boolean|string|array false is nothing was added, or a string, or an array of name stings of added attributes on success
	 */
	public function add_attributes( $attributes, $overwrite = true ) {
		
		$added = false;
		
		if( $attributes instanceof Attribute && !in_array( $attributes->get_name(), $this->reserved_attributes ) ) {
			$this->attributes[$attributes->get_name()] = $attributes;
			$result = $attributes->get_name();
			return $result;
		}
		
		if( !is_array( $attributes ) ) {
			return $added;	
		}
		
		foreach( $attributes as $key => $val ) {
			
			if( $val instanceof Attribute && !in_array( $attributes->get_name(), $this->reserved_attributes ) ) {
				$this->attributes[$attributes->get_name()] = $val;
				$added[] = $attributes->get_name();
				continue;
			}
			
			if( in_array( $key, $this->reserved_attributes ) ) {
				continue;
			}
			
			$result = $this->_add_attribute( $key, $val, $overwrite );
			if( $result !== false ) {
				$added[] = $result;
			}	
		}
		return $added;
	}
	
	/**
	 * Updates an existing attributes
	 * 
	 * Is used to update either a single or multiple existing attributes. The attributes parameter must be an array containing either the configuration
	 * for a single attribute, or an array of configurations for multiple attributes. Confurations are simply an array with the keys "name" and "value"
	 * which equate to the following attribute HTML: name="value". The method will only update existing attributes, if a none existing attribute is passed,
	 * it will be ignored. If you require the functionality to add missing attributes, use add_attributes instead.
	 * 
	 * This is a wrapper method for _add_attribute
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @uses _add_attribute
	 * 
	 * @param array $attributes an array of arrtibutes to be updated
	 * 
	 * @return boolean|string|array false is nothing was updated, or a string / array of names of updated attributes on success
	 */
	public function update_attributes( $attributes ) {
		
		$updated = false;
		
		if( !is_array( $attributes ) ) {
			return $updated;
		}
		
		foreach( $attributes as $key => $val ) {
			if( isset( $this->attributes[$key] ) ) {
				$result = $this->_add_attribute( $key, $val );
				if( $result !== false ) {
					$updated[] = $result;
				}
			}
		}
		return $updated;
	}
	
	/**
	 * Removes existing attributes
	 * 
	 * Is used to remove either a single or multiple existing attributes. The attributes parameter must be either a string or an array of strings containing 
	 * the names of attributes that should be deleted. The method will check that the attribute exists before it attempts to delete it.
	 * 
	 * This is a wrapper method for _remove_attribute
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @uses _remove_attribute
	 * 
	 * @param Ambigous <array, string> $attributes string or an array of name strings of attribute to be removed
	 * 
	 * @return Ambigous <boolean, string, array> false is nothing was removed, or a string, or an array of stings of removed attributes on success
	 */
	public function remove_attributes( $attributes ) {
		
		$deleted = false;
		
		if( is_string( $attributes ) ) {
			$result = $this->_remove_attribute( $attributes );
		}
		
		if( is_array( $attributes ) ) {
			foreach( $attributes as $attribute ) {
				$result = $this->_remove_attribute( $attribute );
				if( $result !== false ) {
					$removed[] = $result;
				}
			}
		}
		return $deleted;
	}
	
	/**
	 * Add classes to the class attribute
	 * 
	 * Is used to add additional classes to the "class" attribute. If the class attribute does not already exist, it will be created. The $values
	 * parameter must be either a sting, or an array of strings, to be added to the class attributes value. Classes will automatically be spaced,
	 * there is no need to include white space in the classes passed, as this will be trimed.
	 * 
	 * This is a wrapper method for _add_class
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @uses _add_class
	 * 
	 * @param Ambigous <array, string> $values string for single values, or an array of values for multiple additions
	 * 
	 * @return Ambigous <boolean, string, array> false is nothing was added, or a string, or an array of stings of added classes on success
	 */
	public function add_class( $values ) {
		
		if( is_string( $values ) ) {
			$added = $this->_add_class( $values );
		}

		if( is_array( $values ) ) {
			foreach( $values as $value ) {
				$result = $this->_add_class( $value );
				if( $result !== false ) {
					$added[] = $result;
				}
			}
		}
		return $added;
	}
	
	/**
	 * Removes classes from the class attribute 
	 * 
	 * Is used to remove classes from the "class" attribute. If the class attribute does not already exist, nothing will be removed and the method
	 * will return false. The $values parameter must be either a sting, or an array of strings, to be removed from the class attributes value. Classes
	 * will automatically be spaced, there is no need to include white space in the classes passed, as this will be trimed.
	 * 
	 * This is a wrapper method for _remove_class
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @uses _remove_class
	 * 
	 * @param Ambigous <array, string> $values string for single values, or an array of values for multiple removals
	 * 
	 * @return Ambigous <boolean, string, array> false on failure, or the name of the removed class or an array of classes on success
	 */
	public function remove_class( $values ) {
		
		$removed = false;
		
		if( is_string( $values ) ) {
			$removed = $this->_remove_class( $values );
		}
		
		if( is_array( $values ) ) {
			foreach( $values as $value ) {
				$result = $this->_remove_class( $value );
				if( $result !== false ) {
					$removed[] = $result;
				}
			}
		}
		return $removed;
	}
	
	/**
	 * Add a new attribute
	 * 
	 * Creates and adds a new attribute to the attributes array, or can be used to update the values of an existing attribute.
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @uses Attribute
	 * 
	 * @param string $name the name of the attribute to be added
	 * @param string $value the value of the attribute to be added
	 * @param bool $overwrite wheather to overwrite an existing attribute of the same name, or not
	 * 
	 * @return Ambigous <boolean, string> false on failure, or the name of the added attribute on success
	 */
	private function _add_attribute( $name, $value, $overwrite = true ) {
		
		$result = false;
		$attribute = new Attribute( $name, $value );
		
		if( isset( $attribute ) ) {
			
			if( $overwrite === true ) {
				$this->attributes[$attribute->get_name()] = $attribute;
				$result = $attribute->get_name();
					
			} elseif( !isset( $this->attributes[$attribute->get_name()] ) && $overwrite === false ) {
				$this->attributes[$attribute->get_name()] = $attribute;
				$result = $attribute->get_name();
			}
		}
		return $result;
	}
	
	/**
	 * Remove an existing attribute
	 * 
	 * Removes an existing attribute from the attributes array.
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @param string $name the name of the attribute to be removed from the object
	 * 
	 * @return boolean|string false on failure, or the name of the removed attribute on success
	 */
	private function _remove_attribute( $name ) {
		
		$removed = false;
		
		if( isset( $this->attributes[$name] ) ) {
			unset( $this->attributes[$name] );
			$removed = $name;
		}
		return $removed;
	}
	
	/**
	 * Add a class to the class attribute
	 * 
	 * Adds an additional class to the class attribute, attempts to add an existing class will be ignored
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @param string $value the class to be added to the class attribute
	 * 
	 * @return boolean|string false on failure, or the class that was added on success
	 */
	private function _add_class( $value ) {
		
		$added = false;
		$value = trim( $value );
		
		if( isset( $this->attributes['class'] ) ) {
			if( strpos( $this->attributes['class']->value, $value ) === false ) {
				$this->attributes['class']->value .= ' ' . $value;
				$added = $value;
			}
		} else {
			$this->_add_attribute( 'class', $value );
			$added = $value;
		}
		return $added;
	}
	
	/**
	 * Remove a class from the class attribute
	 * 
	 * Removes an existing class from the class attribute
	 * 
	 * @since 1.0
	 * @author Jack Neary
	 * 
	 * @param string $value the class to be removed from the class attribute
	 * 
	 * @return boolean|string false if nothing is removed, or the class that was removed on success
	 */
	private function _remove_class( $value ) {
		
		$removed = false;
		$value = trim( $value );
		
		if( isset( $this->attributes['class'] ) ) {
			if( strpos( $this->attributes['class']->value, $value ) !== false ) {
				$classes = explode( ' ', $this->attributes['class']->value );
				if( ( $key = array_search( $value, $classes ) ) !== false ) {					
					unset( $classes[$key] );
					$this->attributes['class']->value = join( ' ', $classes );
					$removed = $value;
				}
			}
		}
		return $removed;
	}
}