<?php

namespace csip\admin;

use csip\Assets;
use csip\admin\Helpers;

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

		wp_enqueue_style( PLUGIN_NAME . '/wp/css', $this->assets->get( 'styles/admin.css' ), array(), PLUGIN_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( PLUGIN_NAME . '/wp/js', $this->assets->get( 'scripts/admin.js' ), array(), PLUGIN_VERSION, false );
	}

	/**
	 * Set Custom Post Types file location using Sober/models
	 * WordPress plugin to create custom post types and taxonomies using JSON, YAML or PHP files
	 * Theme uses models.json file located in the directory set in the filter below
	 *
	 * @link( https://github.com/soberwp/models, documentation )
	 * @since    1.0.0
	 */
	public function sober_models_path() {

		return PLUGIN_PATH . 'includes/models';
	}

	/**
	 * Boot Carbon Fields with default IoC dependencies
	 *
	 * @since    1.0.0
	 */
	public function boot_custom_fields() {

		\Carbon_Fields\Carbon_Fields::boot();
	}

	/**
	 * Load Custom fields
	 *
	 * @since    1.0.0
	 */
	public function register_custom_fields() {

		fields\Options::load();
		fields\Clients::load();
		fields\Invoice::load();
	}


	/**
	 * Register custom post type template
	 *
	 * @param [type] $single_template
	 * @return void
	 * @since    1.0.0
	 */
	public function get_invoice_template( $single_template ) {
		global $wp_query, $post;
		if ( $post->post_type == 'invoice' ) {
			$single_template = PLUGIN_PATH . 'includes/templates/invoice.php';
		}
		return $single_template;
	}


	/**
	 * Hook to handle next invoice number
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public function on_publish_invoice( $post_id, $post, $update ) {

		$post_status         = $post->post_status;
		$allowed_post_status = array( 'publish', 'draft', 'auto-draft' );
		$inv_number          = get_post_meta( $post_id, '_inv_number', true );

		if ( ! empty( $inv_number ) || ! $update || ! in_array( $post_status, $allowed_post_status, true ) ) {
			return;
		}

		Helpers::set_next_invoice_number();
	}

	/**
	 * Add column with invoice number
	 *
	 * @param [type] $columns
	 * @return void
	 * @since    1.0.0
	 */
	public function show_invoice_number_column( $columns ) {
		$columns = array_merge( $columns, array( 'invoice_number' => __( 'Invoice Number', PLUGIN_TEXT_DOMAIN ) ) );

		// Move the Date column to the end
		$reposition = $columns['date'];
		unset($columns['date']);
		$columns['date'] = $reposition;

		return $columns;
	}

	/**
	 * Make the invoice number column soratblle
	 *
	 * @param [type] $columns
	 * @return void
	 * @since    1.0.0
	 */
	public function sortable_invoice_number_column( $columns ) {
		$columns['invoice_number'] = 'invoice_number';
		return $columns;
	}

	/**
	 * Fill invoice_number column with data
	 *
	 * @param [type] $columns
	 * @return void
	 * @since    1.0.0
	 */
	public function fill_invoice_number_column( $column_key, $post_id ) {
		if ( $column_key == 'invoice_number' ) {
			$invoice_number = get_post_meta( $post_id, '_inv_number', true );
			if ( $invoice_number ) {
				echo '<span>' . $invoice_number . '</span>';
			} else {
				echo '<span>-</span>';
			}
		}
	}

}
