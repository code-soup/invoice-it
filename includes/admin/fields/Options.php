<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class containing fields for the Plugin options page.
 *
 * @since    1.0.0
 */
class Options {


	/**
	 * Load all custom field metaboxes for Plugin Options
	 *
	 * @since    1.0.0
	 */
	public static function load() {
		self::fields_company();
	}

	/**
	 * Create fields for Company details
	 *
	 * @since    1.0.0
	 */
	private static function fields_company() {
		$allowed_tags_info = __( 'The following HTML tags are allowed: ', CSIP_TEXT_DOMAIN ) . '&lt;b&gt;, &lt;i&gt;';

		Container::make( 'theme_options', __( 'Company Info', CSIP_TEXT_DOMAIN ) )
			->set_page_menu_title( __( 'Invoice Plugin', CSIP_TEXT_DOMAIN ) )
			->add_tab(
				__( 'Branding', CSIP_TEXT_DOMAIN ),
				array(
					Field::make( 'text', 'csip_company_name', __( 'Company Name', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-name' ),
					Field::make( 'text', 'csip_company_web', __( 'Website', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-web' ),
					Field::make( 'image', 'csip_company_logo', __( 'Logo', CSIP_TEXT_DOMAIN ) )
						->set_help_text( __( 'An image of your company logo for the Invoice header.', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-logo' )->set_value_type( 'url' ),
					Field::make( 'image', 'csip_company_signature', __( 'Signature', CSIP_TEXT_DOMAIN ) )
						->set_help_text( __( 'A .png image of your signature if you want to insert it into Invoices.', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-signature' )
						->set_value_type( 'url' ),
				)
			)
			->add_tab(
				__( 'Address', CSIP_TEXT_DOMAIN ),
				array(
					Field::make( 'text', 'csip_company_address_1', __( 'Address 1', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-address-1' ),
					Field::make( 'text', 'csip_company_address_2', __( 'Address 2', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-address-2' ),
					Field::make( 'text', 'csip_company_city', __( 'City', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-city' ),
					Field::make( 'text', 'csip_company_zip', __( 'Zip Code', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-zip' ),
					Field::make( 'select', 'csip_company_country', __( 'Country', CSIP_TEXT_DOMAIN ) )
						->set_options( \csip\admin\Helpers::get_countries() )
						->set_classes( 'span-6 csip-company-country csip-select2' ),
					Field::make( 'select', 'csip_company_state', __( 'State', CSIP_TEXT_DOMAIN ) )
						->set_options( \csip\admin\Helpers::get_states() )
						->set_classes( 'span-6 csip-company-state csip-select2' ),
				)
			)
			->add_tab(
				__( 'Contact', CSIP_TEXT_DOMAIN ),
				array(
					Field::make( 'text', 'csip_company_email', __( 'Email', CSIP_TEXT_DOMAIN ) )
						->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
						->set_classes( 'csip-company-email' ),
					Field::make( 'text', 'csip_company_phone', __( 'Phone number', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-phone' ),
				)
			)
			->add_tab(
				__( 'Legal', CSIP_TEXT_DOMAIN ),
				array(
					Field::make( 'text', 'csip_company_id', __( 'Company ID', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-id' ),
					Field::make( 'select', 'csip_company_vatreg', __( 'VAT registered', CSIP_TEXT_DOMAIN ) )
					->set_options(
						array(
							'0' => 'No',
							'1' => 'Yes',
						)
					)
					->set_classes( 'span-6 csip-company-vatreg' ),
					Field::make( 'text', 'csip_company_vatid', __( 'VAT ID', CSIP_TEXT_DOMAIN ) )
					->set_conditional_logic(
						array(
							array(
								'field' => 'csip_company_vatreg',
								'value' => '1',
							),
						)
					)
					->set_classes( 'span-6 csip-company-vatid' ),
				)
			)
			->add_tab(
				__( 'Invoice Options', CSIP_TEXT_DOMAIN ),
				array(
					Field::make( 'text', 'csip_company_prefix', __( 'Invoice Prefix', CSIP_TEXT_DOMAIN ) )
						->set_attribute( 'maxLength', 4 )
						->set_help_text( __( 'If needed you can prefix the invoice number with up to 4 characters for the print version of the invoice.', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'span-6 csip-company-prefix' ),
					Field::make( 'number', 'csip_company_nin', __( 'Next Invoice Number', CSIP_TEXT_DOMAIN ) )
						->set_help_text( __( 'This will be the next Invoice number, change this only if you need to reset it.', CSIP_TEXT_DOMAIN ) )
						->set_default_value( 0 )
						->set_classes( 'span-6 csip-company-nin' ),
					Field::make( 'textarea', 'csip_company_terms', __( 'Terms & Conditions', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-terms' ),
					Field::make( 'textarea', 'csip_company_note', __( 'Note', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-dis' ),
					Field::make( 'text', 'csip_company_footertext', __( 'Footer Text', CSIP_TEXT_DOMAIN ) )
						->set_classes( 'csip-company-footertext' ),
				)
			);
	}
}
