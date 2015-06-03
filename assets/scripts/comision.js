$('document').ready(function(){
	
	// variables

	// funciones

	function ajax(tipo,url,sync,datos){
		return $.ajax({
			type: tipo,
			url: url,
			async: sync,
			data: datos
		});
	}

	function comision(element) {
		var id_pasaporte = element.data('id-pasaporte');
		var obj = { 'id_pasaporte': id_pasaporte };
		var result = ajax('post',base_url+'config_pasaportes/pagar_comision',true,obj);
		result.success(function(data){
			alert(data);
			location.reload(false);
		});
	}

	// eventos

	$('.btn-pagar').on('click',function(){
		comision($(this));
	});

});