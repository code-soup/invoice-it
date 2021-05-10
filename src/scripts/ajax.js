document.addEventListener("DOMContentLoaded", () => {

	const clientSelect = $('[name=_inv_client]');

	/* eslint-disable */
	function fetch_net( $client_id ) {

		let $params = {
			'client_id': $client_id,
		}

		const netDate = $('[name=_inv_net_period]');
		const netDate_el = netDate[0];

		$.ajax({
			url: csip.ajax_url,
			type: 'POST',
			data: {
				action: 'do_fetch_client_net',
				nonce: csip.nonce,
				params: $params,
			},
			dataType: 'json',
			success: function (data, textStatus, XMLHttpRequest) { // eslint-disable-line

				if (data.status === 200) {
					netDate_el.value = data.net;

					let e = new Event("change");
					netDate_el.dispatchEvent(e);
				}
				else {
					console.log( data.message );
				}
			},
			error: function (MLHttpRequest, textStatus, errorThrown) { // eslint-disable-line

				// console.log(MLHttpRequest);
				// console.log(textStatus);
				// console.log(errorThrown);
			},
			complete: function (data, textStatus) {

				let msg = textStatus;

				if (textStatus === 'success') {
					msg = data.responseJSON.message;
				}

				// console.log(msg);
				// console.log(data);
				// console.log(textStatus);
			},
		})
	}

	clientSelect.on( 'change', function(e) {

		if (e.preventDefault) { e.preventDefault(); }

		fetch_net( clientSelect[0].value );

	});

});

