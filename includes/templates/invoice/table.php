<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

$subtotal = $discount = $tax_duty = $total = 0;
$items    = carbon_get_the_post_meta( 'inv_items' );

// Handle currency formatting
$fmt = new NumberFormatter( get_locale(), NumberFormatter::CURRENCY );
$fmt->setTextAttribute( NumberFormatter::CURRENCY_CODE, $client_currency );
$fmt->setAttribute( NumberFormatter::FRACTION_DIGITS, 2 );
?>

<table class="csip-invoice-table">
	<thead>
		<tr>
			<th class="csip-text-left"><?php _e( 'Item', PLUGIN_TEXT_DOMAIN ); ?></th>
			<th class="csip-text-center"><?php _e( 'Quantity', PLUGIN_TEXT_DOMAIN ); ?></th>
			<th class="csip-text-center"><?php _e( 'Unit', PLUGIN_TEXT_DOMAIN ); ?></th>
			<th class="csip-text-center"><?php _e( 'Rate', PLUGIN_TEXT_DOMAIN ); ?></th>
			<th class="csip-text-center"><?php _e( 'Discount (%)', PLUGIN_TEXT_DOMAIN ); ?></th>
			<th class="csip-text-center"><?php _e( 'Amount', PLUGIN_TEXT_DOMAIN ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ( $items as $item ) : ?>

			<tr>
				<td class="csip-invoice-table-entry csip-text-left">
					<dl class="csip-invoice-table-item-desc">
						<dt><?php echo wp_kses( $item['inv_item_title'], 'strip' ); ?></dt>
						<dd><?php echo wpautop( wp_kses( $item['inv_item_description'], 'strip' ) ); ?></dd>
					</dl>
				</td>
				<td class="csip-invoice-table-entry csip-text-center"><?php echo $item['inv_item_quantity']; ?></td>
				<td class="csip-invoice-table-entry csip-text-center"><?php echo wp_kses( $item['inv_item_um'], 'strip' ); ?></td>
				<td class="csip-invoice-table-entry csip-text-center"><?php echo $item['inv_item_rate']; ?></td>
				<td class="csip-invoice-table-entry csip-text-center"><?php echo $item['inv_item_discount']; ?></td>
				<td class="csip-invoice-table-entry csip-text-center"><?php echo $item['inv_item_amount']; ?></td>
			</tr>

			<?php
			$subtotal += $item['inv_item_quantity'] * $item['inv_item_rate'];
			$discount += ( $item['inv_item_quantity'] * $item['inv_item_rate'] ) - $item['inv_item_amount'];
			$total    += $item['inv_item_amount'];

		endforeach;

		if ( $client_tax_rate > 0 ) {
			$tax_duty = $total / ( 100 / $client_tax_rate );
		}

		?>
	</tbody>
	<tfoot>
		<tr class="csip-invoice-table-row-subtotal">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php _e( 'Subtotal', PLUGIN_TEXT_DOMAIN ); ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $subtotal, $client_currency ); ?>
			</td>
		</tr>
		<tr class="csip-invoice-table-row-discount">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php _e( 'Discount', PLUGIN_TEXT_DOMAIN ); ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $discount, $client_currency ); ?>
			</td>
		</tr>
		<tr class="csip-invoice-table-row-tax">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php echo __( 'Tax', PLUGIN_TEXT_DOMAIN ) . ' (' . $client_tax_rate . '%)'; ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $tax_duty, $client_currency ); ?>
			</td>
		</tr>
		<tr class="csip-invoice-table-row-total">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-left">
				<?php _e( 'TOTAL', PLUGIN_TEXT_DOMAIN ); ?>
			</td>
			<td colspan=2 class="csip-invoice-table-entry csip-text-right">
				<?php echo $fmt->formatCurrency( $total, $client_currency ); ?>
			</td>
		</tr>
	</tfoot>
</table>
