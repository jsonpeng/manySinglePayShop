$(function(){
	$('.class-grid-img').on('mouseover', function(event) {
		event.preventDefault();
		/* Act on the event */
		$(this).children('.caption').css('display', 'block');
	});
})