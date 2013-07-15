<?php
/**
 * Project : Form Class
 * 
 * @author Ralfe Poisson <ralfe@implyit.co.za>
 * @version 1.0
 * @copyright Copyright (C) Imply Development CC 2012
 * @package Project
 * 
 */

# ==========================================================================================
# CLASS
# ==========================================================================================

class Form {
	
	# --------------------------------------------------------------------------------------
	# ATTRIBUTES
	# --------------------------------------------------------------------------------------
	
	var $action;
	var $fields;
	var $method;
	var $id;
	
	# --------------------------------------------------------------------------------------
	# METHODS
	# --------------------------------------------------------------------------------------
	
	/**
	 * Constructor
	 * 
	 * Initialise default values for Model attributes 
	 */
	function __construct($action, $method="POST", $id="item_form") {
		# Initialise Variables
		$this->id														= $id;
		$this->action													= $action;
		$this->fields													= array();
		$this->method													= $method;
	}
	
	/**
	 * Add Field
	 * 
	 * Add a Field to the Form
	 * 
	 * @param $label String
	 * @param $type String
	 * @param $name String
	 * @param $value String
	 */
	function add($label, $type, $name, $value="") {
		$this->fields[]													= array(	"label"		=> $label,
																					"type"		=> $type,
																					"name"		=> $name,
																					"value"		=> $value,
																					"options"	=> ""
																				);
	}
	function add_select($label, $name, $default, $values) {
		$this->fields[]													= array(	"label"		=> $label,
																					"type"		=> "select",
																					"name"		=> $name,
																					"value"		=> $default,
																					"options"	=> $values
																				);
	}
	
	/**
	 * Generate Input
	 * 
	 */
	function generate_input($type, $name, $value="", $options="") {
		if ($type														== "text") {
			return "<input class='textfield' type='text' name='{$name}' value=\"{$value}\" />";
		}
		else if ($type													== "textarea") {
			return "<textarea name='{$name}' rows='3' cols='60'>{$value}</textarea>";
		}
		else if ($type													== "hidden") {
			return "<input type='hidden' name='{$name}' value=\"{$value}\" />";
		}
		else if ($type													== "submit") {
			return "<input class='btn' type='submit'  id='submit' value=\"{$value}\" />";
		}
		else if ($type													== "password") {
			return "<input type='password' name=\"$name\" value=\"{$value}\" />";
		}
		else if ($type													== "checkbox") {
			return "<input type='checkbox' name='{$name}' " . is_checked($value) . "/>";
		}
		else if ($type													== "date") {
			return "<input type='text' class='date' id='datepicker' name='{$name}' value=\"{$value}\" />";
		}
		else if ($type													== "select") {
			return generate_select($name, $options, $value);
		}
		else if ($type													== "start_timepicker") {
			return "<input type='text' id='timepicker_start' name='timepicker_start' >";
		}
		else if ($type													== "end_timepicker") {
			return "<input type='text' id='timepicker_end' name='timepicker_end'>";
		}
		else if ($type													== "multidatepicker") {
			return "<div class='wrapper'><div id='jrange' class='dates'><input type='text' name='event_date'/>
    				<div></div></div></div>";
		}
		else if ($type													== "static") {
			return "<div class='form_static'>{$value}</div>";
		}
		else if ($type													== "other") {
			return $name;
		}
		else {
			# Check if data type is defined by a class
			$class_name													= DataElement::class_name($type);
			if (class_exists($class_name)) {
				# Create Element
				$element												= DataElement::Factory($type);
				
				# Return Element's HTML
				return $element->generate();
			}
		}
	}
	
	public function generate_fields() {
		# Generate Fields
		$fields															= "";
		foreach ($this->fields as $field) {
			if ($field['type']											== "hidden") {
				$fields													.= "
					" . $this->generate_input($field['type'], $field['name'], $field['value'], $field['options']) . "
				";
			}
			else if ($field['type']										== "submit") {
				$fields													.= "
					" . $this->generate_input($field['type'], $field['name'], $field['value'], $field['options']) . "
				";
			}
			else {
				$fields													.= "
				<div class='control-group'>					
					<label class='control-label'>{$field['label']}</label>					
					<div class='controls'>
						" . $this->generate_input($field['type'], $field['name'], $field['value'], $field['options']) . "
					</div>
				</div>
				";
			}
		}
		
		# Return Fields
		return $fields;
	}
	
	/**
	 * Generate
	 * 
	 * Generate HTML of the form.
	 */
	public function generate() {
		# Generate Fields
		$fields															= $this->generate_fields();
		
		# Generate HTML
		$html															= "
		<form id=\"{$this->id}\" class='form form-horizontal' method=\"{$this->method}\" action=\"{$this->action}\">
			{$fields}
		</form>
		";
		
		# Return HTML
		return $html;
	}
	
	function generate_inline() {
		# Generate Fields
		$fields															= "";
		foreach ($this->fields as $field) {
			if ($field['type']											== "hidden") {
				$fields													.= "
					" . $this->generate_input($field['type'], $field['name'], $field['value'], $field['options']) . "
				";
			}
			else {
				$fields													.= "
				<div class='form_element'>
					" . $this->generate_input($field['type'], $field['name'], $field['value'], $field['options']) .     " {$field['label']}  
						<br/><br/>
				</div>
				";
			}
		}
		
		# Generate HTML
		$html															= "
		<form id=\"{$this->id}\" method=\"{$this->method}\" action=\"{$this->action}\">
			{$fields}
		</form>
		";
		
		# Return HTML
		return $html;
	}
	public function get_str($name) {
		return (isset($_REQUEST[$name]))? htmlentities($_REQUEST[$name]) : "";
	}
	
	public function get_int($name) {
		return (isset($_REQUEST[$name]))? intval($_REQUEST[$name]) : "";
	}
	
}

# ==========================================================================================
# THE END
# ==========================================================================================

?>