<?php
/**
 * Project
 * 
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
 * @package Project
 */

# =========================================================================
# SETTINGS
# =========================================================================

# Start Session
ini_set("session.save_handler", "files");
session_start();

# Store latest page request
$_SESSION['accessing_page'] 											= $_SERVER['REQUEST_URI'];

# Include Required Scripts
include_once (dirname(dirname(__FILE__)) . "/backend/framework/include.php");

# =========================================================================
# CONSTRUCT PAGE
# =========================================================================

# Create Application Object
$app																	= Application::Factory();

# Construct Page
$app->draw_page();

# =========================================================================
# THE END
# =========================================================================
