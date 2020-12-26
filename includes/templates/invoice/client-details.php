<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// use csip\frontend\Helpers;

/**
 * Get client details
 */
$client_details = array();
foreach ( get_post_meta( $client_id ) as $key => $value ) {
	$client_details[ $key ] = $value[0];
}

// echo "<pre>";
// print_r($client_details);
// echo "</pre>";

$client_name      = wp_kses( $client_details['_cli_name'], 'strip' );
$client_address_1 = wp_kses( $client_details['_cli_address_1'], 'strip' );
$client_address_2 = wp_kses( $client_details['_cli_address_2'], 'strip' );
$client_city      = wp_kses( $client_details['_cli_city'], 'strip' );
$client_country   = country( $client_details['_cli_country'] )->getName();
$client_state     = $client_details['_cli_state'];
$client_zip       = wp_kses( $client_details['_cli_zip'], 'strip' );
$client_tax_rate  = $client_details['_cli_tax_rate'];
$client_currency  = $client_details['_cli_currency'];

$client_city_zip = $client_zip
				? ( $client_city . ', ' . $client_zip )
				: $client_city;

$client_country_state = $client_state
						? ( $client_country . ', ' . $client_state )
						: $client_country;

?>

<ul class="csip-invoice-list">
	<li class="csip-invoice-list-label">bill to</li>
	<li class="csip-invoice-list-entry csip-client-name"><?php echo $client_name; ?></li>
	<li class="csip-invoice-list-entry"><?php echo $client_address_1; ?></li>
	<li class="csip-invoice-list-entry"><?php echo $client_address_2; ?></li>
	<li class="csip-invoice-list-entry"><?php echo $client_city_zip; ?></li>
	<li class="csip-invoice-list-entry"><?php echo $client_country_state; ?></li>
</ul>
