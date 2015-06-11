$('document').ready(function(){

	function ajax(tipo,url,sync,datos){
		return $.ajax({
			type: tipo,
			url: url,
			async: sync,
			data: datos
		});
	}

	function getUrlParameter(sParam)
	{
	    var sPageURL = window.location.search.substring(1);
	    var sURLVariables = sPageURL.split('&');
	    for (var i = 0; i < sURLVariables.length; i++) 
	    {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam) 
	        {
	            return sParameterName[1];
	        }
	    }
	}          

	function alta_visita(id_pasaporte) {
		var obj = { 'id_pasaporte': id_pasaporte };
		var results = ajax('post',base_url+'config_pasaportes/visitado',false,obj);
		results.success(function(data){
			alert(data);
			location.reload();
		});
	}

	$('.visita').on('click',function(){
		var answer = confirm('¿Desea agregar visita?');
		if (answer) {
			alta_visita($(this).data('id-pasaporte'));
		}
	});
	
	$('#enviar_pt').on('click',function(){

		var obj = {
			'id_pasaporte': $(this).data('id-pasaporte')
		}
		var result = ajax('post',base_url+'config_pasaportes/enviar_pasaporte',true,obj);
		result.success(function(data){
			alert(data);
		});

	});

	function tool_v() {
		$('.tooltip').each(function(){
			var get_v = (getUrlParameter('pasaporte') == undefined) ? $(this).data('id-pasaporte') : getUrlParameter('pasaporte');
			var img = $(this);
			var id_hacienda = $(this).data('id-hacienda');
			var obj = { 
				'id_hacienda' : id_hacienda, 
				'id_pasaporte' : get_v
			};
			console.log(obj);
			var result =  ajax('post',base_url+'ver_mas/total_visitas',false,obj);
			result.success(function(data){
				if (data != 0) {
					img.attr('title',data);
				} 
				else {
					alert('Ocurró un error al cargar las fechas');
				}
			});
		});
	}

	tool_v();

	$('.tooltip').css('opacity','1');

	$('.tooltip').tooltipster({
    	theme: 'tooltipster-shadow',
    	position: 'bottom',
    	maxWidth: '160'
	});

	$('#mod_correo').on('click',function(){
		$('#submit-btn').click();
	});

	$('#frm-cambiar-correo').on('submit',function(e){
		e.preventDefault();
		var obj = {
			'id_pasaporte': $('#mod_correo').data('id-pasaporte'),
			'correo': $('#correo').val()
		}
		var result = ajax('post',base_url+'ver_mas/cambiar_correo',true,obj);
		result.success(function(data){
			alert(data);
			if (data == 'Hecho') {
				location.reload();
			}
		});
	});

});