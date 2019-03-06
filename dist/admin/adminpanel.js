$( document ).ready(function() {
	$('.pages').not('#start').addClass("verbergItem");
	$("#mainpage").append($("#start"));		
	var delVlakActief = localStorage.getItem('deleteVlakActief');
	if(delVlakActief === 'true')	{
		$("#mainpage").append($("#deletevlak"));	
		$("#deletevlak").removeClass("verbergItem");
	}
	});

    $("a").click(function (e) {
	var name = $(this).attr('name');
	$('.pages').not('#' + name).addClass("verbergItem");
	$('#' + name).removeClass("verbergItem");
	$("#mainpage").append($("#" + name));
	if(name == 'deletevlak') {
		localStorage.setItem('deleteVlakActief', true);
	} else {
		localStorage.setItem('deleteVlakActief', false);
	}
});

var easyMDE = new EasyMDE({element: document.getElementById('text')});
