<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://www.codesoup.co
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       CodeSoup Invoice Plugin
 * Plugin URI:        https://github.com/code-soup/invoice-plugin
 * Description:       WordPress Invoice Plugin with webpack build script and php namespacing
 * Version:           1.0.0
 * Author:            Code Soup, brbs, Kodelato
 * Author URI:        https://www.bobz.co, https://brbs.works/, https://kodelato.hr/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       cs-invoice-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

// Run the plugin.
require 'run.php';
