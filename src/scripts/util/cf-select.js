/* eslint-disable */
import select2 from 'select2';
/* eslint-enable */

export default function () {

	$(document).ready(function () {

		// $('.csip-select2 select').each(function (index, element) {
		// 	element == this;
		// 	console.log(index);
		// 	console.log(element);
		// 	element.prepend('<option></option>');
		// });

		$('.csip-select2 select').select2({
			// placeholder: 'Select an option', // inject empty <option> with js & remove the first entry from Helers.php
		});
	})

}