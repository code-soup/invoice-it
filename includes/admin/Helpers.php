<?php

namespace csip\admin;

// Exit if accessed directly
defined( 'WPINC' ) || die;


/**
 * Class contains helper functions for admin.
 *
 */
class Helpers {

	public static function get_currencies() {
		$currencies = curriencies('longlist');
		$curr_array = [];

		foreach ($currencies as $currency) {
			$curr_array[$currency['iso_4217_code']] = $currency['iso_4217_name'];
		}

		return $curr_array;
	}

	public static function get_countries() {
		$countries = countries();
		$co_array = [];
		$co_array[''] = 'Select country';

		foreach ($countries as $country) {
			$co_array[$country['iso_3166_1_alpha3']] = $country['name'];
		}

		return $co_array;
	}
}