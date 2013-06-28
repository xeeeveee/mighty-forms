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

class Send_Email extends Action implements Actionable {
	
	/**
	 * @var string - the address to send the email too
	 */
	protected $to;
	
	/**
	 * @var string - the subject for the email
	 */
	protected $subject;
	
	/**
	 * @var string - the content for the email
	 */
	protected $content;
	
	/**
	 * @var string - header information for the email
	 */
	protected $headers;
	
	/**
	 * Action constructor
	 * 
	 * Overwrites the parent action constructor, calls it manually at the end to ensure the name
	 * property is still set.
	 * 
	 * The configuration array will require the following values:
	 * - 'to'
	 * - 'subject'
	 * - 'content'
	 * - 'headers'
	 * 
	 * @author Jack Neary
 	 * @since 1.0
 	 * 
 	 * @param string $name the name of this action
	 * @param array $config the configuration variables for the action
	 */
	public function __construct( $name, $config = null ) {
		
		if( isset( $config ) ) {
			if( isset( $config['to'] ) ) {
				$this->to = $config['to'];
			}
			
			if( isset( $config['subject'] ) ) {
				$this->subject = $config['subject'];
			}
			
			if( isset( $config['content'] ) ) {
				$this->content = $config['content'];
			}
			
			if( isset( $config['headers'] ) ) {
				$this->headers = $config['headers'];
			}
		}	
		parent::__construct( $name, $config );
	}
	
	/**
	 * Get the emails to address
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the sent to address for the email
	 */
	public function get_to() {
		return $this->to;
	}
	
	/**
	 * Get the emails subject
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the subject for the email
	 */
	public function get_subject() {
		return $this->subject;
	}
	
	/**
	 * Get the emails content
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the content for the email
	 */
	public function get_content() {
		return $this->content;
	}
	
	/**
	 * Get the emails to headers
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @return string the headers for the email
	 */
	public function get_headers() {
		return $this->headers;
	}
	
	/**
	 * Set the emails to address
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string the new to address for the email
	 */
	public function set_to( $to ) {
		
		if( is_string( $to ) ) {
			$this->to = $to;
			return true;
		}		
		return false;
	}
	
	/**
	 * Set the emails subject
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string the new subject for the email
	 */
	public function set_subject( $subject ) {
		
		if( is_string( $subject ) ) {
			$this->subject = $subject;
			return true;
		}
		return false;
	}
	
	/**
	 * Set the emails content
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string the new content for the email
	 */
	public function set_content( $content ) {
		
		if( is_string( $content ) ) {
			$this->content = $content;
			return true;
		}
		return false;
	}
	
	/**
	 * Set the emails headers
	 *
	 * @author Jack Neary
	 * @since 1.0
	 *
	 * @param string the new headers for the email
	 */
	public function set_headers( $headers ) {
		
		if( is_string( $headers ) ) {
			$this->header = $headers;
			return true;
		}
		return false;
	}
	
	/**
	 * Send the email
	 * 
	 * Will not attempt to send the email unless the class properties $to, $subject, $content and $headers are all set,
	 * and will return false if any are missing.
	 * 
	 * @author Jack Neary
	 * @since 1.0
	 * 
	 * @see Actionable::do_action()
	 * @filesource actionable.interface.php
	 * 
	 * @return boolean $result false on failure, or true on success
	 */
	public function do_action() {
		
		$result = false;
		
		if( isset( $this->to ) && isset( $this->subject ) && isset( $this->content ) && isset( $this->headers ) ) {
			$result = mail( $this->to, $this->subject, $this->content, $this->headers );
		}
		
		return $result;
	}
}