<?php
/**
 * Plugin Name:     Remove UTM Codes (WP-CLI Command)
 * Plugin URI:      https://github.com/shawnhooper/remove-utm-codes
 * Description:     Adds a WP-CLI command that removes UTM codes from links in your posts
 * Author:          Shawn M. Hooper
 * Author URI:      https://shawnhooper.ca/
 * Text Domain:     remove-utm-codes
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Remove_UTM_Codes
 */

namespace ShawnHooper\RemoveUTMCodes;

use WP_CLI;

class RemoveUTMCodes {

	/**
	 * Hook this plugin into WordPress' actions & filters
	 */
	public function hooks() : void {
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			include_once('classes/remove-utm-codes-command.php');
			$cli_command = new Remove_UTM_Command();
			WP_CLI::add_command( 'remove-utm-codes', $cli_command );
		}
	}

}

$_GLOBALS['RemoveUTMCodes'] = new RemoveUTMCodes();
$_GLOBALS['RemoveUTMCodes']->hooks();
