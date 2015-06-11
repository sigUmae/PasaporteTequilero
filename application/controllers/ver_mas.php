<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ver_mas extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model(array('Inicio_m','Ver_mas_m'));
    }

	public function index() {
	
		$get = $this->input->get('pasaporte',true);
		$valid = $this->menu();
		if ($get and $valid) {
			$valid['info_pasaporte'] = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $get));
			if (!empty($valid['info_pasaporte'])) {
				$valid['visita'] = $this->pasaporte($get);
				$valid['info_pasaporte'] = $valid['info_pasaporte'][0];
				$valid['id'] = $get;
				$this->load->view('ver_mas/pasaporte_v',$valid);	
			}
			else {
				redirect(base_url('config_pasaportes/reportes'));
			}
		}

	}

   public function cambiar_correo() {
   
      $id_pasaporte = $this->input->post('id_pasaporte',true);
      $correo = $this->input->post('correo',true);
      $ajax_request = $this->input->is_ajax_request();
      if ($id_pasaporte and $correo and $ajax_request) {
         $this->form_validation->set_rules('correo','correo','required|valid_email');
         $this->form_validation->set_error_delimiters('','');
         if ($this->form_validation->run() == false) {
            echo validation_errors();
         }
         else {
            $existe = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $id_pasaporte));
            if (!empty($existe)) {
               $this->Master_m->update('info_compra',array('correo' => $correo),array('id_pasaporte' => $id_pasaporte));
               echo 'Hecho';
               // $info_msj = array(
               //     'dominio' => 'no-replay@pasaportetequilero.mx',
               //     'origen' => 'Hacienda Pasaporte tequila', 
               //     'asunto' => 'Pasaporte', 
               //     'texto' => 'ID virtual: '.$info_compra[0]->id_pasaporte. ' ID físico: '.$info_compra[0]->id_fisico,
               //     'destino' => $info_compra[0]->correo,
               //     'usuario' => $info_compra[0]->propietario
               // );
               // $enviado = $this->enviar_msj($info_msj);
               // if (!$enviado) {
               //     echo 'Pasaporte enviado'; // Success  
               // }
               // else {
               //     echo 'Error al enviar pasaporte'; // Error al enviar
               // }
            }
            else {
               echo 'Pasaporte no encontrado';
            }
         }
      }
      else {
         echo 'Error';
      }
      
   }

	private function pasaporte($id_pasaporte) {

		$haciendas = $this->Master_m->filas('hacienda');
		$visitas = $this->Master_m->filas_condicion('visitas',array('id_pasaporte' => $id_pasaporte));
		if (!empty($visitas)) {
			foreach ($haciendas as $value_v) {
				$hacienda_visita = $this->Ver_mas_m->visitas($id_pasaporte,$value_v->id);
				if (!empty($hacienda_visita)) {
					$visita[] = $hacienda_visita[0]->id_hacienda;
				}
				else {
					$visita[] = array();	
				}
			}
			return $visita; 
		} 
		else {
			return 0;
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

    public function total_visitas() {
    
    	$id_hacienda = $this->input->post('id_hacienda',true);
    	$pasaporte = $this->input->post('id_pasaporte',true);
    	$ajax_request = $this->input->is_ajax_request();
    	if ($id_hacienda and $pasaporte and $ajax_request) {
    		$visitas = $this->Master_m->filas_condicion('visitas',array(
    			'id_hacienda' => $id_hacienda,
    			'id_pasaporte' => $pasaporte
    		));
    		$html = '';
    		if (!empty($visitas)) {
    			foreach ($visitas as $value) {
    				$html .= $value->fecha.' ';
    			}
    			echo $html;
    		}
    		else {
    			echo 'No hay visitas';
    		}
    	}
    	else {
    		echo '500';
    	}
    	
    }

    private function get_header() {
		$base_url['url'] = base_url();
		return $this->load->view('includes/header',$base_url);
	}

}