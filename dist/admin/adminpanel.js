$( document ).ready(function() {
	$('.pages').not('#start').addClass("verbergItem");
	$("#mainpage").append($("#start"));		
	var delVlakActief = localStorage.getItem('deleteVlakActief');
	var imageVlakActief = localStorage.getItem('imageVlakActief');
	var imgselVlakActief = localStorage.getItem('imgselVlakActief');
	var LPostVlakActief = localStorage.getItem('postVlakActief');
	if(delVlakActief === 'true')	{
		$("#mainpage").append($("#deletevlak"));	
		$("#deletevlak").removeClass("verbergItem");
	} else if(LPostVlakActief === 'true')	{
		$("#mainpage").append($("#postvlak"));	
		$("#postvlak").removeClass("verbergItem");
	} else if(imageVlakActief === 'true') {
		$("#mainpage").append($("#imagevlak"));	
		$("#imagevlak").removeClass("verbergItem");
	} else if(imgselVlakActief === 'true') {
		$("#mainpage").append($("#imageselectvlak"));	
		$("#imageselectvlak").removeClass("verbergItem");
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
	if(name == 'imagevlak') {
		localStorage.setItem('imageVlakActief', true);
	} else {
		localStorage.setItem('imageVlakActief', false);
	}
	if(name == 'imageselectvlak') {
		localStorage.setItem('imgselVlakActief', true);
	} else {
		localStorage.setItem('imgselVlakActief', false);
	}
	if(name == 'postvlak') {
		localStorage.setItem('postVlakActief', true);
	} else {
		localStorage.setItem('postVlakActief', false);
	}

});
var easyMDE = new EasyMDE({element: document.getElementById('text'), placeholder: "Voer hier uw text in (Bij bewerken klik hier om het te laten zien)"});
for (var key in localStorage) {
	  console.log(key + ':' + localStorage[key]);
	}
