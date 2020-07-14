/**
 * Calculate total price for item row in invoice post type
 */
export default function () {

	$('.cf-invoice-items').on('change', '[data-item-factor]', function () {

		let
			parent_el	= this.closest('.cf-complex__group-body'),
			amount_el	= $(parent_el).find('[data-item-amount]'),
			price_el	= $(parent_el).find('[data-item-price]'),
			discount_el = $(parent_el).find('[data-item-discount]'),
			total_el	= $(parent_el).find('[data-item-total]'),
			amount		= validate(amount_el),
			price		= validate(price_el),
			discount	= validate(discount_el);

		total_el.val(0);
		let total = (amount * price) - ((amount * price) * (discount / 100));
		total = Math.round((total + Number.EPSILON) * 100) / 100;
		total_el.val(total);
	})

}

function validate(el) {

	let result = 0;

	let val = el.val();
	val = val.replace(/,/g, ".");

	if (val !== '' && !isNaN(val)) {
		val = Math.abs(val);
		val = Math.round((val + Number.EPSILON) * 100) / 100;
		el.val(val);

		result = val;
	} else {
		el.val(0);
	}

	return result;
}