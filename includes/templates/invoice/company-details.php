<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

$name           = wp_kses( $company_details['_csip_company_name'], 'strip' );
$address_1      = wp_kses( $company_details['_csip_company_address_1'], 'strip' );
$address_2      = wp_kses( $company_details['_csip_company_address_2'], 'strip' );
$city           = wp_kses( $company_details['_csip_company_city'], 'strip' );
$country        = $company_details['_csip_company_country'];
$state          = $company_details['_csip_company_state'];
$zip            = wp_kses( $company_details['_csip_company_zip'], 'strip' );
$logo           = $company_details['_csip_company_logo'];
$phone          = wp_kses( $company_details['_csip_company_phone'], 'strip' );
$email          = wp_kses( $company_details['_csip_company_email'], 'strip' );
$invoice_prefix = wp_kses( $company_details['_csip_company_prefix'], 'strip' );

?>

<div class="csip-span-8 csip-company-details">
	<ul class="csip-invoice-list">
		<?php if ( $name) : ?>
			<li class="csip-invoice-list-entry csip-company-name"><?php echo $name; ?></li>
		<?php endif; ?>
		<?php if ( $address_1 ) : ?>
			<li class="csip-invoice-list-entry"><?php echo $address_1; ?></li>
		<?php endif; ?>
		<?php if ( $address_2 ) : ?>
			<li class="csip-invoice-list-entry"><?php echo $address_2; ?></li>
		<?php endif; ?>
		<?php if ( $city || $country || $state ) : ?>
			<li class="csip-invoice-list-entry">
				<?php if ( $city ) : ?>
					<span class="csip-company-city"><?php echo $city; ?></span>
				<?php endif; ?>
				<?php if ( $country ) : ?>
					<span class="csip-company-country"><?php echo $country; ?></span>
				<?php endif; ?>
				<?php if ( $state ) : ?>
					<span class="csip-company-state"><?php echo $state; ?></span>
				<?php endif; ?>
			</li>
		<?php endif; ?>
		<?php if ( $zip ) : ?>
			<li class="csip-invoice-list-entry"><?php echo $zip; ?></li>
		<?php endif; ?>
		<?php if ( $phone ) : ?>
			<li class="csip-invoice-list-entry"><strong>T: </strong><?php echo $phone; ?></li>
		<?php endif; ?>
		<?php if ( $email ) : ?>
			<li class="csip-invoice-list-entry"><strong>E: </strong><?php echo $email; ?></li>
		<?php endif; ?>
	</ul>
</div>

<?php if ( $logo ) : ?>
	<div class="csip-span-4 csip-company-logo">
		<div class="thumb">
			<span style="background-image: url('<?php echo $logo; ?>')"></span>
		</div>
	</div>
<?php endif;
