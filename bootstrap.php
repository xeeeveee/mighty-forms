<?php
/**
 * Plugin Name: Mighty Form Framework
 * Plugin URI: www.mightystudios.net
 * Description:
 * Version: 0.1
 * Author: Jack Neary
 * Author URI:
 * Text Domain: mighty-forms
 *
 * Key Retirement Solutions Form Framework
 *
 * @package Mighty Forms Framework
 * 
 * @link http://www.mightystudios.net
 * @author Jack Neary
 */

/*
 * TODO: Explore auto loading this
 */

require_once( 'interfaces/orderable.php' );
require_once( 'interfaces/renderable.php' );
require_once( 'interfaces/actionable.php' );
require_once( 'interfaces/validatable.php' );

require_once( 'lib/formhelper.php' );
require_once( 'lib/group.php' );
require_once( 'lib/label.php' );
require_once( 'lib/attribute.php' );
require_once( 'lib/tooltip.php' );
require_once( 'lib/element.php' );
require_once( 'lib/form.php' );
require_once( 'lib/action.php' );
require_once( 'lib/validation.php' );

require_once( 'elements/select.php' );
require_once( 'elements/text.php' );
require_once( 'elements/email.php' );
require_once( 'elements/password.php' );
require_once( 'elements/submit.php' );
require_once( 'elements/hidden.php' );
require_once( 'elements/multiselect.php' );
require_once( 'elements/checkbox.php' );
require_once( 'elements/multicheckbox.php' );
require_once( 'elements/radio.php' );

require_once( 'actions/sendemail.php' );

require_once( 'validators/required.php' );