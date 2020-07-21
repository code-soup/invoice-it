<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
defined('WPINC') || die;


/**
 * Class containing fields for the Plugin options page.
 *
 */
class Options
{

	/**
	 * Load all custom field metaboxes for Plugin Options
	 */
	public static function load()
	{
		self::fields_company();
	}


	/**
	 * Create fields for Company details
	 */
	public static function fields_company()
	{
		Container::make('theme_options', __('Company Info', 'cs-invoice-plugin'))
			->set_page_menu_title( __('Invoice Plugin', 'cs-invoice-plugin') )
			->add_tab(__('Branding', 'cs-invoice-plugin'), array(
				Field::make('text', 'csip_company_name', __('Company Name', 'cs-invoice-plugin'))
					->set_classes('csip-company-name'),
				Field::make('text', 'csip_company_web', __('Website', 'cs-invoice-plugin'))
					->set_classes('csip-company-web'),
				Field::make('image', 'csip_company_logo', __('Logo', 'cs-invoice-plugin'))
					->set_help_text('An image of your company logo for the Invoice header.')
					->set_classes('span-6 csip-company-logo'),
				Field::make('image', 'csip_company_signature', __('Signature', 'cs-invoice-plugin'))
					->set_help_text('A .png image of your signature if you want to insert it into Invoices.')
					->set_classes('span-6 csip-company-signature'),
			))
			->add_tab(__('Address', 'cs-invoice-plugin'), array(
				Field::make('text', 'csip_company_address_1', __('Address 1'))
					->set_classes('span-6 csip-company-address-1'),
				Field::make('text', 'csip_company_address_2', __('Address 2'))
					->set_classes('span-6 csip-company-address-2'),
				Field::make('text', 'csip_company_city', __('City', 'cs-invoice-plugin'))
					->set_classes('span-6 csip-company-city'),
				Field::make('text', 'csip_company_zip', __('Zip Code', 'cs-invoice-plugin'))
					->set_classes('span-6 csip-company-zip'),
				Field::make('select', 'csip_company_country', __('Country', 'cs-invoice-plugin'))
					->set_options(\csip\admin\Helpers::get_countries())
					->set_classes('span-6 csip-company-country'),
				Field::make('select', 'csip_company_state', __('State', 'cs-invoice-plugin'))
					->set_options(array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
					))
					->set_classes('span-6 csip-company-state'),
			))
			->add_tab(__('Contact', 'cs-invoice-plugin'), array(
				Field::make('text', 'csip_company_email', __('Email', 'cs-invoice-plugin'))
					->set_attribute('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
					->set_classes('csip-company-email'),
				Field::make('text', 'csip_company_phone', __('Phone number', 'cs-invoice-plugin'))
					->set_classes('csip-company-phone'),
			))
			->add_tab(__('Legal', 'cs-invoice-plugin'), array(
				Field::make('text', 'csip_company_id', __('Company ID', 'cs-invoice-plugin'))
					->set_classes('csip-company-id'),
				Field::make('select', 'csip_company_vatreg', __('VAT registered', 'cs-invoice-plugin'))
					->set_options(array(
						'0' => 'No',
						'1' => 'Yes',
					))
					->set_classes('span-6 csip-company-vatreg'),
				Field::make('text', 'csip_company_vatid', __('VAT ID', 'cs-invoice-plugin'))
					->set_conditional_logic(array(
						array(
							'field' => 'csip_company_vatreg',
							'value' => '1',
						)
					))
					->set_classes('span-6 csip-company-vatid'),
			))
			->add_tab(__('Bank Details', 'cs-invoice-plugin'), array(
				Field::make('complex', 'inv_items', __('Accounts', 'cs-invoice-plugin'))
					->setup_labels( array(
						'plural_name' => 'Accounts',
						'singular_name' => 'Account',
					))
					->add_fields('account', array(
						Field::make('text', 'csip_conpany_account_name', __('Name', 'cs-invoice-plugin'))
							->set_classes('csip-company-account-name'),
						Field::make('textarea', 'csip_company_account_details', __('Details', 'cs-invoice-plugin'))
							->set_classes('csip-company-account-details'),
					))
					->set_header_template( '
						<% if (csip_conpany_account_name) { %>
							<%- csip_conpany_account_name %>
						<% } %>
					' )
			))
			->add_tab(__('Invoice Options', 'cs-invoice-plugin'), array(
				Field::make('text', 'csip_company_nin', __('Next Invoice Number', 'cs-invoice-plugin'))
					->set_help_text('This will be the next Invoice number, change this only if you need to reset it.')
					->set_classes('csip-company-nin'),
				Field::make('textarea', 'csip_company_tnc', __('Terms & Conditions'))
					->set_classes('csip-company-tna'),
				Field::make('textarea', 'csip_company_note', __('Note', 'cs-invoice-plugin'))
					->set_classes('csip-company-dis'),
				Field::make('text', 'csip_company_ftext', __('Footer Text', 'cs-invoice-plugin'))
					->set_classes('csip-company-ftext'),
			));
	}
}
