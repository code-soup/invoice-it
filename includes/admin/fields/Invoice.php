<?php

namespace csip\admin\fields;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Exit if accessed directly
defined('WPINC') || die;


/**
 * Class containing fields for the Invoice post-type

 */
class Invoice
{

	/**
	 * Load all custom field metaboxes for the Invoice post-type
	 */
	public static function load()
	{
		self::fields_general();
		self::fields_items();
		self::fields_note();
	}


	/**
	 * Create general fields
	 */
	public static function fields_general()
	{
		Container::make('post_meta', __('General', PLUGIN_TEXT_DOMAIN))
			->where('post_type', '=', 'invoice')
			->add_fields(array(
				Field::make('text', 'inv_number', __('Invoice number', PLUGIN_TEXT_DOMAIN))
					->set_attribute('readOnly', true)
					->set_default_value(\csip\admin\Helpers::get_invoice_number())
					->set_classes('span-4 inv-number'),
				Field::make('select', 'inv_client', __('Client', PLUGIN_TEXT_DOMAIN))
					->set_options(\csip\admin\Helpers::get_clients())
					->set_classes('span-4 inv-client csip-select2'),
				Field::make('select', 'inv_status', __('Invoice Status', PLUGIN_TEXT_DOMAIN))
					->set_options(array(
						'' => __('-- Please Select'),
						'inv_outstanding' => 'Outstanding',
						'inv_paid' => 'Paid',
						'inv_partially_paid' => 'Partially Paid',
					))
					->set_classes('span-4 inv-status csip-select2'),
				Field::make('date', 'inv_date', __('Invoice Date', PLUGIN_TEXT_DOMAIN))
					->set_classes('span-4 inv-date'),
				Field::make('number', 'inv_net_period', __('Net', PLUGIN_TEXT_DOMAIN))
					->set_min(0)
					->set_classes('span-4 inv-net-period')
					->set_help_text('Days until the payment is due'),
				Field::make('date', 'inv_due_date', __('Invoice Due Date', PLUGIN_TEXT_DOMAIN))
					->set_classes('span-4 inv-due-date'),
			));
	}


	/**
	 * Create item repeater fields
	 */
	public static function fields_items()
	{
		Container::make('post_meta', __('Items list', PLUGIN_TEXT_DOMAIN))
			->where('post_type', '=', 'invoice')
			->add_fields(array(
				Field::make('complex', 'inv_items', __('Items', PLUGIN_TEXT_DOMAIN))
					->setup_labels( array(
						'plural_name' => 'Items',
						'singular_name' => 'Item',
					))
					->add_fields(array(
						Field::make('text', 'inv_item_title', __('Title', PLUGIN_TEXT_DOMAIN))
							->set_classes('inv-item-title'),
						Field::make('textarea', 'inv_item_description', __('Description', PLUGIN_TEXT_DOMAIN))
							->set_rows(2)
							->set_classes('inv-item-description'),
						Field::make('number', 'inv_item_quantity', __('Quantity', PLUGIN_TEXT_DOMAIN))
							->set_min(0)
							->set_classes('span-item-col inv-item-quantity'),
						Field::make('text', 'inv_item_um', __('Unit', PLUGIN_TEXT_DOMAIN))
							->set_classes('span-item-col inv-item-um'),
						Field::make('number', 'inv_item_rate', __('Rate', PLUGIN_TEXT_DOMAIN))							->set_min(0)
							->set_classes('span-item-col inv-item-rate'),
						Field::make('number', 'inv_item_discount', __('Discount (%)'))
							->set_min(0)
							->set_max(100)
							->set_default_value(0)
							->set_classes('span-item-col inv-item-discount'),
						Field::make('text', 'inv_item_amount', __('Amount', PLUGIN_TEXT_DOMAIN))
							->set_attribute('readOnly', true)
							->set_classes('span-item-col inv-item-amount'),
					))
					->set_header_template( '
						<% if (inv_item_title) { %>
							<%- inv_item_title %>
						<% } %>
					' )
					->set_classes('cf-invoice-items'),
			));
	}


	/**
	 * Create note fields
	 */
	public static function fields_note()
	{
		Container::make('post_meta', __('Note', PLUGIN_TEXT_DOMAIN))
			->where('post_type', '=', 'invoice')
			->add_fields(array(
				Field::make('textarea', 'inv_comment', __('Comment', PLUGIN_TEXT_DOMAIN))
					->set_classes('inv-comment'),
			));
	}
}
