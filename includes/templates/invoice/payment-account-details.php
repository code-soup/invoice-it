<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// TODO: handle "if none selected" scenario (check for value or make the field required)
$i                    = 0;
$show_payment_account = array();
$accounts             = carbon_get_theme_option( 'csip_company_bank_accounts' );
foreach ( $accounts as $account_details ) {
	if ( $i === $invoice_payment_account ) {
		$show_payment_account = $account_details;
		break;
	}

	$i++;
}

$account_name          = $show_payment_account['csip_conpany_account_name'];
$account_details       = wp_kses( $show_payment_account['csip_company_account_details'], $allowed_html );
$account_details_other = wp_kses( $show_payment_account['csip_company_account_details_other'], $allowed_html );
?>

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
