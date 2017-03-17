jQuery(document).ready(function($) {
	$('.popup').each(function(index, el) {
		var item = $(this);
		item.css('background-color', hexToRgbA(item.data('color'), '0.8'));
		
		setTimeout(function() {
			item.addClass('active');
			if(item.data('close').length || item.data('close') > 1000){
				setTimeout(function() {
					item.removeClass('active').addClass('closed');
				}, item.data('close'));
			}
		}, item.data('open'));
	});

	// $('.close-btn').click(function(event) {
	// 	$($(this).data('close')).removeClass('active').addClass('closed');
	// });
});

function closePopup(el){
	$(el).removeClass('active').addClass('closed');
}

function hexToRgbA(hex, alpha){
	var c;
	if(/^#([A-Fa-f0-9]{3}){1,2}$/.test(hex)){
		c= hex.substring(1).split('');
		if(c.length== 3){
			c= [c[0], c[0], c[1], c[1], c[2], c[2]];
		}
		c= '0x'+c.join('');
		return 'rgba('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+','+alpha+')';
	}
	throw new Error('Bad Hex');
}