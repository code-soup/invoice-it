import cfInvoice from './util/cf-invoice';
import cfSelect from './util/cf-select';

/**
 * Run scripts on document ready
 * No jQuery here sorry
 */
document.addEventListener("DOMContentLoaded", () => {

});

// Initalize Select2
cfSelect();

 /**
  * Calculate Carbon Fields for Invoice post type
  * Handle date, net and due date
  */
cfInvoice();
