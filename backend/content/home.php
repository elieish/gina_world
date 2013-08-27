<?php
/**
 * Intranet
 * 
 * @author Ralfe Poisson <ralfepoisson@gmail.com>
 * @version 2.0
 * @package Project
 */

# =========================================================================
# PAGE CLASS
# =========================================================================

class Page extends AbstractPage {
	
	# =========================================================================
	# DISPLAY FUNCTIONS
	# =========================================================================
	
	/**
	 * The default function called when the script loads
	 */
	function display(){
		# Generate HTML from Template
		
	
		
		$file															= dirname(dirname(dirname(__FILE__))) . "/frontend/html/shoppingcart.html";
		$vars															= array(
																					""
																				);
		$template														= new Template($file, $vars);
		$html															= $template->toString();
		
		# Display HTML
		print $html;
	}
	
	# =========================================================================
	# PROCESSING FUNCTIONS
	# =========================================================================
	
}

# =========================================================================
# THE END
# =========================================================================
