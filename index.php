<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://www.codesoup.co
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       InvoiceIT
 * Plugin URI:        https://github.com/code-soup/invoice-plugin
 * Description:       WordPress Plugin for invoicing with client managment
 * Version:           1.0.0
 * Author:            Code Soup, brbs, Kodelato
 * Author URI:        https://github.com/code-soup/invoice-plugin
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       invoiceit
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

// Run the plugin.
require 'run.php';
