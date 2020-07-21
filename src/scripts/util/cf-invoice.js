export default function () {

	$(document).on('carbonFields.apiLoaded', function (e, api) {


		// Initialise Invoice Date field if it's empty
		if (api.getFieldValue('inv_date') === '') {
			api.setFieldValue('inv_date', new Date().toISOString().slice(0, 10));
		}


		// Fields update event
		$(document).on('carbonFields.fieldUpdated', function (e, fieldName) {
			calcAmount(e, fieldName);
			updateDueDate(fieldName);
			updateNetPeriod(e, fieldName);
		});


		// Calculate amount field for an item
		function calcAmount (e, fieldName) {
			let activeElement = e.target.activeElement;

			if (activeElement.type === 'number' && fieldName.includes("inv_item_")) {

				let
					parentElement = activeElement.closest('.fields-container'),
					amountElement = $(parentElement).find('.inv-item-amount input'),
					quantity = $(parentElement).find('.inv-item-quantity input').val(),
					price = $(parentElement).find('.inv-item-rate input').val(),
					discount = $(parentElement).find('.inv-item-discount input').val(),
					amount;

				amount = (quantity * price) - ((quantity * price) * (discount / 100));
				amount = Math.round((amount + Number.EPSILON) * 100) / 100;

				amountElement.val(amount);
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

				let activeElement = e.target.activeElement,
					parentElement = activeElement.closest('.carbon-container'),
					inpElement = $(parentElement).find('[name=_inv_net_period]');

				let diff = new Date(api.getFieldValue('inv_due_date')) - new Date(api.getFieldValue('inv_date'));

				let days = Math.floor(diff / (24 * 60 * 60 * 1000));

				inpElement.val(days);

			}
		}

	});
}

