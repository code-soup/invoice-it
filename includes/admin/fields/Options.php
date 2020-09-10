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
		Container::make('theme_options', __('Company Info', PLUGIN_TEXT_DOMAIN))
			->set_page_menu_title( __('Invoice Plugin', PLUGIN_TEXT_DOMAIN) )
			->add_tab(__('Branding', PLUGIN_TEXT_DOMAIN), array(
				Field::make('text', 'csip_company_name', __('Company Name', PLUGIN_TEXT_DOMAIN))
					->set_classes('csip-company-name'),
				Field::make('text', 'csip_company_web', __('Website', PLUGIN_TEXT_DOMAIN))
					->set_classes('csip-company-web'),
				Field::make('image', 'csip_company_logo', __('Logo', PLUGIN_TEXT_DOMAIN))
					->set_help_text('An image of your company logo for the Invoice header.')
					->set_classes('span-6 csip-company-logo')->set_value_type( 'url' ),
				Field::make('image', 'csip_company_signature', __('Signature', PLUGIN_TEXT_DOMAIN))
					->set_help_text('A .png image of your signature if you want to insert it into Invoices.')
					->set_classes('span-6 csip-company-signature')
					->set_value_type( 'url' ),
			))
			->add_tab(__('Address', PLUGIN_TEXT_DOMAIN), array(
				Field::make('text', 'csip_company_address_1', __('Address 1'))
					->set_classes('span-6 csip-company-address-1'),
				Field::make('text', 'csip_company_address_2', __('Address 2'))
					->set_classes('span-6 csip-company-address-2'),
				Field::make('text', 'csip_company_city', __('City', PLUGIN_TEXT_DOMAIN))
					->set_classes('span-6 csip-company-city'),
				Field::make('text', 'csip_company_zip', __('Zip Code', PLUGIN_TEXT_DOMAIN))
					->set_classes('span-6 csip-company-zip'),
				Field::make('select', 'csip_company_country', __('Country', PLUGIN_TEXT_DOMAIN))
					->set_options(\csip\admin\Helpers::get_countries())
					->set_classes('span-6 csip-company-country csip-select2'),
				Field::make('select', 'csip_company_state', __('State', PLUGIN_TEXT_DOMAIN))
					->set_options(\csip\admin\Helpers::get_states())
					->set_classes('span-6 csip-company-state csip-select2'),
			))
			->add_tab(__('Contact', PLUGIN_TEXT_DOMAIN), array(
				Field::make('text', 'csip_company_email', __('Email', PLUGIN_TEXT_DOMAIN))
					->set_attribute('pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$')
					->set_classes('csip-company-email'),
				Field::make('text', 'csip_company_phone', __('Phone number', PLUGIN_TEXT_DOMAIN))
					->set_classes('csip-company-phone'),
			))
			->add_tab(__('Legal', PLUGIN_TEXT_DOMAIN), array(
				Field::make('text', 'csip_company_id', __('Company ID', PLUGIN_TEXT_DOMAIN))
					->set_classes('csip-company-id'),
				Field::make('select', 'csip_company_vatreg', __('VAT registered', PLUGIN_TEXT_DOMAIN))
					->set_options(array(
						'0' => 'No',
						'1' => 'Yes',
					))
					->set_classes('span-6 csip-company-vatreg'),
				Field::make('text', 'csip_company_vatid', __('VAT ID', PLUGIN_TEXT_DOMAIN))
					->set_conditional_logic(array(
						array(
							'field' => 'csip_company_vatreg',
							'value' => '1',
						)
					))
					->set_classes('span-6 csip-company-vatid'),
			))
			->add_tab(__('Bank Details', PLUGIN_TEXT_DOMAIN), array(
				Field::make('complex', 'csip_company_bank_accounts', __('Accounts', PLUGIN_TEXT_DOMAIN))
					->setup_labels( array(
						'plural_name' => 'Accounts',
						'singular_name' => 'Account',
					))
					->add_fields('account', array(
						Field::make('text', 'csip_conpany_account_name', __('Name', PLUGIN_TEXT_DOMAIN))
							->set_classes('csip-company-account-name'),
						Field::make('textarea', 'csip_company_account_details', __('Details', PLUGIN_TEXT_DOMAIN))
							->set_classes('csip-company-account-details'),
					))
					->set_header_template( '
						<% if (csip_conpany_account_name) { %>
							<%- csip_conpany_account_name %>
						<% } %>
					' )
			))
			->add_tab(__('Invoice Options', PLUGIN_TEXT_DOMAIN), array(
				Field::make('text', 'csip_company_prefix', __('Invoice Prefix', PLUGIN_TEXT_DOMAIN))
					->set_attribute('maxLength', 4)
					->set_help_text('If needed you can prefix the invoice number with up to 4 characters in the print version of the invoice.')
					->set_classes('span-6 csip-company-prefix'),
				Field::make('number', 'csip_company_nin', __('Next Invoice Number', PLUGIN_TEXT_DOMAIN))
					->set_help_text('This will be the next Invoice number, change this only if you need to reset it.')
					->set_default_value(0)
					->set_classes('span-6 csip-company-nin'),
				Field::make('textarea', 'csip_company_terms', __('Terms & Conditions'))
					->set_classes('csip-company-terms'),
				Field::make('textarea', 'csip_company_note', __('Note', PLUGIN_TEXT_DOMAIN))
					->set_classes('csip-company-dis'),
				Field::make('text', 'csip_company_footertext', __('Footer Text', PLUGIN_TEXT_DOMAIN))
					->set_classes('csip-company-footertext'),
			));
	}
}
