<?php
/**
 *Project
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @package Project 
 * @resource stackoverflow.com/questions/1102781/best-way-for-a-forgot-password-implementation
 */
 
include_once (dirname(dirname(__FILE__)). "/backend/framework/include.php");
Application::include_models();
$cur_page						=		"forgotpassword.php";

 function display() {
 	$file						=		dirname(__FILE__)."/html/forgotpassword.html";
	$template					=		new Template($file);
	$html						=		$template->toString();
	
	#Display Html
	print $html;
 }
 
 function recover() {
 	# Global Variables	
 	global $cur_page;
		
 	# Create object
 	$obj						=		new  Passwordrecovery();
	
	# Generate HTML
	$var						=		array (
									"form"	=>	$obj->item_form($cur_page.'?action=add'),	
									);
	$file						=		dirname(__FILE__)."/html/forgotpassword.html";
	$template					=		new Template($file,$var);
	$html						=		$template->toString();
	print $html;
 }
 
 function add() {
 	# Global Variables
 	global $_db,$cur_page;
	
	# Get Post Data
	$name						=	$_POST['name'];
	
	# Get User ID
	$query						=	"SELECT
										`uid`,
										`email`,
										`first_name`						
									FROM
							 			`users`
							 		WHERE
							 			`email` = '{$name}'
							 			OR
							 			`username` = '{$name}'";
								
	$result						=	$_db->fetch($query);

	foreach ($result as $value) {
		$userid					=	$value->uid;
		$email					=	$value->email;
		$firstname				=	$value->first_name;
	}
	$guid						=	MD5(uniqid());	
	#Create Object
	$obj						=	new Passwordrecovery();
	
	# Handle New Items
		if (!$uid) {
			$obj->active												= 1;
			$obj->creation_date											= date("Y-m-d H:i:s");
			$obj->userid												= $userid;
			$obj->r_string												= $guid;
		}
		
	# Save Object
	$obj->save();
	
	# Send Email for recovery
	$mail 						= new PHPMailer;

	$mail->IsSMTP();                                      
	$mail->Host 				= 'smtp.gmail.com';  						
	$mail->SMTPAuth 			= true;                             
	$mail->Username 			= 'ginaworld2013@gmail.com';                            
	$mail->Password 			= 'g1naw0rld';                           
	$mail->SMTPSecure 			= 'ssl';
	$mail->Port       			= "465";                           
	$mail->From 				= 'ginaworld2013@gmail.com';
	$mail->FromName 			= 'Gina';
	$mail->AddAddress($email, $firstname);             
	$mail->WordWrap 			= 50;                              
	$mail->IsHTML(true);                                  
	$mail->Subject 				= 'Gina_world Password Change';
	$html						= "<html><body><h1>Click link below to recover your password</h1></br><a href='http://localhost/gina_world/frontend/forgotpassword.php?action=newPass&id=$guid'>http://localhost/gina_world/frontend/forgotpassword.php?action=newPass&id=$guid</a></body></html>";
	$mail->Body  				= $html;

	if(!$mail->Send()) {
   		print 'Message could not be sent.';
   		print 'Mailer Error: ' . $mail->ErrorInfo;
   	exit;
	}

	print 'Message has been sent to '.$email.' for recovery';

	# Redirect
	//redirect($this->cur_page);
	
 	
 }

function newPass() {
	#global Variables
	global $_db;
	
	#Get GET Data
	$id							= $_GET['id'];
	
	#Get User ID 
	$query						= "SELECT 
									userid
								   FROM
								  	`password_change_request`
								   WHERE
								  	`r_string`='{$id}'";
	
	#Get UserID
	$userID						= $_db->fetch_single($query);
	if($userID)
	{
		$file					= dirname(__FILE__).'/html/newpassword.html';
		$vars					= array(
										"id"	=>	$userID,
										);
		$template				= new Template($file,$vars);
		$html					= $template->toString();
		print $html;
		print"there is a record in the database".$file;
	}
		
}

//-------------------------------------------------------------------------
// Action Handler
//--------------------------------------------------------------------------
if (isset($_GET['action'])) {
	$action				=		$_GET['action'];
	if ($action=="display") {
		display();
	}
	elseif ($action=="recover") {
		recover();
	}
	elseif ($action=="add") {
		add();
	}
	elseif ($action=="newPass") {
		newPass();
	}
	
} 
else {
	
}
