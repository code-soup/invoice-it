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
	 */
	public static function get_invoice_number() {
		return get_option( '_csip_company_nin' );
	}

	/**
	 * Set the next invoice number
	 *
	 * TODO: #NIN
	 */
	public static function set_invoice_number() {
		// update_option( '_csip_company_nin', '11' );
		// echo 'post type is:' . $post_type . $pagenow;
		// echo "<pre>";
		// print_r($wp);
		// echo "</pre>";
		// echo "<pre>";
		// print_r('yo yo yo y oy oyo');
		// echo "</pre>";
	}

	/**
	 * Return a list of clients
	 *
	 * @return array of clients
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
