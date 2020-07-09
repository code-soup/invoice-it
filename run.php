<?php

// Autoload all classes via composer
require "vendor/autoload.php";

use csip\Activator;
use csip\Deactivator;
use csip\PluginInit;

// use Carbon_Fields\Container;
// use Carbon_Fields\Field;

// add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
// function crb_attach_theme_options() {
//     Container::make( 'theme_options', __( 'Invoice Plugin Options', 'crb' ) )
//         ->add_fields( array(
//             Field::make( 'text', 'crb_text', 'Text Field' ),
//         ) );
// }

// add_action( 'after_setup_theme', 'crb_load' );
// function crb_load() {
//     // require_once( 'vendor/autoload.php' );
//     \Carbon_Fields\Carbon_Fields::boot();
// }
// If this file is called directly, abort.
defined( 'WPINC' ) || die;


// Base plugin Path and URI
define( 'PLUGIN_URI', plugin_dir_url( __FILE__ ) );
define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Plugin details
define( 'PLUGIN_NAME', 'CodeSoup Invoice Plugin');
define( 'PLUGIN_VERSION', '1.0.0');
define( 'PLUGIN_TEXT_DOMAIN', 'cs-invoice-plugin');


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/Activator.php
 */
register_activation_hook( __FILE__, ['csip\Activator', 'activate']);


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/Deactivator.php
 */
register_deactivation_hook( __FILE__, ['csip\Deactivator', 'deactivate']);


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
$plugin = new PluginInit();
$plugin->run();
