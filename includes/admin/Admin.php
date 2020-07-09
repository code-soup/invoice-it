<?php

namespace csip\admin;

use csip\Assets;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
defined( 'WPINC' ) || die;


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */
class Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
        // Load assets from manifest.json
        $this->assets = new Assets();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( PLUGIN_NAME . '/wp/css', $this->assets->get('styles/admin.css'), [], PLUGIN_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( PLUGIN_NAME . '/wp/js', $this->assets->get('scripts/admin.js'), [], PLUGIN_VERSION, false );
	}

	/**
	 * Set Custom Post Types file location using Sober/models
	 * WordPress plugin to create custom post types and taxonomies using JSON, YAML or PHP files
	 * Theme uses models.json file located in the directory set in the filter below
	 *
	 * @link( https://github.com/soberwp/models, documentation )
	 */
	public function sober_models_path() {

		return PLUGIN_PATH . 'includes/models';
	}

	public function crb_load() {
		\Carbon_Fields\Carbon_Fields::boot();
	}

	public function crb_attach_plugin_options() {
		Container::make( 'theme_options', __( 'Invoice Plugin', 'crb' ) )
			->add_fields( array(
				Field::make( 'text', 'crb_text', 'Text Field' ),
				Field::make( 'text', 'crb_text_t', 'Text Test Field' ),
			) );


			Container::make( 'post_meta', __( 'Section Options' ) )
			->where( 'post_type', '=', 'page' )
			// ->where( 'post_template', '=', 'template-section-based.php' )
			->add_fields( array(
				Field::make( 'complex', 'crb_sections', 'Sections' )
					// Our first group will be a simple rich text field
					->add_fields( 'text', 'Text', array(
						Field::make( 'rich_text', 'text', 'Text' ),
					) )

					// Second group will be a list of files for users to download
					->add_fields( 'file_list', 'File List', array(
						Field::make( 'complex', 'files', 'Files' )
							->add_fields( array(
								Field::make( 'file', 'file', 'File' ),
							) ),
					) )

					// Third group will be a list of manually selected posts
					// used as a simple curated "Related posts" listing
					->add_fields( 'related_posts', 'Related Posts', array(
						Field::make( 'association', 'posts', 'Posts' )
							->set_types( array(
								array(
									'type' => 'post',
									'post_type' => 'post',
								),
							) ),
					) ),
			) );
	}


}
