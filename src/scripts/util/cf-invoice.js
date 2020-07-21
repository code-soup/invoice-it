export default function () {

	$(document).on('carbonFields.apiLoaded', function (e, api) {


		// Initialise Invoice Date field if it's empty
		if (api.getFieldValue('inv_date') === '') {
			api.setFieldValue('inv_date', new Date().toISOString().slice(0, 10));
		}


		// Validate field event
		// $(document).on('carbonFields.validateField', function (e, fieldName, error) {
			// return validateNumber(e, fieldName, error);
		// });


		// Fields update event
		$(document).on('carbonFields.fieldUpdated', function (e, fieldName) {
			calcAmount(e);
			updateDueDate(fieldName);
			updateNetPeriod(e, fieldName);
		});


		// Validate number fields
		// function validateNumber (e, fieldName, error) {
			// let active_el = e.target.activeElement;

			// if (null !== active_el.getAttribute('data-number')) {

			// 	let value = api.getFieldValue(fieldName);
			// 	if (isNaN(value) || parseInt(value) < 0) {
			// 		return 'Please enter a valid number';
			// 	}

			// 	return error;
			// }

			// return;
		// }


		// Calculate amount field for an item
		function calcAmount (e) {
			let active_el = e.target.activeElement;
			// console.log(active_el);

			if (active_el.type === 'number') {

				let
					parent_el = active_el.closest('.fields-container'),
					amount_el = $(parent_el).find('.inv-item-amount input'),
					quantity = $(parent_el).find('.inv-item-quantity input').val(),
					price = $(parent_el).find('.inv-item-rate input').val(),
					discount = $(parent_el).find('.inv-item-discount input').val(),
					amount;

				amount = (quantity * price) - ((quantity * price) * (discount / 100));
				amount = Math.round((amount + Number.EPSILON) * 100) / 100;

				amount_el.val(amount);
			}

			return;
		}


		// Update due date based on net period
		function updateDueDate(fieldName) {
			if (fieldName === 'inv_net_period' || fieldName === 'inv_date') {

				let netPeriod = api.getFieldValue('inv_net_period');
				if (netPeriod === '' || netPeriod < 0 || isNaN(netPeriod)) {
					return;
				}

				let invDate = new Date(api.getFieldValue('inv_date'));
				invDate.setDate(invDate.getDate() + parseInt(netPeriod));
				api.setFieldValue('inv_due_date', invDate.toISOString().slice(0, 10));
			}
		}


		// update net period based on due date
		function updateNetPeriod (e, fieldName) {
			if (fieldName === 'inv_due_date') {

				let active_el = e.target.activeElement,
					parent_el = active_el.closest('.carbon-container'),
					gp_el = $(parent_el).find('[name=_inv_net_period]');

				let diff = new Date(api.getFieldValue('inv_due_date')) - new Date(api.getFieldValue('inv_date'));

				let days = Math.floor(diff / (24 * 60 * 60 * 1000));

				gp_el.val(days);

			}
		}

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

