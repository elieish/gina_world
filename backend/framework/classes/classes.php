<?php
/**
 * Project
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 1.0
 * @package Project
 */

# =========================================================================
# INCLUDE REQUIRED CLASSES
# =========================================================================

# AbstractPage
include_once("abstractpage.class.php");

# Database Engine
include_once("db_engine.class.php");

# Validator
include_once("validator.class.php");

# Stats
include_once("stats.class.php");

# Model
include_once("model.class.php");

# Form
include_once("form.class.php");

# Application
include_once("application.class.php");

# Template
include_once("template.class.php");

# TestManager
include_once("testManager.class.php");

# PHPMailer 
include_once("class.phpmailer.php");

# SMTP 
include_once("class.smtp.php");

# =========================================================================
# CONSTRUCT SPECIAL OBJECTS
# =========================================================================

# Database Engine
$_db 									= new db_engine(	$_GLOBALS['mysql_host'],
															$_GLOBALS['mysql_user'],
															$_GLOBALS['mysql_pass'],
															$_GLOBALS['mysql_db'],
															$_GLOBALS['mysql_debug']
														);
$_db->db_connect();

# Validator
$validator								= new Validator();

# =========================================================================
# THE END
# =========================================================================

?>
