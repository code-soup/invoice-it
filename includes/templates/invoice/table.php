<?php if ( ! defined( 'ABSPATH' ) ) {
	exit; }

$subtotal = $discount = $tax = $total = 0;
$items    = carbon_get_the_post_meta( 'inv_items' );
?>

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
		<?php foreach ( $items as $item ) : ?>

			<tr>
				<td class="csip-invoice-table-entry">
					<dl class="csip-invoice-table-item-desc">
						<dt><?php echo wp_kses( $item['inv_item_title'], 'strip' ); ?></dt>
						<dd><?php echo wpautop( wp_kses( $item['inv_item_description'], 'strip' ) ); ?></dd>
					</dl>
				</td>
				<td class="csip-invoice-table-entry"><?php echo $item['inv_item_quantity']; ?></td>
				<td class="csip-invoice-table-entry"><?php echo wp_kses( $item['inv_item_um'], 'strip' ); ?></td>
				<td class="csip-invoice-table-entry"><?php echo $item['inv_item_rate']; ?></td>
				<td class="csip-invoice-table-entry"><?php echo $item['inv_item_discount']; ?></td>
				<td class="csip-invoice-table-entry"><?php echo $item['inv_item_amount']; ?></td>
			</tr>

			<?php
			$subtotal += $item['inv_item_quantity'] * $item['inv_item_rate'];
			$discount += ( $item['inv_item_quantity'] * $item['inv_item_rate'] ) - $item['inv_item_amount'];
			$total    += $item['inv_item_amount'];

		endforeach;

		$tax = $total / ( 100 / $client_tax_rate );
		?>
	</tbody>
	<tfoot>
		<tr class="csip-invoice-table-row-subtotal">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'Subtotal', PLUGIN_TEXT_DOMAIN ); ?></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo number_format( $subtotal, 2 ) . ' ' . $client_currency; ?></td>
		</tr>
		<tr class="csip-invoice-table-row-discount">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'Discount', PLUGIN_TEXT_DOMAIN ); ?></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo number_format( $discount, 2 ) . ' ' . $client_currency; ?></td>
		</tr>
		<tr class="csip-invoice-table-row-tax">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'Tax', PLUGIN_TEXT_DOMAIN ) . ' (' . $client_tax_rate . '%)'; ?></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo number_format( $tax, 2 ) . ' ' . $client_currency; ?></td>
		</tr>
		<tr class="csip-invoice-table-row-total">
			<td colspan=2 class="csip-invoice-table-empty-cell"></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo __( 'TOTAL', PLUGIN_TEXT_DOMAIN ); ?></td>
			<td colspan=2 class="csip-invoice-table-entry"><?php echo number_format( $total, 2 ) . ' ' . $client_currency; ?></td>
		</tr>
	</tfoot>
</table>
