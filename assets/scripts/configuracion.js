$('document').ready(function(){
	
	// - VARIABLES

	var btn_a = $('#aceptar');
	var in_a = $('#a-aliado');
	var frm = $('#frm-usuario');
	var id_pasaporte = "";
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

	function crear_confirmar(arguments) {
		$('#before-confirm').after('<div class="form-group has-error">'+
                    '<input id="confirm_contrasena" style="text-align: center" type="password" class="form-control" placeholder="Por favor confirme su contraseña para continuar">'+
                  '</div>'+
                  '<div style="width: 100%; text-align: center">'+
                    '<button '+
                      'id="confirmar"'+
                      'type="button"'+
                      'md-ink-ripple=""'+ 
                      'class="btn-eliminar-venta btn btn-fw btn-danger waves-effect waves-effect">'+
                      'Confirmar'+
                    '</button>'+
                  '</div>');
	}

	// - EVENTOS


	$('.btn-asignar').on('click',function(){
		var id_fisico = prompt('Por favor ingrese ID físico del pasaporte');
	    if (id_fisico != null) {
	       var obj = {
	       	'id_pasaporte': $(this).data('id-pasaporte'),
	       	'id_fisico': id_fisico
	       }
	       var result =ajax('post',base_url+'config_pasaportes/asignar',false,obj);
	       result.success(function(data){
	       	alert(data);
	       	location.reload();
	       });
	    }
	});

	$('#contain-panel').on('click','#confirmar',function(){
		var obj = {
			'id_pasaporte': id_pasaporte,
			'contrasena': $('#confirm_contrasena').val()
		}
		var result = ajax('post',base_url+'configuracion/eliminar_pasaporte',false,obj);
		result.success(function(data){
			alert(data);
			if (data == 'Hecho') {
				location.reload();
			}
		});
	});

	$('.btn-eliminar-venta').on('click',function(){
		if (confirm("Se eliminará la venta del pasaporte ¿Desea continuar?") == true) {
        		crear_confirmar();
        		id_pasaporte = $(this).data('id-pasaporte');
	   }
	});

	$('.btn-eliminar').on('click',function(){
		if (confirm("Se eliminará el usuario ¿Desea continuar?") == true) {
        	eliminar_usuario($(this).parent().parent().data('id-usuario'));
	   }
	});

	$('.usuario').on('change',function(){
		change_usuario = 1;
	});

	$('.correo').on('change',function(){
		change_correo = 1;
	});

	$('.contrasena').on('change',function(){
		change_contrasena = 1;
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