<?php

// do_action('wp_head');
get_header();

global $wpdb;

$allowed_html = array(
	'b' => array(),
	'i' => array(),
);



/**
 * Get compeny details
 * TODO: databse table name
 */
$wp_options_company = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options `wp_6_options` WHERE (CONVERT(`option_name` USING utf8) LIKE '%csip_%')", ARRAY_A );

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

$invoice_payment_account = intval( $invoice_details['_inv_payment_account'] );

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
					<?php require PLUGIN_PATH . '/includes/templates/invoice/invoice-details.php'; ?>
				</div>

				<div class="csip-span-4 csip-invoice-billto">
					<?php require PLUGIN_PATH . '/includes/templates/invoice/client-details.php'; ?>
				</div>

			</div>

			<div class="csip-invoice-items">
				<?php require PLUGIN_PATH . '/includes/templates/invoice/table.php'; ?>
			</div>

			<div class="csip-invoice-payment-info">
				<h5 class="csip-invoice-payment-title">
					<?php echo __( 'Ways to pay', PLUGIN_TEXT_DOMAIN ); ?>
				</h5>

				<?php require PLUGIN_PATH . '/includes/templates/invoice/payment-account-details.php'; ?>

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
