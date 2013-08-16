<?php
/**
 *Project
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @package Project 
 */

 # ==================================================================================
 # CLASS
 # ==================================================================================
 
 class Passwordrecovery extends  Model {
 	
	public function __construct($uid=0) {
		# Set Table
		$this->table													= "password_change_request";
		
		# Initialize UID from Parameter
		$this->uid														= $uid;
		if ($this->uid) {
			$this->load();
		}
	}
	
	/**
	 * Displays the passwordrecover form
	 */
	public function item_form($action) {
	# Global Variables
		global $_db, $cur_page, $_GLOBALS;
		
		# Create Form Object
		$form															= new Form($action, "POST", "item_form");
		//			Label				Type					Name						Value
		$form->add(""					, "hidden"				, "uid"						, $this->uid);
		$form->add("Email Address/Username"		, "text"				, "name"			, '');
		$form->add(""					, "submit"				, "submit"					, "Submit");
		
		# Generate HTML
		$html															= $form->generate();
		
		# Return HTML
		return $html;
	
	}
	
	
 }
