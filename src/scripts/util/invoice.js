export default function () {

	$(document).on('carbonFields.apiLoaded', function (e, api) {

		const dueFlatpickr = $('[name=_inv_due_date]');
		const dateFlatpickr = $('[name=_inv_date]');
		if (dueFlatpickr.length > 0 && dateFlatpickr.length > 0) {
			/* eslint-disable */
			var dueFlap = flatpickr(dueFlatpickr[0], {});
			var dateFlap = flatpickr(dateFlatpickr[0], {});
			/* eslint-enable */
		}


		// Initialise Invoice Date field if it's empty
		if (api.getFieldValue('inv_date') === '') {
			api.setFieldValue('inv_date', new Date().toISOString().slice(0, 10));
		}

		// set min due date on init based on invoice date
		updateMinDueDate('inv_date');

		// Fields update event
		$(document).on('carbonFields.fieldUpdated', function (ev, fieldName) {
			calcAmount(ev, fieldName);
			updateNetPeriod(ev, fieldName);
			updateMinDueDate(fieldName);
			updateDueDate(fieldName);
		});


		// Calculate amount field for an item
		function calcAmount(ev, fieldName) {
			let activeEl = ev.target.activeElement;

			if (activeEl.type === 'number' && fieldName.includes("inv_item_")) {

				let
					parentEl = activeEl.closest('.fields-container'),
					amountEl = $(parentEl).find('.inv-item-amount input'),
					quantity = $(parentEl).find('.inv-item-quantity input').val(),
					price = $(parentEl).find('.inv-item-rate input').val(),
					discount = $(parentEl).find('.inv-item-discount input').val(),
					amount;

				amount = (quantity * price) - ((quantity * price) * (discount / 100));
				amount = Math.round((amount + Number.EPSILON) * 100) / 100;

				amountEl.val(amount);
			}

			return;
		}


		// update net period based on due date
		function updateNetPeriod(ev, fieldName) {
			if (fieldName === 'inv_due_date' || fieldName === 'inv_date') {

				let inpEl = $('[name=_inv_net_period]')
				inpEl.val(getDateDiff());
			}
		}


		// Update due date based on net period
		function updateDueDate(fieldName) {
			if (fieldName === 'inv_net_period' || fieldName === 'inv_date') {

				if (api.getFieldValue('inv_net_period') === '') {
					api.setFieldValue('inv_due_date', api.getFieldValue('inv_date'))
					return;
				}

				let netPeriod = api.getFieldValue('inv_net_period'),
					invDate = new Date(api.getFieldValue('inv_date'));

				invDate.setDate(invDate.getDate() + parseInt(netPeriod));
				api.setFieldValue('inv_due_date', invDate.toISOString().slice(0, 10));
			}
		}


		// update min date on Due date picker
		function updateMinDueDate(fieldName) {
			if (fieldName === 'inv_date') {

				api.setFieldValue('inv_net_period', String(getDateDiff()));
				dueFlap.set('minDate', api.getFieldValue('inv_date'));
			}
		}


		function getDateDiff() {
			let diff = new Date(api.getFieldValue('inv_due_date')) - new Date(api.getFieldValue('inv_date')),
				days = Math.floor(diff / (24 * 60 * 60 * 1000));

			return days;
		}

	});
}

