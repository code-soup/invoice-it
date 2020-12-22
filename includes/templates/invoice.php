<?php

// do_action('wp_head');
get_header();


/**
 * Get compeny details
 */
global $wpdb;
$wp_options_company = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}options `wp_6_options` WHERE (CONVERT(`option_name` USING utf8) LIKE '%csip_%')", ARRAY_A );
$company_details    = array();

foreach ( $wp_options_company as $value ) {
	$company_details[ $value['option_name'] ] = $value['option_value'];
}


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
$footertext     = wp_kses( $company_details['_csip_company_footertext'], 'strip' );


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

$allowed_html          = array(
	'b' => array(),
	'i' => array(),
);
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

$cl_name      = wp_kses( $client_details['_cli_name'], 'strip' );
$cl_address_1 = wp_kses( $client_details['_cli_address_1'], 'strip' );
$cl_address_2 = wp_kses( $client_details['_cli_address_2'], 'strip' );
$cl_city      = wp_kses( $client_details['_cli_city'], 'strip' );
$cl_country   = $client_details['_cli_country'];
$cl_state     = $client_details['_cli_state'];
$cl_zip       = wp_kses( $client_details['_cli_zip'], 'strip' );
$cl_tax_rate  = $client_details['_cli_tax_rate'];
$currency     = $client_details['_cli_currency'];

?>


<div class="csip-container">
	<section class="csip-invoice-plugin csip-invoice">

		<header class="csip-invoice-header">
			<div class="csip-row">

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
						<li class="csip-invoice-list-entry">
							<span class="csip-client-name"><?php echo $cl_name; ?></span>
						</li>
						<li class="csip-invoice-list-entry"><?php echo $cl_address_1; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $cl_address_2; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $cl_city . ', ' . $cl_zip; ?></li>
						<li class="csip-invoice-list-entry"><?php echo $cl_country . ', ' . $cl_state; ?></li>
					</ul>
				</div>

			</div>

			<div class="csip-invoice-items">
				<table class="csip-invoice-table">
					<thead>
						<tr>
							<th>Item</th>
							<th>Quantity</th>
							<th>Unit</th>
							<th>Rate</th>
							<th>Discount (%)</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$subtotal = $discount = $tax = $total = 0;
						$items    = carbon_get_the_post_meta( 'inv_items' );
						foreach ( $items as $item ) {
							echo sprintf(
								'<tr>
									<td class="csip-invoice-table-entry">
										<dl class="csip-invoice-table-item-desc">
											<dt>%s</dt>
											<dd>%s</dd>
										</dl>
									</td>
									<td class="csip-invoice-table-entry">%s</td>
									<td class="csip-invoice-table-entry">%s</td>
									<td class="csip-invoice-table-entry">%s</td>
									<td class="csip-invoice-table-entry">%s</td>
									<td class="csip-invoice-table-entry">%s</td>
								</tr>',
								wp_kses( $item['inv_item_title'], 'strip' ),
								wpautop( wp_kses( $item['inv_item_description'], 'strip' ) ),
								$item['inv_item_quantity'],
								wp_kses( $item['inv_item_um'], 'strip' ),
								$item['inv_item_rate'],
								$item['inv_item_discount'],
								$item['inv_item_amount'],
							);

							$subtotal += $item['inv_item_quantity'] * $item['inv_item_rate'];
							$discount += ( $item['inv_item_quantity'] * $item['inv_item_rate'] ) - $item['inv_item_amount'];
							$total    += $item['inv_item_amount'];
						}

						$tax = $total - ( $total / $cl_tax_rate );

						?>
					</tbody>
					<tfoot>
						<tr class="csip-invoice-table-row-subtotal">
							<td colspan=2 class="csip-invoice-table-empty-cell"></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'Subtotal', PLUGIN_TEXT_DOMAIN ); ?></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo $subtotal . ' ' . $currency; ?></td>
						</tr>
						<tr class="csip-invoice-table-row-discount">
							<td colspan=2 class="csip-invoice-table-empty-cell"></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'Discount', PLUGIN_TEXT_DOMAIN ); ?></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo $discount . ' ' . $currency; ?></td>
						</tr>
						<tr class="csip-invoice-table-row-tax">
							<td colspan=2 class="csip-invoice-table-empty-cell"></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'Tax', PLUGIN_TEXT_DOMAIN ) . ' (' . $cl_tax_rate . '%)'; ?></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo $tax . ' ' . $currency; ?></td>
						</tr>
						<tr class="csip-invoice-table-row-total">
							<td colspan=2 class="csip-invoice-table-empty-cell"></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'TOTAL', PLUGIN_TEXT_DOMAIN ); ?></td>
							<td colspan=2 class="csip-invoice-table-entry"><?php echo $total . ' ' . $currency; ?></td>
						</tr>
					</tfoot>
				</table>
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

				<div class="csip-invoice-note">
					<?php
					if ( $invoice_comment ) {
						echo sprintf( '<h5 class="csip-invoice-payment-note-title">%s</h5>', __( 'Note', PLUGIN_TEXT_DOMAIN ) );
						echo wpautop( $invoice_comment );
					}
					?>
				</div>
			</div>

		</article>


		<div class="csip-invoice-footer">
			<p><?php echo $footertext; ?></p>
		</div>

	</section>
</div>

<?php
get_footer();
