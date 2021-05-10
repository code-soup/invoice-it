/* eslint-disable */
export default function () {
	const invDate = $('[name=_inv_date]');
	const invDate_el = invDate[0];
	const dueDate = $('[name=_inv_due_date]');
	const dueDate_el = dueDate[0];
	const netDate = $('[name=_inv_net_period]');
	const netDate_el = netDate[0];



	const invDueFlap = flatpickr(dueDate_el, {
		onClose: function (selectedDates, dateStr, instance) {
			netDate_el.value = getDateDiff();
		},
	});



	const invDateFlap = flatpickr(invDate_el, {
		onReady: function (e) {

			if (e.length === 0) {
				invDate_el.value = new Date().toISOString().slice(0, 10);
			}

			invDueFlap.set('minDate', invDate_el.value);

		},
		onClose: function (selectedDates, dateStr, instance) {
			invDueFlap.set('minDate', dateStr);

			if (invDate_el.value !== '') {
				netDate_el.value = getDateDiff();
			}

		},
	});



	netDate.on('change', function (e) {
		let val = e.currentTarget.value;
		let tmpDate = new Date(invDate_el.value);
		let tmpDue = tmpDate.addDays(parseInt(val)).toISOString().slice(0, 10);
		invDueFlap.setDate(tmpDue);
	});



	function getDateDiff() {
		let diff = new Date(dueDate_el.value) - new Date(invDate_el.value);
		let days = Math.floor(diff / (24 * 60 * 60 * 1000));

		return days;
	}


	Date.prototype.addDays = function (days) {
		let date = new Date(this.valueOf());
		date.setDate(date.getDate() + days);
		return date;
	}
}