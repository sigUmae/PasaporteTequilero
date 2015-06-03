<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Perfil extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Inicio_m');
    }

    public function index() {

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
			$this->load->view('perfil/profile_v',$data);
		
		} 
		else {
			redirect('login/index');
		}

    }

    public function subir() {
    	$nombre =  md5($this->session->userdata('id_usuario'));
    	$config['file_name'] = $nombre;
    	$config['upload_path'] = './assets/images';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '512';
		$config['max_height']  = '512';	
		$this->load->library('upload', $config);;
		if (!$this->upload->do_upload()) {
			$error = array('error' => $this->upload->display_errors());
			print_r($error);
		}	
		else {
			$data = array('upload_data' => $this->upload->data());
			$nom_ext = $nombre.$data['upload_data']['file_ext'];
			$this->Master_m->update('usuarios',array('avatar' => $nom_ext),array('id' => $this->session->userdata('id_usuario')));
			// redirect('perfil?');
		}
    }

    private function get_header() {
		$base_url['url'] = base_url();
		return $this->load->view('includes/header',$base_url);
	}

}