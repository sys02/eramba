jQuery(document).ready(function($) {
	var filter_alphanumeric = /[^a-zA-Z0-9. ]/gi;
	var filter_url = new RegExp(/^(ht|f)tps?:\/\/[a-z0-9-\.]+\.[a-z]{2,4}\/?([^\s<>\#%"\,\{\}\\|\\\^\[\]`]+)?$/);
	var filter_date = new RegExp(/^[0-9]{4}\-(0[1-9]|1[012])\-(0[1-9]|[12][0-9]|3[01])/)

	$(".filter-text").on("blur", function(e) {
		var val_filtered = $(this).val().replace(filter_alphanumeric, "");
		$(this).val(val_filtered);	
	});

	$(".filter-url").on("blur", function(e) {
		/*var val_filtered = $(this).val().replace(filter_url, "");
		$(this).val(val_filtered);*/
		var value = $(this).val();
		if ( ! filter_url.test(value) ) {
			$(this).val("");
		}
	});

	$(".filter-number").on("blur", function(e) {
		/*var val_filtered = $(this).val().replace(filter_number, "");
		$(this).val(val_filtered);*/
		var value = $(this).val();
		if ( ! $.isNumeric(value) ) {
			$(this).val("");
		}
	});

	$(".filter-date").on("blur", function(e) {
		/*var val_filtered = $(this).val().replace(filter_date, "");
		$(this).val(val_filtered);*/
		var value = $(this).val();
		if ( ! filter_date.test(value) ) {
			$(this).val("");
		}
	});
});