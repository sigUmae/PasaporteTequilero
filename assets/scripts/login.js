$('document').ready(function(){

	// - VARIABLES

	// - FUNCIONES

	function ajax(tipo,url,sync,datos){
		return $.ajax({
			type: tipo,
			url: url,
			async: sync,
			data: datos
		});
	}

	function login(){
		var obj = {
			'usuario': $('#usuario').val(),
			'contrasena': $('#contrasena').val()
		};
		var result = ajax('post',base_url+'index.php/login/validar',false,obj);
		result.success(function(data){
			// console.log(data);
			switch(data) {
				case '0':
					alert('Usuario o contraseña incorrecta');
					break;
				case '1':
					window.location.replace(base_url+'inicio/index');
					break;
				case '2':
					alert('Ha ocurrido un error, por favor vuelve a intentar');
					break;
			}
		});
	}

	function crear() {
		var obj = {
			'usuario': $('#usuario').val(),
			'correo': $('#correo').val(),
			'contrasena': $('#contrasena').val()
		};
		var result = ajax('post',base_url+'index.php/login/crear',false,obj);
		result.success(function(data){
			switch(data) {
				case '0': alert('Error');
					break;
				case '1':
					window.location.replace(base_url+'login');
					break;
				case '2':
					break;
				case '3': alert('Existe');
					break;
			}
		});
	}

	function recuperar_contra() {
		var obj = { 'correo': $('#correo').val() };
		var result = ajax('post',base_url+'index.php/login/recuperar_contra',false,obj);
		result.success(function(data){
			switch(data) {
				case '0': alert('Error');
					break;
				case '1':
					alert('Correo enviado');
					window.location.replace(base_url+'login/index');
					break;
				case '2':
					break;
			}
		});
	}

	function contrasena() {
		var obj = {
			'contrasena': $('#contrasena').val(),
			'contrasena_confirmar': $('#contrasena-confirmar').val(),
			'token': token
		};
		var result = ajax('post',base_url+'index.php/login/contrasena',false,obj);
		result.success(function(data){
			switch(data) {
				case '0': alert('Error');
					break;
				case '1':
					alert('Hecho');
					window.location.replace(base_url+'inicio/index');
					break;
				case '2':
					break;
				case '3': alert('Existe');
					break;
			}
		});
	}

	// - EVENTOS

	$('#frm-nuevo-contrasena').on('submit',function(e){
		e.preventDefault();
		contrasena();
	});

	$('#frm-recuperar').on('submit',function(e){
		e.preventDefault();
		recuperar_contra();
	})

	$('#frm-crear').on('submit',function(e){
		e.preventDefault();
		crear();
	});

	$('#frm-login').on('submit',function(e){
		e.preventDefault();
		login();
	});

});