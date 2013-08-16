<?php
/**
 *Project
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @package Project 
 */
 
# ===================================================
# SCRIPT SETTINGS
# ===================================================

# Start Session
session_start();

# Include Required Scripts
include_once(dirname(dirname(__FILE__)) . "/backend/framework/include.php");
Application::include_models();
Application::include_helpers();

# ===================================================
# FUNCTIONS
# ===================================================

function save_signup_entry() {
    global $_db, $validator;	
 	$uid            = $validator->validate($_GET['id'],   "Integer"); print"k";die;
    $email          = $validator->validate($_GET['email'], "String");
    $pass			= $validator->validate($_GET['cpass'], "String"); 
	$fname			= $validator->validate($_GET['fname'], "String");
	$lname		 	= $validator->validate($_GET['lname'], "String");
	$phone 			= $validator->validate($_GET['phone'], "String");
  	$address 		= $validator->validate($_GET['address'],"Integer");
        if ($uid > 0) {
         
         $_db->update(
                    'users',
                    array(
                        'password'  	=> md5($pass),
                                              
                    ),
                    array(
                        'uid' 			=> $uid
                    )
                ); 
				
				echo "OK";
        } 
        else {
         $_db->insert(
                'users',
                array(
					'creation_date'	=> now(),
                    'username'   	=> $email,
                    'user_type_id'  => 1,
                    'password'  	=> md5($pass),
                    'first_name'	=> $fname,
                    'last_name'		=> $lname,
                    'mobile'		=> $phone,    
                    'active'        => 1
                )
            ); 
       
       
      echo "OK";
	  
    }
}




# ===================================================
# ACTION HANDLER
# ===================================================

if (isset($_GET['action'])) {
	$action								= $_GET['action'];
	if (function_exists($action)) {
		$action();
	}
	elseif(function_exists("save_signup_entry")){
		save_signup_entry();
	}
	else {
		print "ERROR: Invalid Action `{$action}`.";

	}
}
else {
	print "ERROR: Please supply an action.";
}

# ===================================================
# THE END
# ===================================================
