<?php
/**
 * Validator Class
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package Project
 */

# =========================================================================
# VALIDATOR CLASS
# =========================================================================

class Validator {
	# ---------------------------------------------------------------------
	# ATTRIBUTES
	# ---------------------------------------------------------------------
	
	/**
	 * The Current Value being Validated
	 * @access public
	 * @var Mixed
	 */
	public $cur_val;
	/**
	 * The type of the Current Value
	 * @access public
	 * @var String
	 */
	public $cur_type;
	/**
	 * The Max Length of the Current Value
	 * @access public
	 * @var Integer
	 */
	public $length;
	/**
	 * The result of the validation
	 * @access public
	 * @var Mixed
	 */
	public $result;
	/**
	 * Current Error Message of the last Validation process
	 * @access public
	 * @var String
	 */
	public $error_message;
	/**
	 * Error log of all error messages for this object's instance.
	 * @access public
	 * @var Array
	 */
	public $error_log;
	/**
	 * Number of error messages in the error log
	 * @access public
	 * @var Integer
	 */
	public $error_count;
	
	# ---------------------------------------------------------------------
	# FUNCTIONS
	# ---------------------------------------------------------------------
	
	/**
	 * Constructor for initializing the Validator Object.
	 */
	function __construct() {
		# Initialize Attributes
		$this->cur_val							= 0;
		$this->cur_type							= "Integer";
		$this->length							= 0;
		$this->result							= 0;
		$this->error_message					= "";
		$this->error_log						= array();
		$this->error_count						= 0;
	}
	
	/**
	 * Primary Validation Function
	 * @param Mixed $val The Value for which to validate against.
	 * @param String $type The Type of the Value to check against.
	 * @return Mixed The result of the Validation. If validation fails, the sanitized version of the value will be returned.
	 */
	function validate($val, $type="Integer", $length=0) {
		# Set Attributes
		$this->cur_val							= $val;
		$this->cur_type							= $type;
		$this->length							= $length;
		
		# Handle Validation
		if ($type == "Integer") {
			$this->result						= $this->validate_int();
		}
		else if ($type == "String") {
			$this->result						= $this->validate_str();
		}
		else if ($type == "Email") {
			$this->result						= $this->validate_email();
		}
		else if ($type == "AlphaNumeric") {
			$this->result						= $this->validate_alphanumeric();
		}
		else {
			$this->result						= $this->validate_str();
		}
		
		# Handle Length Check
		$this->result							= ($length)? $this->length_check() : $this->result;
		
		# Return Validated Result
		return $this->result;
	}
	
	/**
	 * Validates and Sanitizes Integers.
	 * @return Integer
	 */
	function validate_int() {
		# Check if the value is an integer
		if (is_int($this->cur_val)) {
			# Remove any existing error message
			$this->error_message				= "";
			
			# Return Value
			return $this->cur_val;
		}
		else {
			# Set Error Message
			$this->set_error("Validation for integer ({$this->cur_val}) failed. This is type " . gettype($this->cur_val));
			
			# Return Integer Value
			return intval($this->cur_val);
		}
	}
	
	/**
	 * Validates and Sanitizes Strings.
	 * @return String
	 */
	function validate_str() {
		# Remove any existing error message
		$this->error_message					= "";
		
		# Return Sanitized String
		return mysql_real_escape_string($this->cur_val);
	}
	
	/**
	 * Validates and Sanitizes Email Addresses
	 * @return String Returns the email address if validation is successful, otherwise it returns a blank string.
	 */
	function validate_email() {
		# Check Value is an Email Address
		if ($this->check_email_address($this->cur_val)) {
			# Remove any existing error message
			$this->error_message				= "";
			
			# Return Email
			return $this->cur_val;
		}
		else {
			# Set Error Message
			$this->set_error("Validation for email address ({$this->cur_val}) failed. This is type " . gettype($this->cur_val));
			
			# Return Blank String
			return "";
		}
	}
	
