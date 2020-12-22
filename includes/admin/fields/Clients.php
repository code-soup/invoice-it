<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class containing fields for the plugin options page.
 */
class Clients {


	/**
	 * Load all custom field metaboxes for Client post type
	 */
	public static function load() {
		self::fields_address();
		self::fields_contact();
		self::fields_other();
		self::fields_note();
	}


	/**
	 * Create address fields
	 */
	public static function fields_address() {
		Container::make( 'post_meta', __( 'Address', PLUGIN_TEXT_DOMAIN ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'text', 'cli_address_1', __( 'Address 1', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-4 cli-address-1' ),
					Field::make( 'text', 'cli_address_2', __( 'Address 2', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-4 cli-address-2' ),
					Field::make( 'text', 'cli_city', __( 'City', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-4 cli-city' ),
					Field::make( 'text', 'cli_zip', __( 'Zip code', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-4 cli-zip' ),
					Field::make( 'select', 'cli_country', __( 'Country', PLUGIN_TEXT_DOMAIN ) )
						->set_options( \csip\admin\Helpers::get_countries() )
						->set_classes( 'span-4 cli-country csip-select2' ),
					Field::make( 'select', 'cli_state', __( 'State', PLUGIN_TEXT_DOMAIN ) )
						->set_options( \csip\admin\Helpers::get_states() )
						->set_classes( 'span-4 cli-state csip-select2' ),
				)
			);
	}


	/**
	 * Create contact fields
	 */
	public static function fields_contact() {
		Container::make( 'post_meta', __( 'Contact Details', PLUGIN_TEXT_DOMAIN ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'text', 'cli_name', __( 'Name', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-6 cli-name' ),
					Field::make( 'text', 'cli_email', __( 'Email', PLUGIN_TEXT_DOMAIN ) )
						->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
						->set_classes( 'span-6 cli-email' ),
					Field::make( 'text', 'cli_phone', __( 'Phone number', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-6 cli-phone' ),
					Field::make( 'text', 'cli_mobile', __( 'Mobile number', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-6 cli-mobile' ),
					Field::make( 'complex', 'cli_contacts', __( 'Other Contacts', PLUGIN_TEXT_DOMAIN ) )
					->setup_labels(
						array(
							'plural_name'   => 'Contacts',
							'singular_name' => 'Contact',
						)
					)
					->set_layout( 'tabbed-vertical' )
					->add_fields(
						array(
							Field::make( 'text', 'cli_contact_name', __( 'Name', PLUGIN_TEXT_DOMAIN ) )
								->set_classes( 'span-4 cli-contact-name' ),
							Field::make( 'text', 'cli_contact_email', __( 'Email', PLUGIN_TEXT_DOMAIN ) )
								->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
								->set_classes( 'span-4 cli-contact-email' ),
							Field::make( 'text', 'cli_contact_mobile', __( 'Mobile number', PLUGIN_TEXT_DOMAIN ) )
								->set_classes( 'span-4 cli-contact-mobile' ),
						)
					)
					->set_header_template(
						'
						<% if (cli_contact_name) { %>
							<%- cli_contact_name %>
						<% } %>
					'
					),
				)
			);
	}


	/**
	 * Create bank detail fields
	 */
	public static function fields_other() {
		 Container::make( 'post_meta', __( 'Other Details', PLUGIN_TEXT_DOMAIN ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'number', 'cli_tax_rate', __( 'Tax Rate (%)', PLUGIN_TEXT_DOMAIN ) )
						->set_min( 0 )
						->set_default_value( 0 )
						->set_classes( 'span-6 cli-tax-rate' ),
					Field::make( 'number', 'cli_net_period', __( 'Net', PLUGIN_TEXT_DOMAIN ) )
						->set_min( 0 )
						->set_default_value( 30 )
						->set_classes( 'span-6 cli-net_period' )
						->set_help_text( 'Days until the payment is due' ),
					Field::make( 'text', 'cli_vatid', __( 'VAT ID', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'span-6 cli-vatid' ),
					Field::make( 'select', 'cli_currency', __( 'Currency', PLUGIN_TEXT_DOMAIN ) )
						->set_options( \csip\admin\Helpers::get_currencies() )
						->set_classes( 'span-6 cli-currency csip-select2' ),
				)
			);
	}


	/**
	 * Create note fields
	 */
	public static function fields_note() {
		Container::make( 'post_meta', __( 'Note', PLUGIN_TEXT_DOMAIN ) )
			->where( 'post_type', '=', 'client' )
			->add_fields(
				array(
					Field::make( 'textarea', 'cli_comment', __( 'Comment', PLUGIN_TEXT_DOMAIN ) )
						->set_classes( 'cli-comment' ),
				)
			);
	}
}
