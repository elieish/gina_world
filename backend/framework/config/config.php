<?php
/*
 * Project
 * @author elie <elieish@gmail.com>
 * @version 1.0
 * @package Project 
 */
 # ==========================================================================
 # CONFIGURATION
 # ===========================================================================
 # System Settings
$_GLOBALS['title']														= "Gina World";
$_GLOBALS['log_file']													= "/var/log/gina_world/" . date("Ymd") . ".log";
$_GLOBALS['base_dir']													= dirname(dirname(dirname(__FILE__))) . "/";
$_GLOBALS['base_url']													= $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . "/../../";
$_GLOBALS['max_results']												= 20; 
$_GLOBALS['default_page']												= "signup";
 
 # Database Connectivity
$_GLOBALS['mysql_host']													= "localhost";
$_GLOBALS['mysql_user']													= "gina_world";
$_GLOBALS['mysql_pass']													= "Gina_w0rdld";
$_GLOBALS['mysql_db']													= "gina_world";
$_GLOBALS['mysql_debug']												= true;