	/**
	 * Validates and Sanitizes AlphaNumerics.
	 * @return Returns the alphanumeric component of the current value.
	 */
	function validate_alphanumeric() {
		# Check Value is Alphanumeric
		if (ctype_alnum($this->cur_val)) {
			# Remove any existing error message
			$this->error_message				= "";
			
			# Return Value
			return $this->cur_val;
		}
		else {
			# Set Error Message
			$this->set_error("Validation for alphanumeric ({$this->cur_val}) failed. This is type " . gettype($this->cur_val));
			
			# Return AlphaNumeric version of value.
			return preg_replace("#[^a-zA-Z0-9_]#i", "", $this->cur_val);
		}
	}
	
	/**
	 * Validates and Sanitizes Floats.
	 * @return Returns the float component of the current value.
	 */
	function validate_float() {
		# Check if the value is a foat
		if (is_float($this->cur_val)) {
			# Remove any existing error message
			$this->error_message				= "";
			
			# Return Value
			return $this->cur_val;
		}
		else {
			# Set Error Message
			$this->set_error( "Validation for float ({$this->cur_val}) failed. This is type " . gettype($this->cur_val));
			
			# Return Float Value
			return floatval($this->cur_val);
		}
	}
	
	/**
	 * Validates and Sanitizes Dates.
	 * @return Returns the date component of the current value.
	 */
	function validate_date() {
		# Check the date is in ISO date format
		if (ereg('(19|20)[0-9]{2}[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])', $this->cur_val)) {
			# Remove any existing error message
			$this->error_message				= "";
			
			# Return Value
			return $this->cur_val;
		}
		else {
			# Set Error Message
			$this->set_error("Validation for date ({$this->cur_val}) failed. This is type " . gettype($this->cur_val));
			
			# Return Blank Date
			return "0000-00-00";
		}
	}
	
	/**
	 * Validates and Sanitizes Times.
	 * @return Returns the times component of the current value.
	 */
	function validate_time() {
		# Check the time is in ISO time format
		if (ereg('([0-9]{2}[: /.]([0-9]{2})[: /.]([0-9]{2})', $this->cur_val)) {
			# Remove any existing error message
			$this->error_message				= "";
			
			# Return Value
			return $this->cur_val;
		}
		else {
			# Set Error Message
			$this->set_error("Validation for time ({$this->cur_val}) failed. This is type " . gettype($this->cur_val));
			
			# Return Blank Time
			return "00:00:00";
		}
	}
	
	/**
	 * Check's the length of the input
	 */
	function length_check() {
		# Reset Error Message
		$this->error_message					= "";
		
		# Check that a length is set
		if ($this->length) {
			# Check Length
			if (strlen($this->cur_val) > $this->length) {
				# Set Error Message
				$this->set_error("Validation for length of input ({$this->cur_val}) failed. The input length is " . strlen($this->cur_val) . " and the max length is {$this->length}.");
				
				# Return Truncated Result
				return substr($this->cur_val, 0, $this->length);
			}
			else {
				return $this->cur_val;
			}
		}
		else {
			return $this->cur_val;
		}
	}
	
	/**
	 * Checks that the email address passed to the function is a standards compliant email address.
	 * @param String $email The email address for which to validate.
	 * @return Boolean
	 */
	function check_email_address($email) {
		# Check @ symbol and lengths
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			return false;
		}
		
		# Split Email Address into Sections
		$email_array							= explode("@", $email);
		$local_array							= explode(".", $email_array[0]);
		
		# Validate Local Section of the Email Address
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
				return false;
			}
		}
		
		# Validate Domain Section of the Email Address 
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			
			# Check the number of domain elements
			if (sizeof($domain_array) < 2) {
				return false;
			}
			
			# Sanity Check All Email Components
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
					return false;
				}
			}
		}
		
		# If All Validation Checks have Passed then Return True
		return true;
	}
	
	/**
	 * Sets the current error message and adds to the error log.
	 * @param $err String The error message
	 */
	function set_error($err) {
		# Set Current Error Message
		$this->error_message					= $err;
		
		# Add to Error Log
		$this->error_log[]						= $err;
		
		# Increment Error Counter
		$this->error_count++; 
	}
	
	/**
	 * Retrieves the last error message generated.
	 * @return String
	 */
	function error() {
		return $this->error_message;
	}
	
	/**
	 * Clears the error log
	 */
	function reset_error_log() {
		$this->error_count						= 0;
		$this->error_log						= array();
	}
}

# =========================================================================
# THE END
# =========================================================================

?>