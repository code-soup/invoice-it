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
		Container::make('post_meta', __('General'))
			->where('post_type', '=', 'invoice')
			->add_fields(array(
				Field::make('text', 'inv_number', __('Invoice number'))
					->set_attribute('readOnly', true)
					->set_classes('span-4 inv-number'),
				Field::make('select', 'inv_client', __('Client'))
					->set_options(\csip\admin\Helpers::get_clients())
					->set_classes('span-4 inv-client'),
				Field::make('select', 'inv_status', __('Invoice Status'))
					->set_options(array(
						'' => __('-- Please Select'),
						'inv_outstanding' => 'Outstanding',
						'inv_paid' => 'Paid',
						'inv_partially_paid' => 'Partially Paid',
					))
					->set_classes('span-4 inv-status'),
				Field::make('date', 'inv_date', __('Invoice Date'))
					->set_classes('span-4 inv-date'),
				Field::make('number', 'inv_net_period', __('Net'))
					->set_min(0)
					->set_required(true)
					->set_classes('span-4 inv-net-period')
					->set_help_text('Days until the payment is due'),
				Field::make('date', 'inv_due_date', __('Invoice Due Date'))
					->set_classes('span-4 inv-due-date'),
			));
	}


	/**
	 * Create item repeater fields
	 */
	public static function fields_items()
	{
		Container::make('post_meta', __('Items list'))
			->where('post_type', '=', 'invoice')
			->add_fields(array(
				Field::make('complex', 'inv_items', __('Items'))
					->setup_labels( array(
						'plural_name' => 'Items',
						'singular_name' => 'Item',
					))
					->add_fields(array(
						Field::make('text', 'inv_item_title', __('Title'))
							->set_classes('inv-item-title'),
						Field::make('textarea', 'inv_item_description', __('Description'))
							->set_rows(2)
							->set_classes('inv-item-description'),
						Field::make('number', 'inv_item_quantity', __('Quantity'))
							->set_min(0)
							->set_required(true)
							->set_classes('span-item-col inv-item-quantity'),
						Field::make('text', 'inv_item_um', __('Unit'))
							->set_classes('span-item-col inv-item-um'),
						Field::make('number', 'inv_item_rate', __('Rate'))							->set_min(0)
							->set_required(true)
							->set_classes('span-item-col inv-item-rate'),
						Field::make('number', 'inv_item_discount', __('Discount (%)'))
							->set_min(0)
							->set_max(100)
							->set_default_value(0)
							->set_required(true)
							->set_classes('span-item-col inv-item-discount'),
						Field::make('text', 'inv_item_amount', __('Amount'))
							->set_attribute('readOnly', true)
							->set_classes('span-item-col inv-item-amount'),
					))
					->set_classes('cf-invoice-items'),
			));
	}


	/**
	 * Create note fields
	 */
	public static function fields_note()
	{
		Container::make('post_meta', __('Note'))
			->where('post_type', '=', 'invoice')
			->add_fields(array(
				Field::make('textarea', 'inv_comment', __('Comment'))
					->set_classes('inv-comment'),
			));
	}
}
