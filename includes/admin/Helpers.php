<?php

namespace csip\admin;

// Exit if accessed directly
defined('WPINC') || die;


/**
 * Class contains helper functions for admin.
 *
 */
class Helpers
{

	public static function get_invoice_number()
	{

		return get_option('_csip_company_nin');
	}

	public static function set_invoice_number()
	{

		// update_option( '_csip_company_nin', '11' );
	}

	public static function get_clients()
	{

		$args = array(

			'post_type' => 'client',
		);

		$qry = new \WP_Query($args);

		$clients = [];
		foreach ($qry->posts as $client) {

			$clients[$client->ID] = $client->post_title;
		}

		array_multisort($clients);
		array_unshift($clients, '-- Select Client');

		return $clients;
	}

	public static function get_currencies()
	{
		$currencies = curriencies('longlist');
		$array = [];

		foreach ($currencies as $currency) {
			$array[$currency['iso_4217_code']] = $currency['iso_4217_name'];
		}

		array_multisort($array);
		array_unshift($array, '-- Select currency');

		return $array;
	}

	public static function get_countries()
	{
		$countries = countries();
		$array = [];

		foreach ($countries as $country) {
			$array[$country['iso_3166_1_alpha3']] = $country['name'];
		}

		array_multisort($array);
		array_unshift($array, '-- Select country');

		return $array;
	}
}
