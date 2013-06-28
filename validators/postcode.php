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

class Postcode extends Validation implements Validatable {
	
	/**
	 * @var string - the type of validation 
	 */
	protected $type = 'postcode';
	
	/**
	 * @var string - the default error message for this type
	 */
	protected $default_error = 'Valid UK postcode expected';
	
	/**
	 * @var string - the regular expresion to be used to check the postcode
	 * 
	 * Regular expression used by Zend Framework 2.1.4
	 * @link http://framework.zend.com/
	 */
	protected $regex = 'GIR[ ]?0AA|((AB|AL|B|BA|BB|BD|BH|BL|BN|BR|BS|BT|CA|CB|CF|CH|CM|CO|CR|CT|CV|CW|DA|DD|DE|DG|DH|DL|DN|DT|DY|E|EC|EH|EN|EX|FK|FY|G|GL|GY|GU|HA|HD|HG|HP|HR|HS|HU|HX|IG|IM|IP|IV|JE|KA|KT|KW|KY|L|LA|LD|LE|LL|LN|LS|LU|M|ME|MK|ML|N|NE|NG|NN|NP|NR|NW|OL|OX|PA|PE|PH|PL|PO|PR|RG|RH|RM|S|SA|SE|SG|SK|SL|SM|SN|SO|SP|SR|SS|ST|SW|SY|TA|TD|TF|TN|TQ|TR|TS|TW|UB|W|WA|WC|WD|WF|WN|WR|WS|WV|YO|ZE)(\d[\dA-Z]?[ ]?\d[ABD-HJLN-UW-Z]{2}))|BFPO[ ]?\d{1,4}';
	
	/**
	 * Overrides the parents constructor
	 * 
	 * The parents constructure is called to populate all the common elements between validation rules
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $name the name for this required rules
	 * @param array $config any additional configuration parameters - none required for this type
	 */
	public function __construct( $name, $config = null ) {
		
		$this->error = $this->default_error;
		parent::__construct( $name, $config );
	}
	
	/**
	 * Checks if a value passes this validation
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @param string $value
	 * 
	 * @return boolean true for valid, false for invalid.
	 */
	public function check( $value ) {
		
		if( preg_match( $this->regex, $value ) ) {
			return true;
		} else {
			return false;
		}
	}
}