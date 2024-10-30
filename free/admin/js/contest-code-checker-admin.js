(function( $ ) {
	'use strict';
})( jQuery );

jQuery(document).ready(function($) {
	$("#ccc_start_date").datepicker({
		dateFormat: "m/dd/yy"
	});
	$("#ccc_end_date").datepicker({
		dateFormat: "m/dd/yy"
	});
	$("#prizes-select").multiSelect();
});
