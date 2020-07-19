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
		Container::make('post_meta', __('Address'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('text', 'cli_address_1', __('Address 1'))
					->set_width(33)
					->set_classes('cli-address-1'),
				Field::make('text', 'cli_address_2', __('Address 2'))
					->set_width(33)
					->set_classes('cli-address-2'),
				Field::make('text', 'cli_city', __('City'))
					->set_width(33)
					->set_classes('cli-city'),
				Field::make('text', 'cli_zip', __('Zip code'))
					->set_width(33)
					->set_classes('cli-zip'),
				Field::make('select', 'cli_country', __('Country'))
					->set_options(\csip\admin\Helpers::get_countries())
					->set_width(33)
					->set_classes('cli-country'),
				Field::make('select', 'cli_state', __('State'))
					->set_options(array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
					))
					->set_width(33)
					->set_classes('cli-state'),
			));
	}


	/**
	 * Create contact fields
	 */
	public static function fields_contact()
	{
		Container::make('post_meta', __('Contact Details'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('text', 'cli_email', __('Email'))
					->set_width(33)
					->set_attribute('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
					->set_classes('cli-email'),
				Field::make('text', 'cli_phone', __('Phone number'))
					->set_width(33)
					->set_classes('cli-phone'),
				Field::make('text', 'cli_mobile', __('Mobile number'))
					->set_width(33)
					->set_classes('cli-mobile'),
				Field::make('complex', 'cli_contacts', __('Other Contacts'))
					->add_fields(array(
						Field::make('text', 'cli_contact_name', __('Name'))
							->set_width(33)
							->set_classes('cli-contact-name'),
						Field::make('text', 'cli_contact_email', __('Email'))
							->set_width(33)
							->set_attribute('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
							->set_classes('cli-contact-email'),
						Field::make('text', 'cli_contact_mobile', __('Mobile number'))
							->set_width(33)
							->set_classes('cli-contact-mobile'),
					)),
			));
	}


	/**
	 * Create bank detail fields
	 */
	public static function fields_other()
	{
		Container::make('post_meta', __('Other Details'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('text', 'cli_tax_rate', __('Tax Rate (%)'))
					->set_width(50)
					->set_classes('cli-tax-rate')
					->set_attribute('data-number')
					->set_required(true),
					Field::make('text', 'cli_grace_period', __('Grace Period (Days)'))
					->set_width(50)
					->set_classes('cli-grace-period')
					->set_attribute('data-number')
					->set_required(true),
				Field::make('text', 'cli_vatid', __('VAT ID'))
					->set_width(50)
					->set_classes('cli-vatid'),
					Field::make('select', 'cli_currency', __('Currency'))
					->set_width(50)
					->set_options(\csip\admin\Helpers::get_currencies())
					->set_classes('cli-currency'),
			));
	}


	/**
	 * Create note fields
	 */
	public static function fields_note()
	{
		Container::make('post_meta', __('Note'))
			->where('post_type', '=', 'client')
			->add_fields(array(
				Field::make('textarea', 'cli_comment', __('Comment'))
					->set_classes('cli-comment'),
			));
	}
}
