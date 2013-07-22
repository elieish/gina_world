<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.cm>
 * @version 2.0
 * @package Project
 */
 
# ===================================================
# SCRIPT SETTINGS
# ===================================================

# Start Session
session_start();

# Set Cur Page
$cur_page																= "login.php";

# Include Required Scripts
include_once(dirname(dirname(__FILE__)) . "/backend/framework/include.php");
Application::include_models();

# ===================================================
# DISPLAY FUNCTIONS
# ===================================================

function display() {
	# Global Variables
	global $_GLOBALS;
	
	# Generate Page
	$template															= new Template(dirname(__FILE__) . "/html/login.html");
	$template->draw();
}

# ===================================================
# PROCESSING FUNCTIONS
# ===================================================

function login() {
	# Global Variables
	global $cur_page, $_db, $_GLOBALS;
        
	# Check if user is attempting to be authenticated
	if (isset($_POST['login'])){
		# Get POST Data
		$username														= $_POST['username'];
		$password														= md5($_POST['password']);
		
		# Attempt to Login
		$result															= User::login($username, $password);
		
		# Handle Login Result
		if ($result) {
			# Redirect
			if (isset($_SESSION['accessing_page'])) {
				redirect($_SESSION['accessing_page']);
			}
			else {
				redirect("./");
			}
		}
		else {
			display();
		}
	}
}

# ===================================================
# ACTION HANDLER
# ===================================================

if (isset($_GET['action'])){
	$action																= $_GET['action'];
	if ($action															== "display"){
		display();
	}
	else if ($action													== "login"){
		login();
	}
	else {
		print "Invalid Action `$action`.";
	}
}
else {
	display();
}

# ===================================================
# THE END
# ===================================================
