<?php

namespace csip\admin;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
defined( 'WPINC' ) || die;


/**
 * Class contains all the custom fields.
 *
 */
class Fields {

	public static function load() {

		self::crb_attach_plugin_options();
		self::crb_attach_invoice_fields();
		self::crb_attach_client_fields();
	}


	/**
	 * Plugin options
	 *
	 * Load all tabs & fields for plugin options
	 *
	 * @return void
	 */

	/**
	 * 	Name*
		Address*
		City*
		Zip code*
		Country*
		State
		Phone*
		E-mail*
		web
		Logo
		Legal form*
		User in the VAT system*
		Company identification number
		VAT ID
		BIC/SWIFT
		Signature
	 */
	public static function crb_attach_plugin_options() {
		Container::make( 'theme_options', __( 'Invoice Plugin', 'crb' ) )
			->add_fields( array(
				Field::make( 'text', 'csip_company_name', __( 'Company Name' ) )
					->set_required( true ),
				Field::make( 'text', 'csip_company_address', __( 'Address' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'text', 'csip_company_city', __( 'City' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'text', 'csip_company_zip', __( 'Zip Code' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'select', 'csip_company_country', __( 'Country' ) )
					->set_options( \csip\admin\Helpers::get_countries() )
					->set_required( true )
					->set_width( 50 ),
				Field::make( 'select', 'csip_company_state', __( 'State' ) )
					->set_options( array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
					) )
					->set_width( 50 ),
				Field::make( 'text', 'csip_company_web', __( 'Website' ) )
					->set_attribute( 'pattern', 'https?://.+' )
					->set_width( 33 ),
				Field::make( 'text', 'csip_company_email', __( 'Email' ) )
					->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' )
					->set_width( 33 ),
				Field::make( 'text', 'csip_company_phone', __( 'Phone number' ) )
					->set_width( 33 ),
				Field::make( 'image', 'csip_company_logo', __( 'Logo' ) )
					->set_width( 50 ),
				Field::make( 'image', 'csip_company_signature', __( 'Signature' ) )
					->set_width( 50 ),
				Field::make( 'text', 'csip_company_id', __( 'Company ID' ) )
					->set_width( 33 ),
				Field::make( 'text', 'csip_company_swift', __( 'BIC/SWIFT' ) )
					->set_width( 33 ),
				Field::make( 'text', 'csip_company_vatid', __( 'VAT ID' ) )
					->set_width( 33 ),
				Field::make( 'select', 'csip_company_form', __( 'Legal Form' ) )
					->set_options( array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
					) )
					->set_width( 50 ),
				Field::make( 'select', 'csip_company_invat', __( 'In VAT system?' ) )
					->set_options( array(
						'0' => 'No',
						'1' => 'Yes',
					) )
					->set_width( 50 ),
			) );
	}

	/**
	 * Invoice fields
	 *
	**/

	public static function crb_attach_invoice_fields() {
		$item_col_width = 10;
		Container::make( 'post_meta', __( 'Invoice' ) )
			->where( 'post_type', '=', 'invoice' )
			->add_fields( array(
				Field::make( 'association', 'inv_association', __( 'Client' ) )
					->set_types( array(
						array(
							'type'      => 'post',
							'post_type' => 'client',
						)
					) )
					->set_max( 1 ),
				Field::make( 'text', 'inv_number', __( 'Invoice number' ) )
					->set_width( 33 ),
				Field::make( 'select', 'inv_payment_method', __( 'Payment Method' ) )
					->set_options( array(
						'cash'			=> 'Cash',
						'bank'			=> 'Bank transfer',
						'transaction'	=> 'Transaction account',
						'card'			=> 'Card',
						'check'			=> 'Check',
						'paypal'		=> 'Paypal',
						'stripe'		=> 'Stripe',
						'other'			=> 'Other',
					) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'select', 'inv_status', __( 'Invoice Status' ) )
					->set_options( array(
							'inv_unpaid' => 'Unpaid',
							'inv_paid' => 'Paid',
							'inv_paid_partially' => 'Paid Partially',
					) )
					->set_width( 33 ),
				Field::make( 'date_time', 'inv_date', __( 'Invoice Time' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'date', 'inv_due_date', __( 'Invoice Due Date' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'date', 'inv_delivery_date', __( 'Delivery Date' ) )
					->set_width( 33 ),
				Field::make( 'text', 'inv_office', __( 'Office' ) )
					->set_width( 50 ),
				Field::make( 'text', 'inv_billing_device', __( 'Billing Device' ) )
					->set_width( 50 ),
				Field::make( 'textarea', 'inv_remark', __( 'Remark' ) ),
				Field::make( 'separator', 'inv_separator', __( 'Invoice items' ) ),
				Field::make( 'complex', 'inv_items', __( 'Items' ) )
					->add_fields( array(
						Field::make( 'text', 'inv_item_name', __( 'Name' ) )
							->set_width( $item_col_width ),
						Field::make( 'text', 'inv_item_code', __( 'Code' ) )
							->set_width( $item_col_width ),
						Field::make( 'select', 'inv_item_um', __( 'Unit' ) )
							->set_options( array(
								''  => 'Select unit',
								'm' => 'Minutes',
								'h' => 'Hours',
								'd' => 'Days',
								'p' => 'Pieces',
								'g' => 'Grams',
								'o' => 'Ounces',
							) )
							->set_width( $item_col_width )
							->set_required( true ),
						Field::make( 'text', 'inv_item_amount', __( 'Amount' ) )
							// ->set_attribute( 'pattern', '[0-9]' )
							->set_attribute( 'min', 1 )
							->set_attribute( 'data-item-factor' )
							->set_attribute( 'data-item-amount' )
							->set_width( $item_col_width )
							->set_required( true ),
						Field::make( 'text', 'inv_item_price', __( 'Price per Unit' ) )
							// ->set_attribute( 'pattern', '[0-9]' )
							->set_attribute( 'min', 1 )
							->set_attribute( 'data-item-factor' )
							->set_attribute( 'data-item-price' )
							->set_width( $item_col_width )
							->set_required( true ),
						Field::make( 'text', 'inv_item_discount', __( 'Discount (%)' ) )
							// ->set_attribute( 'pattern', '[0-9]' )
							->set_attribute( 'min', 1 )
							->set_attribute( 'max', 100 )
							->set_default_value( 0 )
							->set_attribute( 'data-item-factor' )
							->set_attribute( 'data-item-discount' )
							->set_width( $item_col_width )
							->set_required( true ),
						Field::make( 'text', 'inv_item_total', __( 'Total' ) )
							->set_attribute( 'readOnly', true )
							->set_attribute( 'data-item-total' )
							->set_width( $item_col_width ),
					) )
					->set_classes( 'cf-invoice-items' ),
			) );
	}


	/**
	 * Client fields
	 */
	public static function crb_attach_client_fields() {
		Container::make( 'post_meta', __( 'Client' ) )
			->where( 'post_type', '=', 'client' )
			->add_fields( array(
				Field::make( 'text', 'cli_address', __( 'Address' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'text', 'cli_city', __( 'City' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'text', 'cli_zip', __( 'Zip code' ) )
					->set_required( true )
					->set_width( 33 ),
				Field::make( 'select', 'cli_country', __( 'Country' ) )
					->set_options( \csip\admin\Helpers::get_countries() )
					->set_required( true )
					->set_width( 50 ),
				Field::make( 'select', 'cli_state', __( 'State' ) )
					->set_options( array(
						'1' => 1,
						'2' => 2,
						'3' => 3,
						'4' => 4,
						'5' => 5,
					) )
					->set_width( 50 ),
				Field::make( 'text', 'cli_email', __( 'Email' ) )
					->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' ),
				Field::make( 'text', 'cli_phone', __( 'Phone number' ) )
					->set_width( 50 ),
				Field::make( 'text', 'cli_mobile', __( 'Mobile number' ) )
					->set_width( 50 ),
				Field::make( 'complex', 'cli_contacts', __( 'Contacts' ) )
					->add_fields( array(
						Field::make( 'text', 'cli_contact_name', __( 'Name' ) )
							->set_width( 33 ),
						Field::make( 'text', 'cli_contact_email', __( 'Email' ) )
							->set_width( 33 )
							->set_attribute( 'pattern', '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$' ),
						Field::make( 'text', 'cli_contact_mobile', __( 'Mobile number' ) )
							->set_width( 33 ),
					) ),
				Field::make( 'text', 'cli_iban', __( 'IBAN' ) )
				->set_width( 33 ),
				Field::make( 'text', 'cli_swift', __( 'BIC/SWIFT' ) )
				->set_width( 33 ),
				Field::make( 'text', 'cli_vatid', __( 'VAT ID' ) )
				->set_width( 33 ),
				Field::make( 'select', 'cli_international', __( 'International client' ) )
					->set_options( array(
						'0' => 'No',
						'1' => 'Yes',
					) )
					->set_width( 33 ),
				Field::make( 'select', 'cli_currency', __( 'Currency' ) )
					->set_options( \csip\admin\Helpers::get_currencies() )
					->set_width( 33 ),
				Field::make( 'text', 'cli_discount', __( 'Discount (%)' ) )
					->set_attribute( 'pattern', '[0-9]' )
					->set_attribute( 'min', 0 )
					->set_attribute( 'max', 100 )
					->set_width( 33 ),
				Field::make( 'textarea', 'cli_remark', __( 'Remark' ) ),
			) );
	}

}