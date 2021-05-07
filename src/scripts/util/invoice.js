import invoiceItems from './invoice-items';
import invoiceDates from './invoice-dates';

document.addEventListener("DOMContentLoaded", () => {

	/**
	 * Remove carbon date excess "Select Date" buttons
	 */
	$('.carbon-date').find('button').remove();

	/**
	 * Handle invoice date, net period and due date
	 */
	invoiceDates();

});

/**
 * Handle invoice items calculations
 */
invoiceItems();
