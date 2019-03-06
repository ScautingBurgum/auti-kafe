$( document ).ready(function() {
	$('.pages').not('#start').addClass("verbergItem");
	$("#mainpage").append($("#start"));		
	var delVlakActief = localStorage.getItem('deleteVlakActief');
	var LPostVlakActief = localStorage.getItem('postVlakActief');
	if(delVlakActief === 'true')	{
		$("#mainpage").append($("#deletevlak"));	
		$("#deletevlak").removeClass("verbergItem");
	} else if(LPostVlakActief === 'true')	{
		$("#mainpage").append($("#postvlak"));	
		$("#postvlak").removeClass("verbergItem");
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
	if(name == 'postvlak') {
		localStorage.setItem('postVlakActief', true);
	} else {
		localStorage.setItem('postVlakActief', false);
	}
});

var easyMDE = new EasyMDE({element: document.getElementById('text'), placeholder: "Voer hier uw text in (Bij bewerken klik hier om het te laten zien)"});
