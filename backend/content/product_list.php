<?php
/**
 * Project
 * 
 * @author Elie Ishimwe <elieish@gmail.com>
 * @version 1.0
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
		# Global Variables
		global $_db, $validator, $app;
		
		# GET data
		$category_id													= $validator->validate($_GET['category']		,"Integer");
		$filename														= "../frontend/img/i_believe_in_fitness_t.jpg";
		$shopcartpic													= "../frontend/img/addcart.jpeg";										
			
			
			
															
		#Get Ranges for tha
		$query															= " SELECT 
																				 
																				 CONCAT(\"<a class='' href='{$shopcartpic}'><img src='\",t2.`url`,\"'></i></a>\") as '&nbsp;',
																				 t1.`description`,
																				 CONCAT(\"<a href='\",t1.`uid`,\"'><img src='{$shopcartpic}' height='73px'></a>\")
																				 
																			FROM `products` t1,
																				 `photographs` t2
																					
																			WHERE t1.`category_id` = {$category_id}
																				  AND t2.`product_id`= t1.`uid`
																			      AND t1.`active` = 1
																		";
		# Generate HTML
		$vars															= array(	"listing"				=> paginated_listing2($query),
																					"category_name"			=> $category->name
																				);
		$template														= new Template(dirname(dirname(dirname(__FILE__))) . "/frontend/html/products/list.html", $vars);
		$html															= $template->toString();
		
		# Display HTML
		print $html;
	}
	
	}