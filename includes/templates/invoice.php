<?php

// do_action('wp_head');
get_header();

/**
 * Get compeny details
 * TODO: databse table name
 */
global $wpdb;
$wp_options_company = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options `wp_6_options` WHERE (CONVERT(`option_name` USING utf8) LIKE '%csip_%')", ARRAY_A );

$allowed_html = array(
	'b' => array(),
	'i' => array(),
);




$company_details = array();
foreach ( $wp_options_company as $value ) {
	$company_details[ $value['option_name'] ] = $value['option_value'];
}

$invoice_prefix = wp_kses( $company_details['_csip_company_prefix'], 'strip' );
$footernote     = wpautop( wp_kses( $company_details['_csip_company_note'], $allowed_html ) );
$footertext     = wpautop( wp_kses( $company_details['_csip_company_footertext'], $allowed_html ) );




/**
 * Get invoice details
 */
$invoice_details = array();
foreach ( get_post_meta( get_the_ID() ) as $key => $value ) {
	$invoice_details[ $key ] = $value[0];
}

$invoice_number          = $invoice_details['_inv_number'];
$invoice_date            = $invoice_details['_inv_date'];
$invoice_due             = $invoice_details['_inv_due_date'];
$invoice_payment_account = intval( $invoice_details['_inv_payment_account'] ); // TODO: #BAC find more robust solution.
$invoice_comment         = wp_kses( $invoice_details['_inv_comment'], 'strip' );
$client_id               = $invoice_details['_inv_client'];

$invoice_code = trim( $invoice_prefix ) . str_pad( $invoice_number, 4, '0', STR_PAD_LEFT );




// TODO: handle "if none selected" scenario (check for value or make the field required)
$i                  = 0;
$account_to_display = array();
$accounts           = carbon_get_theme_option( 'csip_company_bank_accounts' );
foreach ( $accounts as $account_details ) {
	if ( $i === $invoice_payment_account ) {
		$account_to_display = $account_details;
		break;
	}

	$i++;
}

$account_name          = $account_to_display['csip_conpany_account_name'];
$account_details       = wp_kses( $account_to_display['csip_company_account_details'], $allowed_html );
$account_details_other = wp_kses( $account_to_display['csip_company_account_details_other'], $allowed_html );




/**
 * Get client details
 */
$client_details = array();
foreach ( get_post_meta( $client_id ) as $key => $value ) {
	$client_details[ $key ] = $value[0];
}

$client_name      = wp_kses( $client_details['_cli_name'], 'strip' );
$client_address_1 = wp_kses( $client_details['_cli_address_1'], 'strip' );
$client_address_2 = wp_kses( $client_details['_cli_address_2'], 'strip' );
$client_city      = wp_kses( $client_details['_cli_city'], 'strip' );
$client_country   = $client_details['_cli_country'];
$client_state     = $client_details['_cli_state'];
$client_zip       = wp_kses( $client_details['_cli_zip'], 'strip' );
$client_tax_rate  = $client_details['_cli_tax_rate'];
$client_currency  = $client_details['_cli_currency'];

?>


<div class="csip-container">
	<section class="csip-invoice-plugin csip-invoice">

		<header class="csip-invoice-header">
			<div class="csip-row">
				<?php require PLUGIN_PATH . '/includes/templates/invoice/company-details.php'; ?>
			</div>
		</header>


		<article>

			<div class="csip-row csip-invoice-info">

				<div class="csip-span-8 csip-invoice-name-info">

					<h2 class="csip-invoice-title">
						<?php echo sprintf( '<span class="csip-invoice-title-text">%s</span><span class="csip-invoice-title-code">%s</span>', __( 'INVOICE', PLUGIN_TEXT_DOMAIN ), $invoice_code ); ?>
					</h2>

					<ul class="csip-invoice-list">
						<li class="csip-invoice-list-label">date</li>
						<li class="csip-invoice-list-entry"><?php echo $invoice_date; ?></li>
						<li class="csip-invoice-list-label">due</li>
						<li class="csip-invoice-list-entry"><?php echo $invoice_due; ?></li>
					</ul>

				</div>

				<div class="csip-span-4 csip-invoice-billto">
					<ul class="csip-invoice-list">
						<li class="csip-invoice-list-label">bill to</li>
						<li class="csip-invoice-list-entry csip-client-name"><?php echo $client_name; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $client_address_1; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $client_address_2; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $client_city . ', ' . $client_zip; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $client_country . ', ' . $client_state; ?></li>
					</ul>
				</div>

			</div>

			<div class="csip-invoice-items">
				<?php require PLUGIN_PATH . '/includes/templates/invoice/table.php'; ?>
			</div>

			<div class="csip-invoice-payment-info">
				<h5 class="csip-invoice-payment-title">
					<?php echo __( 'Ways to pay', PLUGIN_TEXT_DOMAIN ); ?>
				</h5>

				<div class="csip-invoice-account">
					<h4 class="csip-invoice-account-name"><?php echo $account_name; ?></h4>
					<div class="csip-row">
						<div class="csip-span-4">
							<?php echo wpautop( $account_details ); ?>
						</div>
						<div class="csip-span-4">
							<?php echo wpautop( $account_details_other ); ?>
						</div>
					</div>
				</div>

				<?php if ( $footernote ) { ?>
				<div class="csip-invoice-note">
					<?php
						echo sprintf( '<h5 class="csip-invoice-payment-note-title">%s</h5>', __( 'Note', PLUGIN_TEXT_DOMAIN ) );
						echo wpautop( wp_kses( $invoice_comment, 'post' ) );
					?>
				</div>
				<?php } ?>

			</div>

		</article>


		<?php if ( $footernote ) { ?>
		<div class="csip-invoice-note-global">
			<?php echo $footernote; ?>
		</div>
		<?php } ?>

		<?php if ( $footertext ) { ?>
		<div class="csip-invoice-footer">
			<?php echo $footertext; ?>
		</div>
		<?php } ?>

	</section>
</div>

<?php
get_footer();
