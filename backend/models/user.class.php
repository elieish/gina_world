<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package Project
 */

# ==========================================================================================
# CLASS
# ==========================================================================================

class User extends Model {
	
	public $membership;
	
	/**
	 * Constructor
	 * 
	 * Set the Table and the UID of the object.
	 * 
	 * @param $uid Integer: The Unique Identifier of the object.
	 */
	public function __construct($uid=0) {
		# Set Table
		$this->table													= "users";
		
		# Initialize UID from Parameter
		$this->uid														= $uid;
		if ($this->uid) {
			$this->load();
		}
	}
	
	/**
	 * Displays the user form
	 */
	public function item_form() {
		# Global Variables
		global $_db, $cur_page, $_GLOBALS;
		
		# Generate Form
		$form														= new Form("?p=employees&action=save");
		//			Label				Type			Name				Value
		$form->add(""					, "hidden"				, "uid"						, $this->uid);
		$form->add_select("Type"		, "user_type_id"		, $this->user_type_id		, user_type_select());
		$form->add_select("Dept."		, "org_structure_id"	, $this->org_structure_id	, org_structure_select());
		$form->add("Username"			, "text"				, "username"				, $this->username);
		$form->add("Password"			, "password"			, "password"				, $this->password);
		$form->add("First Name"			, "text"				, "first_name"				, $this->first_name);
		$form->add("Last Name"			, "text"				, "last_name"				, $this->last_name);
		$form->add("Email Address"		, "text"				, "email"					, $this->email);
		$form->add("Mobile"				, "text"				, "mobile"					, $this->mobile);
		$form->add("Telephone (Home)"	, "text"				, "tel_home"				, $this->tel_home);
		$form->add("Telephone (Work)"	, "text"				, "tel_work"				, $this->tel_work);
		$form->add("Fax"				, "text"				, "fax"						, $this->fax);
		$form->add("Job Title"			, "text"				, "job_title"				, $this->job_title);
		$form->add(""					, "submit"				, "submit"					, "Save");
		
		# Generate HTML
		$html														= $form->generate();
		
		# Return HTML
		return $html;
	}
	
	public function login($username, $password) {
		# Global Variables
		global $_db;
		
		# Compare to database
		$query															= "	SELECT
																			COUNT(*)
																		FROM
																			`users`
																		WHERE
																			`username` = \"$username\"
																			AND `password` = \"$password\"";
		$auth															= $_db->fetch_single($query);

		# Handle Comparison Result
		if ($auth){
			# Get User Details
			$query														= "	SELECT
																				* 
																			FROM
																				`users` 
																			WHERE
																				`username` = \"$username\" 
																				AND `password` = \"$password\"";
			$user														= $_db->fetch_one($query);

			# Set SESSION Details
			$_SESSION['user_uid']										= $user->uid;
			$_SESSION['user_username']									= $user->username;
			unset($_SESSION['login_error']);
			
			# Log Activity
			logg("Login : Login Successful. Username = `$username`.");
			
			# Return True
			return true;
		}
		else {
			# Destroy SESSION Details
			session_destroy();

			# Display Error Message
			logg ("Login : Authentication FAILED! Username = `$username`.", "ALERT");
			$_SESSION['login_error'] 									= "Login Failed. Please Try Aagain.";
			
			# Return False
			return false;
		}
	}
	
	public function check_auth($function) {
		# Check for auth in groups
		foreach ($this->membership->groups as $group) {
			if ($group->check_auth($function)) {
				return true;
			}
		}
		return false;
	}
	
	public function get_org_level() {
		# Get Name of Organizational Level
		$obj															= new OrganizationStructure($this->org_structure_id);
		$obj2															= new OrganizationLevel($obj->org_level_id);
		return $obj2->name;
	}
	
	public function get_business_unit() {
		# Get Name of Structural Unit
		$obj															= new OrganizationStructure($this->org_structure_id);
		return $obj->name;
	}
	
	public function show_calendar() {
		# Generate HTML
		$html															= "
		
		";
		
		# Return HTML
		return $html;
	}
	
	public function list_tickets() {
		# Generate List of Tickets
		$query															= "	SELECT
																				t.`uid` as '#',
																				p.`name` as 'Project',
																				t.`name` as 'Title',
																				t.`due_date` as 'Due Date',
																				t.`status` as 'Status'
																			FROM
																				`tickets` t,
																				`projects` p
																			WHERE
																				p.`uid` = t.`project_id`
																				AND t.`owner` = '{$this->uid}'
																				AND t.`active` = 1
																			ORDER BY
																				t.`due_date` DESC
																			";
		
		# Generate HTML
		$html															= paginated_listing($query);
		
		# Return HTML
		return $html;
	}
	
}

# ==========================================================================================
# THE END
# ==========================================================================================
