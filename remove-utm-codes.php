<?php
/**
 * Plugin Name:     Remove UTM Codes from Links in Posts
 * Plugin URI:      https://github.com/shawnhooper/remove-utm-codes
 * Description:     Remove UTM codes from links in WordPress posts
 * Author:          Shawn M. Hooper
 * Author URI:      https://shawnhooper.ca/
 * Text Domain:     remove-utm-codes
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Remove_UTM_Codes
 */

namespace ShawnHooper\RemoveUTMCodes;

use WP_CLI;

class RemoveUTMCodes {

	private ?bool $has_tweets = null;

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