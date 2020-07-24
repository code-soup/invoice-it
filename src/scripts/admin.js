import Invoice from './util/invoice';
import Select2 from './util/select2';

/**
 * Run scripts on document ready
 * No jQuery here sorry
 */
document.addEventListener("DOMContentLoaded", () => {

});

// Initalize Select2
Select2();

 /**
  * Calculate Carbon Fields for Invoice post type
  * Handle date, net and due date
  */
Invoice();
