export default function () {

$(document).on('carbonFields.apiLoaded', function (e, api) {


	// Validate Invoice entries and calculate "Total" field
	$(document).on('carbonFields.validateField', function (e, fieldName, error) {

		let active_el = e.target.activeElement;

		if (null !== active_el.getAttribute('data-item-factor')) {

			let value = api.getFieldValue(fieldName);
			if ( isNaN(value) || value < 0 ) {
				return 'Please enter a valid number';
			}

			return error;
		}

		return;
	});

	// Calculate "Total" field
	$(document).on('carbonFields.fieldUpdated', function(e, fieldName) {
		let active_el = e.target.activeElement;

		if (null !== active_el.getAttribute('data-item-factor')) {

			let value = api.getFieldValue(fieldName);

			if ( isNaN(value) || value < 0 ) {
				return;
			}

			let
				parent_el	= active_el.closest('.fields-container'),
				total_el	= $(parent_el).find('[data-item-total]'),
				amount		= $(parent_el).find('[data-item-amount]').val(),
				price		= $(parent_el).find('[data-item-price]').val(),
				discount 	= $(parent_el).find('[data-item-discount]').val(),
				total;

			total = (amount * price) - ((amount * price) * (discount / 100));
			total = Math.round((total + Number.EPSILON) * 100) / 100;

			total_el.val(total);
		}

		return;
    });

});
}
// function parseVal(val) {

// 	val = val.replace(/,/g, ".");

// 	if ( !isNaN(val) ) {
// 		val = Math.abs(val);
// 		val = Math.round((val + Number.EPSILON) * 100) / 100;
// 	}

// 	console.log(parseInt(val));
// 	return parseInt(val);
// }
