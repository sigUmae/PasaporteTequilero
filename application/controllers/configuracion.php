<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model(array('Inicio_m'));
    }

    public function index() {

    } 

    public function usuarios() {
    
    	$get = $this->input->get('action',true);
    	if ($get) {
    		$valido = $this->menu();
    		if ($valido) {
	   			switch ($get) {
	   				case 'alta':
	   					$this->load->view('configuracion/alta_v',$valido);
	   					break;
	   				case 'gestion':
	   					$this->load->view('configuracion/gestion_v',$valido);
	   					break;
	   				default:
	   					redirect('inicio/index');
	   					break;
	   			}
	   		}
    		else {
    			redirect('login/index');
    		}
    	}
    	else {
    		redirect('login/index');
    	}
    	
    }

    public function alta_aliado() {
    
    	$aliado = $this->input->post('aliado',true);
    	$ajax_request = $this->input->is_ajax_request();
    	if ($aliado and $ajax_request) {
    		$this->form_validation->set_rules('aliado','Aliado','required|is_unique[aliado.aliado]|min_length[4]|max_length[128]');
    		$this->form_validation->set_error_delimiters('','');
    		if ($this->form_validation->run() == false) {
    			echo validation_errors();
    		}
    		else {
    			$this->Master_m->insert('aliado',array('aliado' => $aliado));
    			echo 'Hecho'; // al cien
    		}
    	} 
    	else {
    		echo 'Error'; // error
    	}
    	
    	
    }

    public function vendedor() {
    
    	$vendedor = $this->input->post('vendedor',true);
    	$ajax_request = $this->input->is_ajax_request();
    	if ($ajax_request and $vendedor) {
    		$results = $this->Master_m->filas($vendedor);
    		$html = '<option value="">Seleccionar...</option>';
    		if (!empty($results)) {
    			foreach ($results as $value) {
    				if ($vendedor == 'hacienda') {
    					$html .= '<option value="'.$value->id.'">'.$value->hacienda.'</option>';	
    				}
    				else {
    					$html .= '<option value="'.$value->id.'">'.$value->aliado.'</option>';
    				}
    			}
    		}
    		echo $html;
    	} 
    	else {
    		echo 'Error'; // error
    	}
    	
    	
    }

    public function alta() {
    
    	$usuario = $this->input->post('usuario',true);
		$contrasena = $this->input->post('contrasena',true);
		$correo = $this->input->post('correo',true);
		$elegir = $this->input->post('elegir',true);
		$h_a = $this->input->post('h-a',true);
		$ajax_request = $this->input->is_ajax_request();

		if ($usuario and $contrasena and $correo and $elegir and $h_a and $ajax_request) {
			$this->form_validation->set_rules('elegir','Vendedor','required|integer');
			$this->form_validation->set_rules('h-a','Tipo','required');
			$this->form_validation->set_rules('usuario','Usuario','required|is_unique[usuarios.usuario]|min_length[4]|max_length[32]');
			$this->form_validation->set_rules('contrasena','Contrasena','required|min_length[6]|max_length[128]|md5');
			$this->form_validation->set_rules('correo','Correo','required|is_unique[usuarios.correo]|max_length[128]|valid_email');
			$this->form_validation->set_error_delimiters('','');
			if ($this->form_validation->run() == false) {
				echo validation_errors();
			}
			else { 
				$vendedor = $this->Master_m->filas_condicion($h_a,array('id' => $elegir));
				if (!empty($vendedor)) {
					$data = array(
						'usuario' => $usuario, 
						'contrasena' => md5($contrasena), 
						'correo' => $correo, 
						'id_'.$h_a => $vendedor[0]->id, 
						'id_rol' => ($h_a == 'hacienda') ? '2' : '3'
					);
					if ($h_a == 'hacienda') {
						$img_hacienda = array(
							'1' => 'haciendas-sauza.jpg',
							'2' => 'haciendas-herradura.jpg',
							'3' => 'haciendas-cofradia.jpg'
						);
						$data['avatar'] = $img_hacienda[$vendedor[0]->id];
					}
					$this->Master_m->insert('usuarios',$data);
					echo 'Hecho';	// success
				}
				else {
					echo 'Vendedor no encontrado'; // vendedor no encontrado
				}
			}
		}
		else {
			echo 'Error'; // error
		}
    	
    }

    public function gestion() {
    
    	
    	
    }

    private function menu() {

    	if ($this->session->userdata('login')) {
			$data['rol'] = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
			$data['avatar'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
			$data['avatar'] = $data['avatar'][0]->avatar;
			$data['header'] = $this->get_header();
			$data['menu_1'] = $this->Master_m->filas_condicion('menu_1',array('id_rol' => $data['rol'][0]->id_rol));
			$data['rol'] = $data['rol'][0]->roles;
			$data['id_usuario'] = md5($this->session->userdata('id_usuario'));
			foreach ($data['menu_1'] as $menu_1) {
				$response = $this->Master_m->filas_condicion('menu_2',array('id_menu1' => $menu_1->id));
				if (!empty($response)) {
					foreach ($response as $value) {
						$data['menu_2'][] = $value;
					}	
				} 
			}
			foreach ($data['menu_2'] as $menu_2) {
				$response = $this->Master_m->filas_condicion('menu_3',array('id_menu2' => $menu_2->id));
				foreach ($response as $value) {	
					$data['menu_3'][] = $value;	
				}
			}
			return $data;
		
		} 
		else {
			return false;
		}

    }

    private function get_header() {
		$base_url['url'] = base_url();
		return $this->load->view('includes/header',$base_url);
	}

}