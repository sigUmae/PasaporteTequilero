$('document').ready(function(){

	// variables

	var id_p = $('#first_p');
	$body = $("body");

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

	function venta(id_pasaporte_n) {
		var respuesta = '';
		var frm = $('#frm_'+id_pasaporte_n);
		var obj = {
			'id_pasaporte': frm.find('.id_pasaporte').val(),
			'vendedor': frm.find('.vendedor').val(),
			'propietario': frm.find('.propietario').val(),
			'pago': frm.find('.pago').val(),
			'telefono': frm.find('.telefono').val(),
			'correo': frm.find('.correo').val(),
			'domicilio': frm.find('.domicilio').val(),
			'n-vendedor': frm.find('.n-vendedor').text().toLowerCase(),
			'fisico': 'no',
			'id_fisico': '0',
			'referencia_on': '0',
			'referencia': '0',
			'submit': frm.find('.aceptar').val(),
			'submit_id': id_pasaporte_n
		};
		if(frm.find('.fisico').is(':checked')) {
			obj['fisico'] = '1';
			obj['id_fisico'] = frm.find('.id_fisico').val();
		}
		else {
			obj['fisico'] = 'no';
			obj['id_fisico'] = '0';
		}
		if(frm.find('.pago').val() == '2'){
			obj['referencia'] = frm.find('.num_referencia').val();
			obj['referencia_on'] = '1';
		}
		$.ajax({
			type: 'post',
			url: base_url+'config_pasaportes/realizar_venta',
			async: true,
			data: obj,
		   beforeSend: function(){
		   	$body.addClass('loading');
		   },
		   success: function(data){
		   	$body.removeClass('loading');
		   	alert(data);
		   	if (data.indexOf('Hecho') >= 0) {
					if ($('form').length == 1) {
						window.location.replace(base_url+'config_pasaportes/ventas');
					} 
					else{
						$('#frm-'+id_pasaporte_n).remove();
					}
				}
		   }
		   // ......
		 });
		// var results = ajax('post',base_url+'config_pasaportes/realizar_venta',true,obj);
		// results.beforeSend(function(data){
		// 	alert('text')
		// });
		// results.success(function(data){
		// 	alert(data);
		// 	// respuesta = data;
		// });
		// return respuesta;
	}

	function elementos_tc(value,id_pasaporte_n) {
		if (value == '2') {
			$('#frm_'+id_pasaporte_n).find('.c_referencia').removeClass('no-display').find('input').attr('required',true);
		}
		else {
			$('#frm_'+id_pasaporte_n).find('.c_referencia').addClass('no-display').find('input').removeAttr('required');
		}
	}

	// eventos

	$('#nueva-cantidad').on('click',function(){
		var cantidad = $('#cantidad').val();
		if (cantidad > 0) {
			window.location.replace(base_url+'config_pasaportes/ventas?action=venta&cantidad='+cantidad);
		}
	});

	$('.virtual').on('change',function(){

		if(this.checked) {
			var id_pasaporte_n = $(this).data('id');
			$('#frm_'+id_pasaporte_n).find('.fisico_input').addClass('no-display').find('input').removeAttr('required');
		}

	});

	$('.fisico').on('change',function(){

		if(this.checked) {
			var id_pasaporte_n = $(this).data('id');
			$('#frm_'+id_pasaporte_n).find('.fisico_input').removeClass('no-display').find('input').attr('required',true);
		}

	});

	$('.pago').on('change',function(){
		var id_pasaporte_n = $(this).data('id');
		elementos_tc($(this).val(),id_pasaporte_n);
	});

	$('.frm-venta-a').on('submit',function(e){
		e.preventDefault();
		var id_pasaporte_n = $(this).data('id');
		venta(id_pasaporte_n);
		// if (respuesta.indexOf('Hecho') >= 0) {
		// 	if ($('form').length == 1) {
		// 		window.location.replace(base_url+'config_pasaportes/ventas');
		// 	} 
		// 	else{
		// 		$('#frm-'+id_pasaporte_n).remove();
		// 	}
		// }
	});

	$('#f_expiracion').datetimepicker({
		format: 'YYYY/MM'
	});

	$('.virtual').prop('checked',true);
	
	// id_pasaporte();

});