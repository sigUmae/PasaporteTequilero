$('document').ready(function(){
	
	// - VARIABLES

	var btn_a = $('#aceptar');
	var in_a = $('#a-aliado');
	var frm = $('#frm-usuario');

	// - FUNCIONES

	function ajax(tipo,url,sync,datos){
		return $.ajax({
			type: tipo,
			url: url,
			async: sync,
			data: datos
		});
	}

	function  callbackFunction() {
		if (in_a.val() == '') {
			btn_a.addClass('btn-aceptar').text('Aceptar');
			btn_a.removeClass('btn-aceptar-a');
			$('#usuario, #contrasena, #correo, #h-a, #elegir').attr('required',true);
		} 
		else{
			btn_a.addClass('btn-aceptar-a').text('Aceptar aliado');
			btn_a.removeClass('btn-aceptar');
			$('#usuario, #contrasena, #correo, #h-a, #elegir').removeAttr('required');
		}
	}

	function  alta() {
		if (btn_a.hasClass('btn-aceptar')) {
			var obj = {
				'usuario': $('#usuario').val(),
				'contrasena': $('#contrasena').val(),
				'correo': $('#correo').val(),
				'elegir': $('#elegir').val(),
				'h-a': $('#elegir').data('type')
			};
			var results = ajax('post',base_url+'configuracion/alta',false,obj);
			results.success(function(data){
				alert(data);
			});
		} 
		else{
			var obj = {
				'aliado': $('#a-aliado').val()
			};
			var results = ajax('post',base_url+'configuracion/alta_aliado',true,obj);
			results.success(function(data){
				// alert(data);
			});
		}
	}

	function  select(type) {
		if (type != '') {
			var obj = { 'vendedor': $('#h-a').val() };
			var results = ajax('post',base_url+'configuracion/vendedor',false,obj);
			results.success(function(data){
				$('#elegir').data('type',type).html(data);
			});
		} 
	}

	// - EVENTOS

	$('#h-a').on('change',function(){
		select($(this).val());
	});

	$('#frm-usuario').on('submit',function(event){
		alta();
		// return false;
	});

	$('#a-aliado').on('input',null,null,callbackFunction); 

});