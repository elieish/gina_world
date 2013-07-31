<?php
/**
 *Project
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @package Project 
 */

$cur_page="signup.php";

# Include Required Scripts
include_once(dirname(dirname(__FILE__)) . "/backend/framework/include.php");
Application::include_models();

function display() {
	
    $file    		=    dirname(__FILE__)."/html/signup.html";
	$template		=	 new Template($file);
	$html			=    $template->toString();
	
	# Display HTML
	print $html;

}

//-----------------------------------------------------------------------
// Action Handler
//-----------------------------------------------------------------------

if (isset($_GET['action'])) {
    
    $action = $_GET['action'];
    
    if ($action == "display") {
        display();
    }  
    
} else { 
    display();
}
