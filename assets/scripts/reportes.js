$('document').ready(function(){
	
	// - VARIABLES

	var opciones = {
		'hoy': 	'<div class="col-sm-12">'+
					'<button type="button" id="aceptar" md-ink-ripple="" class="btn btn-fw btn-success waves-effect waves-effect btn-aceptar waves-effect waves-effect">Aceptar</button>'+
				'</div>',
		'ayer': '<div class="col-sm-12">'+
					'<button type="button" id="aceptar" md-ink-ripple="" class="btn btn-fw btn-success waves-effect waves-effect btn-aceptar waves-effect waves-effect">Aceptar</button>'+
				'</div>',
		'mes': 	'<div class="col-sm-12">'+
					'<button type="button" id="aceptar" md-ink-ripple="" class="btn btn-fw btn-success waves-effect waves-effect btn-aceptar waves-effect waves-effect">Aceptar</button>'+
				'</div>',
		'fecha': '<div class="col-sm-6">'+
					'<div class="form-group">'+
						'<div class="input-group date" id="fecha1">'+
		          			'<input type="text" class="form-control" />'+
		          			'<span class="input-group-addon">'+
		            			'<span class="glyphicon glyphicon-calendar"></span>'+
		          			'</span>'+
		        		 '</div>'+
		        	'</div>'+
	        	 '</div>'+
	        	 '<div class="col-sm-6">'+
        		  	'<button type="button" id="aceptar" md-ink-ripple="" class="btn btn-fw btn-success waves-effect waves-effect btn-aceptar waves-effect waves-effect">Aceptar</button>'+
				 '</div>',
		'rango-fechas': '<div class="col-sm-4">'+
							'<div class="form-group">'+
								'<div class="input-group date" id="fecha1">'+
				          			'<input type="text" class="form-control" />'+
				          			'<span class="input-group-addon">'+
				            			'<span class="glyphicon glyphicon-calendar"></span>'+
				          			'</span>'+
				        		 '</div>'+
				        	'</div>'+
						'</div>'+
						'<div class="col-sm-4">'+
							'<div class="form-group">'+
								'<div class="input-group date" id="fecha2">'+
				          			'<input type="text" class="form-control" />'+
				          			'<span class="input-group-addon">'+
				            			'<span class="glyphicon glyphicon-calendar"></span>'+
				          			'</span>'+
				        		 '</div>'+
				        	'</div>'+
						'</div>'+
						'<div class="col-sm-4">'+
							'<button type="button" id="aceptar" md-ink-ripple="" class="btn btn-fw btn-success waves-effect waves-effect btn-aceptar waves-effect waves-effect">Aceptar</button>'+
						'</div>'
	};

	var s_options = $('#contain-options');
	var attr_e = $('#r_excel').attr('href');

	// - FUNCIONES

	function ajax(tipo,url,sync,datos){
		return $.ajax({
			type: tipo,
			url: url,
			async: sync,
			data: datos
		});
	}

	function elegir_rango(arguments) {
		s_options.empty();
		s_options.html(opciones[arguments]);
	}

	function url_excel(arguments) {
		var funcion = 'config_pasaportes/g_reporte';
		var get1 = $('#rango').val();
		var get2 = $('#fecha1').data('date');
		var get3 = $('#fecha2').data('date');
		switch(get1) {
			case 'hoy': 
			case 'ayer': 
			case 'mes': window.location.replace(base_url+funcion+'?rol='+$('#r_excel').data('rol')+'&'+arguments+'='+get1); break;
			case 'fecha': window.location.replace(base_url+funcion+'?rol='+$('#r_excel').data('rol')+'&'+arguments+'='+get1+'&fecha1='+get2); break;
			case 'rango-fechas': window.location.replace(base_url+funcion+'?rol='+$('#r_excel').data('rol')+'&'+arguments+'=entre&fecha1='+get2+'&fecha2='+get3); break;
		}
	}

	function url(arguments) {
		var funcion = 'config_pasaportes/rango_fechas';
		var get1 = $('#rango').val();
		var get2 = $('#fecha1').data('date');
		var get3 = $('#fecha2').data('date');
		switch(get1) {
			case 'hoy': 
			case 'ayer': 
			case 'mes': window.location.replace(base_url+funcion+'?'+arguments+'='+get1); break;
			case 'fecha': window.location.replace(base_url+funcion+'?'+arguments+'='+get1+'&fecha1='+get2); break;
			case 'rango-fechas': window.location.replace(base_url+funcion+'?'+arguments+'=entre&fecha1='+get2+'&fecha2='+get3); break;
		}
	}

	function kit(id_pasaporte) {
		var obj = { 'id_pasaporte' : id_pasaporte };
		var results = ajax('post',base_url+'config_pasaportes/kit_',true,obj);
		results.success(function(data){
			alert(data);
			location.reload();
		});
	}

	// - EVENTOS

	$('.table-responsive').on('click','.btn-kit',function(){
		var has_class = $(this).hasClass('btn-error');
		if (!has_class) {
			kit($(this).parent().data('id-pasaporte'));
		}
		else {
			alert('El pasaporte ya tiene kit')
		}
	});

	$('#rango').on('change',function(){
		var value = $(this).val();
		elegir_rango(value);
		$('#fecha1, #fecha2').datetimepicker({
			format: 'YYYY-MM-DD'
		});
		// if (value != '') {
		// 	$('#r_excel').attr('href',url_excel(s_options.data('id')));
		// }
		// else {
		// 	$('#r_excel').attr('href',attr_e);
		// }
		if (value == '') {
			$('#r_excel').attr('href',attr_e);
		}
	});

	$('#r_excel').on('click',function(e){
		if ($('#rango').val() == '') {
			$('#r_excel').attr('href',attr_e);
		}
		else {
			e.preventDefault();
			url_excel(s_options.data('id'));
		}
	});

	$('#datetimepicker1').datetimepicker({
		format: 'YYYY-MM-DD'
	});

	$('#contain-options').on('click','#aceptar',function(){
		url(s_options.data('id'));
	});

});