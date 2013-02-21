jQuery.fn.accordion = function() {
    var element = $(this[0]);
    $(element).find(".header").click(function(){
		$(this).parents("li").toggleClass("active");
		$(this).siblings(".content").animate({
			height: 'toggle'
		}, 500);
	});
    
    $(element).on("hover", "li:not(.active)", function(){
    	$(this).find(".actions").toggle();
    });
};