<?php

namespace csip\admin;

use csip\Assets;
use csip\admin\Helpers;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @since      1.0.0
 */
class Admin {


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		// Load assets from manifest.json.
		$this->assets = new Assets();
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( CSIP_NAME . '/wp/css', $this->assets->get( 'styles/admin.css' ), array(), CSIP_VERSION, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( CSIP_NAME . '/wp/js', $this->assets->get( 'scripts/admin.js' ), array(), CSIP_VERSION, false );
	}


	/**
	 * Register custom post-type Invoice
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_invoice() {

		$labels = array(
			'name'                  => _x( 'Invoices', 'Post type general name', CSIP_TEXT_DOMAIN ),
			'singular_name'         => _x( 'Invoice', 'Post type singular name', CSIP_TEXT_DOMAIN ),
			'menu_name'             => _x( 'Invoices', 'Admin Menu text', CSIP_TEXT_DOMAIN ),
			'name_admin_bar'        => _x( 'Invoice', 'Add New on Toolbar', CSIP_TEXT_DOMAIN ),
			'add_new'               => __( 'Add New', CSIP_TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New Invoice', CSIP_TEXT_DOMAIN ),
			'new_item'              => __( 'New Invoice', CSIP_TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit Invoice', CSIP_TEXT_DOMAIN ),
			'view_item'             => __( 'View Invoice', CSIP_TEXT_DOMAIN ),
			'all_items'             => __( 'All Invoices', CSIP_TEXT_DOMAIN ),
			'search_items'          => __( 'Search Invoices', CSIP_TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent Invoices:', CSIP_TEXT_DOMAIN ),
			'not_found'             => __( 'No invoices found.', CSIP_TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'No invoices found in Trash.', CSIP_TEXT_DOMAIN ),
			'archives'              => _x( 'Invoice archives', 'The post type archive label used in nav menus. Default “Post Archives”.', CSIP_TEXT_DOMAIN ),
			'insert_into_item'      => _x( 'Insert into invoice', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', CSIP_TEXT_DOMAIN ),
			'filter_items_list'     => _x( 'Filter invoice list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', CSIP_TEXT_DOMAIN ),
			'items_list_navigation' => _x( 'Invoices list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', CSIP_TEXT_DOMAIN ),
			'items_list'            => _x( 'Invoices list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', CSIP_TEXT_DOMAIN ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_nav_menus'  => false,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'invoice' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-media-spreadsheet',
		);

		register_post_type( 'invoice', $args );

	}


	/**
	 * Register custom post-type Client
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_client() {

		$labels = array(
			'name'                  => _x( 'Clients', 'Post type general name', CSIP_TEXT_DOMAIN ),
			'singular_name'         => _x( 'Client', 'Post type singular name', CSIP_TEXT_DOMAIN ),
			'menu_name'             => _x( 'Clients', 'Admin Menu text', CSIP_TEXT_DOMAIN ),
			'name_admin_bar'        => _x( 'Client', 'Add New on Toolbar', CSIP_TEXT_DOMAIN ),
			'add_new'               => __( 'Add New', CSIP_TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New Client', CSIP_TEXT_DOMAIN ),
			'new_item'              => __( 'New Client', CSIP_TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit Client', CSIP_TEXT_DOMAIN ),
			'view_item'             => __( 'View Client', CSIP_TEXT_DOMAIN ),
			'all_items'             => __( 'All Clients', CSIP_TEXT_DOMAIN ),
			'search_items'          => __( 'Search Clients', CSIP_TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent Clients:', CSIP_TEXT_DOMAIN ),
			'not_found'             => __( 'No clients found.', CSIP_TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'No clients found in Trash.', CSIP_TEXT_DOMAIN ),
			'archives'              => _x( 'Client archives', 'The post type archive label used in nav menus. Default “Post Archives”.', CSIP_TEXT_DOMAIN ),
			'insert_into_item'      => _x( 'Insert into client', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', CSIP_TEXT_DOMAIN ),
			'filter_items_list'     => _x( 'Filter client list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', CSIP_TEXT_DOMAIN ),
			'items_list_navigation' => _x( 'Clients list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', CSIP_TEXT_DOMAIN ),
			'items_list'            => _x( 'Clients list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', CSIP_TEXT_DOMAIN ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'rewrite'            => array( 'slug' => 'client' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-groups',
		);

		register_post_type( 'client', $args );

	}


	/**
	 * Register custom post-type Bank Account
	 *
	 * @since    1.0.0
	 */
	public function register_cpt_bank_account() {

		$labels = array(
			'name'                  => _x( 'Bank Accounts', 'Post type general name', CSIP_TEXT_DOMAIN ),
			'singular_name'         => _x( 'Bank Account', 'Post type singular name', CSIP_TEXT_DOMAIN ),
			'menu_name'             => _x( 'Bank Accounts', 'Admin Menu text', CSIP_TEXT_DOMAIN ),
			'name_admin_bar'        => _x( 'Bank Account', 'Add New on Toolbar', CSIP_TEXT_DOMAIN ),
			'add_new'               => __( 'Add New', CSIP_TEXT_DOMAIN ),
			'add_new_item'          => __( 'Add New Bank Account', CSIP_TEXT_DOMAIN ),
			'new_item'              => __( 'New Bank Account', CSIP_TEXT_DOMAIN ),
			'edit_item'             => __( 'Edit Bank Account', CSIP_TEXT_DOMAIN ),
			'view_item'             => __( 'View Bank Account', CSIP_TEXT_DOMAIN ),
			'all_items'             => __( 'All Bank Accounts', CSIP_TEXT_DOMAIN ),
			'search_items'          => __( 'Search Bank Accounts', CSIP_TEXT_DOMAIN ),
			'parent_item_colon'     => __( 'Parent Bank Accounts:', CSIP_TEXT_DOMAIN ),
			'not_found'             => __( 'No bank accounts found.', CSIP_TEXT_DOMAIN ),
			'not_found_in_trash'    => __( 'No bank accounts found in Trash.', CSIP_TEXT_DOMAIN ),
			'archives'              => _x( 'Bank Account archives', 'The post type archive label used in nav menus. Default “Post Archives”.', CSIP_TEXT_DOMAIN ),
			'insert_into_item'      => _x( 'Insert into bank account', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post).', CSIP_TEXT_DOMAIN ),
			'filter_items_list'     => _x( 'Filter bank account list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”.', CSIP_TEXT_DOMAIN ),
			'items_list_navigation' => _x( 'Bank Accounts list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”.', CSIP_TEXT_DOMAIN ),
			'items_list'            => _x( 'Bank Accounts list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”.', CSIP_TEXT_DOMAIN ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => false,
			'show_in_nav_menus'  => false,
			'rewrite'            => array( 'slug' => 'bankaccount' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array( 'title' ),
			'menu_icon'          => 'dashicons-bank',
		);

		register_post_type( 'bankaccount', $args );

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
		fields\BankAccounts::load();
	}


	/**
	 * Register custom post type template
	 *
	 * @param    [type] $single_template
	 * @return   void
	 * @since    1.0.0
	 */
	public function get_invoice_template( $single_template ) {
		global $post;
		if ( 'invoice' === $post->post_type ) {
			$single_template = trailingslashit( CSIP_PATH ) . 'includes/templates/invoice.php';
		}

		return $single_template;
	}


	/**
	 * Hook to handle next invoice number
	 *
	 * @param    [type] $post_id
	 * @param    [type] $post
	 * @param    [type] $update
	 * @return   void
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
	 * Add column with invoice number to Invoice CPT
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function show_invoice_number_column( $columns ) {
		$columns = array_merge( $columns, array( 'invoice_number' => __( 'Invoice Number', CSIP_TEXT_DOMAIN ) ) );

		// Move the Date column to the end.
		$reposition = $columns['date'];
		unset( $columns['date'] );
		$columns['date'] = $reposition;

		return $columns;
	}


	/**
	 * Make the invoice number column soratblle
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function sortable_invoice_number_column( $columns ) {
		$columns['invoice_number'] = 'invoice_number';
		return $columns;
	}


	/**
	 * Fill invoice_number column with data
	 *
	 * @param    [type] $column_key
	 * @param    [type] $post_id
	 * @return   void
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


	/**
	 * Add column with invoice client to Invoice CPT
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function show_invoice_client_column( $columns ) {
		$columns = array_merge( $columns, array( 'invoice_client' => __( 'Client', CSIP_TEXT_DOMAIN ) ) );

		// Move the Date column to the end.
		$reposition = $columns['date'];
		unset( $columns['date'] );
		$columns['date'] = $reposition;

		return $columns;
	}


	/**
	 * Make the invoice client column soratblle
	 *
	 * @param    [type] $columns
	 * @return   void
	 * @since    1.0.0
	 */
	public function sortable_invoice_client_column( $columns ) {
		$columns['invoice_client'] = 'invoice_client';
		return $columns;
	}


	/**
	 * Fill invoice_client column with data
	 *
	 * @param    [type] $column_key
	 * @param    [type] $post_id
	 * @return   void
	 * @since    1.0.0
	 */
	public function fill_invoice_client_column( $column_key, $post_id ) {
		if ( $column_key == 'invoice_client' ) {
			$invoice_client = get_post_meta( $post_id, '_inv_client', true );
			if ( $invoice_client ) {
				echo '<span>' . get_the_title( $invoice_client ) . '</span>';
			} else {
				echo '<span>-</span>';
			}
		}
	}

}
