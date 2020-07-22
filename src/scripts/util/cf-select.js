/* eslint-disable */

export default function () {

	$(document).ready(function () {

		// if (window.jQuery) {
		// 	console.log('jQuery is loaded');
		// }
		// else {
		// 	console.log('jQuery is not loaded');
		// }

		console.log($('.csip-select2 select')[0]);
		// $.fn.select2.defaults.set("theme", "classic");
		$('.csip-select2 select')[0].select2();

	})

}