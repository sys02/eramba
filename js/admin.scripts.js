$(document).ready(function(){
	$('.main-table tbody tr, #accordion tbody tr').hover(
		function () {
			$(this).addClass('active');
			$(this).find('.action-cell .cell-actions').stop().css({'visibility': 'visible'});
		}, 
		function () {
			$(this).removeClass('active');
			$(this).find('.action-cell .cell-actions').stop().css({'visibility': 'hidden'});
		}
	);
	$('.main-table tbody tr, #accordion tbody tr').bind('click', function() {
		$(this).addClass('active');
		$(this).find('.action-cell .cell-actions').stop().css({'visibility': 'visible'});
	});
	
	$('#add-item-nav').hover(
		function(){
			$('#add-item').addClass('hover');
			$('#add-submenu').stop().css({'display': 'block'});
		},
		function(){
			$('#add-submenu').stop().css({'display': 'none'});
			$('#add-item').removeClass('hover');
			
		}
	);
	
	$('.checkAll').live('change', function() {
		$('.check-elem').attr('checked', $(this).is(':checked') ? 'checked' : false);
	});
	
	$('.actions-wraper').live('mouseenter', function() {
		$(this).find('.action-submenu').slideDown('fast');
	});
	$('.actions-wraper').live('mouseleave', function() {
		$(this).find('.action-submenu').fadeOut('fast');
	}); 
	
	//flash message - interval na schovanie
	setTimeout(function() {
		$('#flash-message').slideUp();
	}, 3000);
});

function selectContentInput(elem) {
	$(elem).select();
}