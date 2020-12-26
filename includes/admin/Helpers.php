<?php

namespace csip\admin;

// Exit if accessed directly.
defined( 'WPINC' ) || die;


/**
 * Class contains helper functions for admin.
 */
class Helpers {


	/**
	 * Get invoice number for a new invoice
	 *
	 * @return int
	 * @since    1.0.0
	 */
	public static function get_next_invoice_number() {
		return get_option( '_csip_company_nin' );
	}

	/**
	 * Set the next invoice number
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public static function set_next_invoice_number() {

		// TODO: check if the invoice already exists with the same invoice prrefix & invoice number

		$nin = get_option( '_csip_company_nin' ) + 1;
		update_option( '_csip_company_nin', $nin );
	}

	/**
	 * Return a list of clients
	 *
	 * @return array of clients
	 * @since    1.0.0
	 */
	public static function get_clients() {
		$args = array(

			'post_type' => 'client',
		);

		$qry = new \WP_Query( $args );

		$clients = array();
		foreach ( $qry->posts as $client ) {
			$clients[ $client->ID ] = $client->post_title;
		}

		asort( $clients );
		$first_option = array( '0' => '-- Select Client' );
		$array        = $first_option + $clients;

		return $array;
	}

	/**
	 * Return accounts of the company listed in options page
	 * TODO: #BAC find more robust solution.
	 *
	 * @return array of $accounts
	 * @since    1.0.0
	 */
	public static function get_accounts() {
		$i               = 0;
		$accounts        = array();
		$account_details = carbon_get_theme_option( 'csip_company_bank_accounts' );
		foreach ( $account_details as $detail ) {
			$accounts [ $i ] = $detail['csip_conpany_account_name'];
			$i++;
		}

		asort( $accounts );
		$accounts = array( '-1' => '-- Select Account' ) + $accounts;

		return $accounts;
	}

	/**
	 * Return a list of currencies
	 *
	 * @return array of currencies
	 * @since    1.0.0
	 */
	public static function get_currencies() {
		$currencies = curriencies( 'longlist' );
		$array      = array();

		foreach ( $currencies as $currency ) {
			$array[ $currency['iso_4217_code'] ] = $currency['iso_4217_name'];
		}

		asort( $array );
		array_unshift( $array, '-- Select currency' );

		return $array;
	}

	/**
	 * Return list of all countries
	 *
	 * @return array of countries
	 * @since    1.0.0
	 */
	public static function get_countries() {
		$countries = countries();
		$array     = array();

		foreach ( $countries as $country ) {
			$array[ $country['iso_3166_1_alpha3'] ] = $country['name'];
		}

		asort( $array );
		array_unshift( $array, '-- Select country' );

		return $array;
	}

	/**
	 * Return a list of states of a given country
	 * TODO: do this right
	 *
	 * @return array
	 * @since    1.0.0
	 */
	public static function get_states() {
		$array = array(
			'0' => '-- Select State',
			'1' => 'Alabama',
			'2' => 2,
			'3' => 3,
			'4' => 4,
			'5' => 5,
		);

		return $array;
	}
}
