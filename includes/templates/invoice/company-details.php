<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

$address_1 = wp_kses( $company_details['_csip_company_address_1'], 'strip' );
$address_2 = wp_kses( $company_details['_csip_company_address_2'], 'strip' );
$city      = wp_kses( $company_details['_csip_company_city'], 'strip' );
$country   = $company_details['_csip_company_country'];
$state     = $company_details['_csip_company_state'];
$zip       = wp_kses( $company_details['_csip_company_zip'], 'strip' );
$logo      = $company_details['_csip_company_logo'];
$phone     = wp_kses( $company_details['_csip_company_phone'], 'strip' );
$email     = wp_kses( $company_details['_csip_company_email'], 'strip' );
?>

<div class="csip-span-8 csip-company-details">
	<ul class="csip-invoice-list">
		<li class="csip-invoice-list-entry"><?php echo $address_1; ?></li>
		<li class="csip-invoice-list-entry"><?php echo $address_2; ?></li>
		<li class="csip-invoice-list-entry">
			<span class="csip-company-city"><?php echo $city; ?></span>
			<span class="csip-company-country"><?php echo $country; ?></span>
			<span class="csip-company-state"><?php echo $state; ?></span>
		</li>
		<li class="csip-invoice-list-entry"><?php echo $zip; ?></li>
		<li class="csip-invoice-list-entry"><?php echo $phone; ?></li>
		<li class="csip-invoice-list-entry"><?php echo $email; ?></li>
	</ul>
</div>

<div class="csip-span-4 csip-company-logo">
	<div class="thumb">
		<span style="background-image: url('<?php echo $logo; ?>')"></span>
	</div>
</div>
