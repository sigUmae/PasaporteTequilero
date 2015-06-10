$('document').ready(function(){

	// variables

	var id_p = $('#id_pasaporte');

	// funciones

	function ajax(tipo,url,sync,datos){
		return $.ajax({
			type: tipo,
			url: url,
			async: sync,
			data: datos
		});
	}

	function id_pasaporte() {
		var results = ajax('post',base_url+'config_pasaportes/id_pasaporte',false,null);
		results.success(function(data){
			id_p.val(data);
		});
	}

	function venta() {
		var respuesta = '';
		var obj = {
			'id_pasaporte': $('#id_pasaporte').val(),
			'vendedor': $('#vendedor').val(),
			'propietario': $('#propietario').val(),
			'pago': $('#pago').val(),
			'telefono': $('#telefono').val(),
			'correo': $('#correo').val(),
			'domicilio': $('#domicilio').val(),
			'n-vendedor': $('#n-vendedor').text().toLowerCase(),
			'fisico': 'no',
			'id_fisico': '0'
			// 'dni': $('#dni').val(),
			// 'ciudad': $('#ciudad').val(),
			// 'estado': $('#estado').val(),
			// 'pais': $('#pais').val(),
			// 'cp': $('#cp').val(),
			// 'num_tarjeta': $('#num-tarjeta').val(),
			// 'r_num_tarjeta': $('#r-num-tarjeta').val(),
			// 'f_expiracion_input': $('#f-expiracion-i').val(),
			// 'c_seguridad': $('#c-seguridad').val(),
			// 'tarjeta': $('#tarjeta').val()
		};
		if($('#fisico').is(':checked')) {
			obj['fisico'] = '1';
			obj['id_fisico'] = $('#id_fisico').val();
		}
		else {
			obj['fisico'] = 'no';
			obj['id_fisico'] = '0';
		}
		var results = ajax('post',base_url+'config_pasaportes/realizar_venta',false,obj);
		results.success(function(data){
			alert(data);
			respuesta = data;
		});
		return respuesta;
	}

	function elementos_tc(value) {
		if (value == '2') {
			$('.no-display-tarjeta')
				.addClass('display-tarjeta')
				.removeClass('no-display-tarjeta')
				.find(':input:not(.no-display)')
				.attr('required',true);
			$('#telefono, #correo, #domicilio, #tarjeta').attr('required',true);
		}
		else {
			$('.display-tarjeta')
				.addClass('no-display-tarjeta')
				.removeClass('display-tarjeta')
				.find(':input:not(.no-display)')
				.removeAttr('required');
			$('#telefono, #correo, #domicilio, #tarjeta').removeAttr('required');
		}
	}

	// eventos

	$('#virtual').on('change',function(){

		if(this.checked) {
			$('#fisico_input').addClass('no-display').find('input').removeAttr('required');
		}

	});

	$('#fisico').on('change',function(){

		if(this.checked) {
			$('#fisico_input').removeClass('no-display').find('input').attr('required',true);
		}

	});

	$('#pago').on('change',function(){
		// elementos_tc($(this).val());
	});

	$('#frm-venta-a').on('submit',function(e){
		e.preventDefault();
		var respuesta = venta();
		if (respuesta.indexOf('Correo') >= 0) {
			window.location.replace(base_url+'config_pasaportes/ventas');
		}
	});

	$('#f_expiracion').datetimepicker({
		format: 'YYYY/MM'
	});

	$('#virtual').prop('checked',true);
	
	id_pasaporte();

});