<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

$account_id        = carbon_get_post_meta( get_the_ID(), 'inv_payment_account' );
$account_details_1 = get_post_meta( $account_id, '_csip_company_account_details', true );
$account_details_2 = get_post_meta( $account_id, '_csip_company_account_details_other', true );

if ( $account_id ) : ?>
<h3 class="csip-invoice-title-underlined">
	<?php _e( 'Ways to pay', PLUGIN_TEXT_DOMAIN ); ?>
</h3>
<?php endif;

if ( $account_details_1 || $account_details_2 ) : ?>

	<div class="csip-invoice-account csip-mb-40">
		<h4 class="csip-invoice-account-name"><?php echo get_the_title( $account_id ); ?></h4>
		<div class="csip-row">
			<?php if ( $account_details_1 ) : ?>
				<div class="csip-span-4">
					<?php echo wpautop( wp_kses( $account_details_1, $allowed_html ) ); ?>
				</div>
			<?php endif; ?>
			<?php if ( $account_details_2 ) : ?>
				<div class="csip-span-4">
					<?php echo wpautop( wp_kses( $account_details_2, $allowed_html ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<?php
endif;
