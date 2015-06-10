$('document').ready(function(){
	
	// - VARIABLES

	var btn_a = $('#aceptar');
	var in_a = $('#a-aliado');
	var frm = $('#frm-usuario');
	var change_usuario = 0;
	var change_correo = 0;
	var change_contrasena = 0;

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
				'h-a': $('#elegir').data('type'),
				'tipo': $('#h-a').val() 
			};
			if ($('#h-a').val() == 'aliado') {
				obj['elegir'] = '1';
			} 
			var results = ajax('post',base_url+'configuracion/alta',false,obj);
			results.success(function(data){
				alert(data);
				if (data == 'Hecho') {
					window.location.replace(base_url+'configuracion/usuarios?action=gestion');
				}
			});
		} 
		else{
			// var obj = {
			// 	'aliado': $('#a-aliado').val()
			// };
			// var results = ajax('post',base_url+'configuracion/alta_aliado',true,obj);
			// results.success(function(data){
			// 	// alert(data);
			// });
		}
	}

	function  select(type) {
		if (type == 'hacienda' || type == 'activaciones') {
			if (type == 'hacienda') {
				var text = 'Elegir hacienda';
				var obj = { 'vendedor': $('#h-a').val() };
			} 
			else{
				var text = 'Elegir aliado';
				var obj = { 'vendedor': 'aliado' };
			}
			var results = ajax('post',base_url+'configuracion/vendedor',false,obj);
			results.success(function(data){
				$('#elegir').data('type',type).html(data).attr('required',true);
				$('#contain-elegir').removeClass('no-display');
				$('#elegir_label').text(text);
			});
		} 
		else if (type == '' || type  == 'aliado') {
			$('#contain-elegir').addClass('no-display').removeAttr('required');
			$('#elegir').removeAttr('required');
		}
	}

	function  guardar(id_usuario,element) {
		var obj = {
			'id_usuario': id_usuario,
			'usuario': $('.usuario-'+id_usuario).val(),
			'correo': $('.correo-'+id_usuario).val(),
			'contrasena': $('.contrasena-'+id_usuario).val(),
			'submit': $('.btn-'+id_usuario).val(),
			'submit_e': $('.eliminar-'+id_usuario).val(),
			'c_usuario': change_usuario,
			'c_correo': change_correo,
			'c_contrasena': change_contrasena
		}
		var results = ajax('post',base_url+'configuracion/guardar',false,obj);
		results.success(function(data){
			alert(data);
			if (data == 'Hecho') {
				location.reload();
			}
		});
	}

	function eliminar_usuario(id_usuario) {
		var obj = {
			'id_usuario': id_usuario
		}
		var results = ajax('post',base_url+'configuracion/eliminar',false,obj);
		results.success(function(data){
			alert(data);
			if (data == 'Hecho') {
				location.reload();
			}
		});
	}

	// - EVENTOS

	$('.btn-eliminar').on('click',function(){
		if (confirm("Se eliminará el usuario ¿Desea continuar?") == true) {
        eliminar_usuario($(this).parent().parent().data('id-usuario'));
	   }
	});

	$('.usuario').on('change',function(){
		change_usuario = 1;
		// alert('text')
	});

	$('.correo').on('change',function(){
		change_correo = 1;
		// alert('text')
	});

	$('.contrasena').on('change',function(){
		change_contrasena = 1;
		// alert('text')
	});

	$('.frm').on('submit',function(e){
		e.preventDefault();
		guardar($(this).data('id-usuario'),$(this).find('tr'));
	});

	$('#h-a').on('change',function(){
		select($(this).val());
	});

	$('#frm-usuario').on('submit',function(e){
		e.preventDefault();
		alta();
	});

	$('#a-aliado').on('input',null,null,callbackFunction); 

});