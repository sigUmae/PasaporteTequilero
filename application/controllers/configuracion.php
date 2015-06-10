<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model(array('Inicio_m'));
    }

    public function index() {

    } 
    
     public function eliminar() {
    
        $id_usuario = $this->input->post('id_usuario',true);
        $ajax_request = $this->input->is_ajax_request();
        if ($id_usuario and $ajax_request) {
            $this->Master_m->update('usuarios',array('status' => '0'),array('id' => $id_usuario));
            echo 'Hecho';
        }
        
    }

    public function eliminar_pasaporte() {
    
        $id_pasaporte = $this->input->post('id_pasaporte',true);
        $contrasena = $this->input->post('contrasena',true);
        $ajax_request = $this->input->is_ajax_request();
        if ($id_pasaporte and $contrasena and $ajax_request) {
            $correcto = $this->Master_m->filas_condicion('usuarios',array(
                'id' => $this->session->userdata('id_usuario'),
                'contrasena' => md5($contrasena)
            ));
            if (!empty($correcto)) {
                $this->Master_m->update('info_compra',array('status' => '0'),array('id_pasaporte' => $id_pasaporte));
                echo 'Hecho';
            }
            else {
                echo 'Contraseña incorrecta';
            }
        }
        else {
            echo 'El campo contraseña es requerido';
        }
        
    }

    public function guardar() {
    
        $id_usuario = $this->input->post('id_usuario',true);
        $usuario = $this->input->post('usuario',true);
        $correo = $this->input->post('correo',true);
        $contrasena = $this->input->post('contrasena',true);
        $c_usuario = $this->input->post('c_usuario',true);
        $c_correo = $this->input->post('c_correo',true);
        $c_contrasena = $this->input->post('c_contrasena',true);
        $ajax_request = $this->input->is_ajax_request();
        // print_r($this->input->post('submit')); exit();
        if ($id_usuario and $usuario and $correo and $contrasena and $ajax_request) {
            if ($this->input->post('submit') == 'frm-'.$id_usuario) {
                if ($c_usuario == '1') {
                    $this->form_validation->set_rules('usuario','usuario','required|is_unique[usuarios.usuario]|min_length[4]|max_length[32]');    
                }
                if ($c_correo == '1') {
                    $this->form_validation->set_rules('correo','correo','required|is_unique[usuarios.correo]|max_length[128]|valid_email');
                }
                if ($c_contrasena == '1') {
                    $this->form_validation->set_rules('contrasena','contraseña','required|min_length[6]|max_length[128]|md5');
                }
                $this->form_validation->set_error_delimiters('','');
                if ($this->form_validation->run() == false) {
                    echo validation_errors();
                }
                else {
                    $data = array();
                    if ($c_usuario == '1') {
                        $data['usuario'] = $usuario;
                    }
                    if ($c_correo == '1') {
                        $data['correo'] = $correo;
                    }
                    if ($c_contrasena == '1') {
                        $data['contrasena'] = md5($contrasena);
                    }
                    $this->Master_m->update('usuarios',$data,array('id' => $id_usuario));
                    echo 'Hecho';
                }
            }
        }
        else {
            echo 'Error';
        }
        
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
	   					$valido['usuarios'] = $this->Master_m->filas_condicion('usuarios',array('status' => '1', 'id_rol !=' => '1'));
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
		$tipo = $this->input->post('tipo',true);
		$ajax_request = $this->input->is_ajax_request();

		if ($usuario and $contrasena and $correo and $elegir and $h_a and $tipo and $ajax_request) {
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
                if ($tipo == 'aliado') {
                    $this->Master_m->insert('aliado',array('aliado' => 'alianza_'.$usuario));
                    $vendedor = $this->Master_m->filas_condicion('aliado',array('aliado' => 'alianza_'.$usuario));
                    if (!empty($vendedor)) {
                         $data = array(
                            'usuario' => $usuario, 
                            'contrasena' => md5($contrasena), 
                            'correo' => $correo, 
                            'id_'.$h_a => $vendedor[0]->id, 
                            'id_rol' => '3'
                        );
                        $this->Master_m->insert('usuarios',$data);
                        echo 'Hecho'; // success 
                        exit();
                    }
                    else {
                        echo 'Vendedor no encontrado';
                    }
                }
                else {
                    $h_a = ($h_a == 'hacienda') ? $h_a : 'aliado' ;
                    $vendedor = $this->Master_m->filas_condicion($h_a,array('id' => $elegir));
                    if (!empty($vendedor)) {
                        $data = array(
                            'usuario' => $usuario, 
                            'contrasena' => md5($contrasena), 
                            'correo' => $correo, 
                            'id_'.$h_a => $vendedor[0]->id, 
                            'id_rol' => ($h_a == 'hacienda') ? '2' : '3',
                            'activador' => ($h_a == 'hacienda') ? '0' : '1',
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
                        echo 'Hecho';   // success
                    }
                    else {
                        echo 'Vendedor no encontrado'; // vendedor no encontrado
                    }
                }
			}
		}
		else {
			echo 'Error'; // error
		}
    	
    }

    
    private function menu() {

    	if ($this->session->userdata('login')) {
			$data['rol'] = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
			$data['avatar'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
			$data['avatar'] = $data['avatar'][0]->avatar;
			$data['header'] = $this->get_header();
			$data['menu_1'] = $this->Master_m->filas_condicion('menu_1',array('id_rol' => $data['rol'][0]->id_rol));
			$data['id_rol'] = $data['rol'][0]->id;
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
			switch ($data['id_rol']) {
                case '1':
                    $data['color_1'] = 'c-admin';
                    $data['color_2'] = 'c-admin-50';
                    break;
                case '2':
                    $data['color_1'] = 'c-hacienda';
                    $data['color_2'] = 'c-hacienda-50';
                    break;
                case '3':
                    $data['color_1'] = 'c-aliado';
                    $data['color_2'] = 'c-aliado-50';
                    break;
                default:
                    $data['color_1'] = 'blue';
                    $data['color_2'] = 'blue-50';
                    break;
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