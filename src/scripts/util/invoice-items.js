export default function () {

	// Calculate amount field for an item
	$(document).on('carbonFields.apiLoaded', function (e, api) { // eslint-disable-line
		$(document).on('carbonFields.fieldUpdated', function (ev, fieldName) {


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


		});
	});

}