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
		$first_option = array( '0' => __('-- Select Client', CSIP_TEXT_DOMAIN) );
		$array        = $first_option + $clients;

		return $array;
	}



	/**
	 * Return accounts of the company listed in options page
	 *
	 * @return array of $accounts
	 * @since    1.0.0
	 */
	public static function get_accounts() {

		$args = array(

			'post_type' => 'bankaccount',
		);

		$qry = new \WP_Query( $args );
		$accounts        = array();
		foreach ( $qry->posts as $account ) {
			$accounts[ $account->ID ] = $account->post_title;
		}

		asort( $accounts );
		$accounts = array( '-1' => __( '-- Select Account', CSIP_TEXT_DOMAIN ) ) + $accounts;

		return $accounts;
	}



	/**
	 * Return a list of currencies
	 *
	 * @return array of currencies
	 * @since    1.0.0
	 */
	public static function get_currencies() {

		$currencies = self::get_currencies_data();

		array_unshift( $currencies, __( '-- Select currency', CSIP_TEXT_DOMAIN ) );

		return $currencies;
	}



	/**
	 * Return list of all countries
	 *
	 * @return array of countries
	 * @since    1.0.0
	 */
	public static function get_countries() {
		$countries = self::get_countries_data();

		$array = array();
		foreach ( $countries as $country ) {
			$array[ $country['cca3'] ] = $country['name']['common'];
		}

		array_unshift( $array, __('-- Select country', CSIP_TEXT_DOMAIN) );

		return $array;
	}



	/**
	 * Return a list of states of a given country
	 *
	 * @return array
	 * @since    1.0.0
	 */
	// TODO: fetch states with AJAX
	public static function get_states() {
		$array = array(
			'0' => __( '-- Select State', CSIP_TEXT_DOMAIN ),
		);

		return $array;
	}



	/**
	 * Return countries data from transients, create transient if does ot exist
	 *
	 * @return void
	 */
	private static function get_countries_data() {

		$countries_data = get_transient( 'csip_countries' );

		if ( $countries_data === false ) {

			$countries_json = file_get_contents( CSIP_PATH . '/vendor/mledoze/countries/dist/countries.json' );
			$countries_data = json_decode( $countries_json, true );

			set_transient( 'csip_countries', $countries_data, 3600 * 24 );
		}

		return $countries_data;

	}


	/**
	 * Return contry name from cca3 iso code
	 *
	 * @param [type] $cca3_code
	 * @return void
	 */
	public static function get_country_name( $cca3_code ) {

		foreach ( self::get_countries_data() as $country ) {
			if ( $country['cca3'] === $cca3_code ) {
				$country_name = $country['name']['common'];
				break;
			}
		}

		return $country_name;

	}



	/**
	 * Return currencies data from transients, create transient if does ot exist
	 *
	 * @return void
	 */
	private static function get_currencies_data() {

		$currencies = get_transient( 'csip_currencies' );

		if ( $currencies === false ) {

			$countries_data = self::get_countries_data();

			$currencies = array();

			foreach ( $countries_data as $country_data ) {

				foreach ( $country_data['currencies'] as $cca3 => $currency ) {
					$symbol              = $currency['symbol'] ? ' (' . $currency['symbol'] . ')' : '';
					$currencies[ $cca3 ] = $currency['name'] . ' - ' . $cca3 . $symbol;
				}
			}

			set_transient( 'csip_currencies', $currencies, 3600 * 24 );

		}

		return $currencies;
	}
}


