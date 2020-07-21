<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
defined('WPINC') || die;


/**
 * Class containing fields for the plugin options page.
 *
 */
class Clients
{

	/**
	 * Load all custom field metaboxes for Client post type
	 */
	public static function load()
	{
		self::fields_address();
		self::fields_contact();
		self::fields_other();
		self::fields_note();
	}


	/**
	 * Create address fields
	 */
	public static function fields_address()
	{
		Container::make('post_meta', __('Address', 'cs-invoice-plugin'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('text', 'cli_address_1', __('Address 1'))
					->set_classes('span-4 cli-address-1'),
				Field::make('text', 'cli_address_2', __('Address 2'))
					->set_classes('span-4 cli-address-2'),
				Field::make('text', 'cli_city', __('City', 'cs-invoice-plugin'))
					->set_classes('span-4 cli-city'),
				Field::make('text', 'cli_zip', __('Zip code', 'cs-invoice-plugin'))
					->set_classes('span-4 cli-zip'),
				Field::make('select', 'cli_country', __('Country', 'cs-invoice-plugin'))
					->set_options(\csip\admin\Helpers::get_countries())
					->set_classes('span-4 cli-country'),
				Field::make('select', 'cli_state', __('State', 'cs-invoice-plugin'))
					->set_options(array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
					))
					->set_classes('span-4 cli-state'),
			));
	}


	/**
	 * Create contact fields
	 */
	public static function fields_contact()
	{
		Container::make('post_meta', __('Contact Details', 'cs-invoice-plugin'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('text', 'cli_name', __('Name', 'cs-invoice-plugin'))
					->set_classes('span-6 cli-name'),
				Field::make('text', 'cli_email', __('Email', 'cs-invoice-plugin'))
					->set_attribute('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
					->set_classes('span-6 cli-email'),
				Field::make('text', 'cli_phone', __('Phone number', 'cs-invoice-plugin'))
					->set_classes('span-6 cli-phone'),
				Field::make('text', 'cli_mobile', __('Mobile number', 'cs-invoice-plugin'))
					->set_classes('span-6 cli-mobile'),
				Field::make('complex', 'cli_contacts', __('Other Contacts', 'cs-invoice-plugin'))
					->setup_labels(array(
						'plural_name' => 'Contacts',
						'singular_name' => 'Contact',
					))
					->set_layout('tabbed-vertical')
					->add_fields(array(
						Field::make('text', 'cli_contact_name', __('Name', 'cs-invoice-plugin'))
							->set_classes('span-4 cli-contact-name'),
						Field::make('text', 'cli_contact_email', __('Email', 'cs-invoice-plugin'))
							->set_attribute('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
							->set_classes('span-4 cli-contact-email'),
						Field::make('text', 'cli_contact_mobile', __('Mobile number', 'cs-invoice-plugin'))
							->set_classes('span-4 cli-contact-mobile'),
					))
					->set_header_template('
						<% if (cli_contact_name) { %>
							<%- cli_contact_name %>
						<% } %>
					'),
			));
	}


	/**
	 * Create bank detail fields
	 */
	public static function fields_other()
	{
		Container::make('post_meta', __('Other Details', 'cs-invoice-plugin'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('number', 'cli_tax_rate', __('Tax Rate (%)'))
					->set_min(0)
					->set_default_value(0)
					->set_classes('span-6 cli-tax-rate'),
				Field::make('number', 'cli_net_period', __('Net', 'cs-invoice-plugin'))
					->set_min(0)
					->set_default_value(30)
					->set_classes('span-6 cli-net_period')
					->set_help_text('Days until the payment is due'),
				Field::make('text', 'cli_vatid', __('VAT ID', 'cs-invoice-plugin'))
					->set_classes('span-6 cli-vatid'),
				Field::make('select', 'cli_currency', __('Currency', 'cs-invoice-plugin'))
					->set_options(\csip\admin\Helpers::get_currencies())
					->set_classes('span-6 cli-currency'),
			));
	}


	/**
	 * Create note fields
	 */
	public static function fields_note()
	{
		Container::make('post_meta', __('Note', 'cs-invoice-plugin'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('textarea', 'cli_comment', __('Comment', 'cs-invoice-plugin'))
					->set_classes('cli-comment'),
			));
	}
}
