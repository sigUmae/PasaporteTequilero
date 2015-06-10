<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {

        parent::__construct();
        $this->load->model(array('Login_m'));
        $this->load->library('My_PHPMailer');
    
    }

	public function index() {

		if ($this->session->userdata('login')) {
			redirect('inicio/index');
		} 
		else {
			$data['header'] = $this->get_header();
			$this->load->view('login/signin_v',$data);
		}

	}

	public function recuperar() {

		if ($this->session->userdata('login')) {
			redirect('inicio/index');
		} 
		else {
			$data['header'] = $this->get_header();
			$this->load->view('login/forgot-password_v',$data);
		}
	
	}

	public function crear_cuenta() {

		if ($this->session->userdata('login')) {
			redirect('inicio/index');
		} 
		else {
			$data['header'] = $this->get_header();
			$this->load->view('login/signup_v',$data);
		}
	
	}

	public function validar() {

		$usuario = $this->input->post('usuario',true);
		$contrasena = $this->input->post('contrasena',true);
		$ajax_request = $this->input->is_ajax_request();

		if ($usuario and $contrasena and $ajax_request) {
			$usuario =  $this->Login_m->validar('usuarios',array(
				'usuario' => $usuario, 
				'contrasena' => md5($contrasena),
				'status' => '1'
			),array('correo' => $usuario));

			if (!empty($usuario)) {
				$this->sesion($usuario);
				echo 1;
			}
			else {
				echo 0; // Usuario o contraseña incorrecta
			}
		}
		else {
			echo 2; // Error
		}
	
	}

	public function activar() {
		
		$get = $this->input->get('token',true);
		if ($get) {
			$usuario = $this->Master_m->filas_condicion('usuarios',array('token' => $get));
			$this->sesion($usuario);
			$this->Master_m->update('usuarios',array('status' => '1','token' => ''),array('token' => $get));
			redirect('inicio/index');
		}

	}

	public function crear() {

		$usuario = $this->input->post('usuario',true);
		$contrasena = $this->input->post('contrasena',true);
		$correo = $this->input->post('correo',true);
		$ajax_request = $this->input->is_ajax_request();

		if ($usuario and $contrasena and $correo and $ajax_request) {
			$this->form_validation->set_rules('correo','Correo','required|is_unique[usuarios.correo]|min_length[8]|max_length[64]');
			$this->form_validation->set_rules('usuario','Usuario','required|is_unique[usuarios.usuario]|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('contrasena','contrasena','required|min_length[8]|max_length[32]');
			$this->form_validation->set_error_delimiters('','');
			if ($this->form_validation->run() == false) {
				echo validation_errors(); // Ya existe un usuario
			}
			else {
				$token = md5(rand());
				$info_msj = array(
					'dominio' => 'no-reply@tequila.mx', 
					'origen' => 'Administrador Pasaporte tequila', 
					'asunto' => 'Activación de la cuenta', 
					'texto' => 'Para activar su cuenta por favor dar click en el siguiente enlace: '.base_url().'login/activar?token='.$token, 
					'destino' => $correo,
					'usuario' => $usuario
				);
				$enviado = $this->enviar_msj($info_msj);
				if (!$enviado) {
					$this->Master_m->insert('usuarios',array(
						'usuario' => $usuario,
						'contrasena' => md5($contrasena),
						'token' => $token,
						'correo' => $correo,
					));
					echo 'Hecho'; // Success	
				}
				else {
					echo 'Error'; // Error al enviar
				}
			}
		}
		else {
			echo 'Error'; // Datos no válidos
		}

	}

	public function recuperar_contra() {

		$correo = $this->input->post('correo',true);
		$ajax_request = $this->input->is_ajax_request();

		if ($correo and $ajax_request) {
			$this->form_validation->set_rules('correo','Correo','required');
			if ($this->form_validation->run() == false) {
				echo 1; // Error validacion
			}
			else {
				$usuario = $this->Master_m->filas_condicion('usuarios',array('correo' => $correo));
				if (!empty($usuario)) {
					$token = md5(rand());
					$info_msj = array(
						'dominio' => 'no-replay@pasaportetequilero.mx', 
						'origen' => 'Administrador Pasaporte tequila', 
						'asunto' => 'Recuperación de cuenta', 
						'texto' => 'Para recuperar su cuenta dar click en el siguiente enlace: '.base_url().'login/nueva_contrasena?token='.$token, 
						'destino' => $correo,
						'usuario' => $usuario[0]->usuario
					);
					$enviado = $this->enviar_msj($info_msj);
					if (!$enviado) {
						$this->Master_m->update('usuarios',array('token' => $token),array('correo' => $correo));
						echo 1;
					}
					else {
						echo 2; // Error al enviar
					}
				}
				else {
					echo 0; // No encontrado
				}
			}
		}

	}

	public function contrasena() {
		
		$contrasena = $this->input->post('contrasena',true);
		$contrasena_confirmar = $this->input->post('contrasena_confirmar',true);
		$token = $this->input->post('token',true);
		$ajax_request = $this->input->is_ajax_request();

		if ($contrasena and $contrasena_confirmar and $token and $ajax_request and $contrasena_confirmar == $contrasena) {
			$this->Master_m->update('usuarios',array(
				'contrasena' => md5($contrasena),
				'token' => ''
			),array('token' => $token));
			echo 1;			
		}
		else {
			echo 2;
		}

	}

	public function nueva_contrasena() {

		$get = $this->input->get('token',true);
		if ($get) {
			$usuario = $this->Master_m->filas_condicion('usuarios',array('token' => $get));
			if ($usuario) {		
				$data['header'] = $this->get_header();
				$data['token'] = $get;
				$this->load->view('login/recuperar_v',$data);
			}
		}

	}

	public function salir() {
		$this->session->sess_destroy();
		redirect('login/index');
	}

	private function enviar_msj($info_msj) {

		date_default_timezone_set('America/Mazatlan');
        $mail = new PHPMailer();
        $mail->IsSMTP(); 
        $mail->SMTPAuth   = true; 
        $mail->SMTPSecure = 'ssl';  
        $mail->Host       = 'pasaportetequilero.mx';      
        $mail->Port       = 465;                   
        $mail->Username   = 'no-replay@pasaportetequilero.mx';  
        $mail->Password   = '&{p$v[9DwCO}';            
        $mail->SetFrom($info_msj['dominio'], $info_msj['origen']);
        $mail->From = 'no-replay@pasaportetequilero.mx'; 
        $mail->Subject    = $info_msj['asunto'];
        $mail->Body       = $info_msj['texto'];
        // $mail->AltBody    = $info_msj['texto'];
        $mail->AddAddress($info_msj['destino'], $info_msj['usuario']);
        $mail->CharSet = 'UTF-8';

        if(!$mail->Send()) {
           return $mail->ErrorInfo;
        } 
        else {
            return false;
        }

    }

	private function get_header() {
		$base_url['url'] = base_url();
		return $this->load->view('includes/header',$base_url);
	}

	private function sesion($usuario) {

		$info = array(
			'id_usuario' => $usuario[0]->id,
			'usuario' => $usuario[0]->usuario,
			'correo' => $usuario[0]->correo,
			'login' => true
		);
		$this->session->set_userdata($info);
	
	}

}