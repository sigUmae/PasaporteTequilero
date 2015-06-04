<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Inicio_m');
    }

	public function index() {

		if ($this->session->userdata('login')) {
			$this->table_usuarios();
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
			// echo '<pre>';
			$total_vendidos = $this->Inicio_m->count_pasaportes(array('status' => '1'));
			$vendidos = $this->Inicio_m->count_by_vendedor('hacienda');
			$vendidos_a = $this->Inicio_m->count_by_vendedor('aliado');
			foreach ($vendidos_a as $value) {
				$vendidos[] = $value;
			}
			foreach ($vendidos as $key => $value) {
				$vendidos[$key]->data = $this->porcentaje_vendidos((int)$total_vendidos[0]->pasaportes,(int)$value->data);
			}
			// print_r(json_encode($vendidos)); exit();
			// for ($i=0; $i < 5; $i++) { 
			// 	$container[] = array(
			// 		'label'=>'test'.$i,
			// 		'data'=>''
			// 	);		
			// }
			// echo '<pre>';
			// print_r($container); exit();
			// $obj = new stdClass();
			// $obj->titulo = 'titulo';
			// $obj->main = 'main';
			// $test = array($obj); 
			$data['ventas'] = json_encode($vendidos);
			$data['total_ventas'] = $total_vendidos[0]->pasaportes.' pasaportes';
			$this->load->view('inicio/index_v',$data);
		
		} 
		else {
			redirect('login/index');
		}
	}

	private function porcentaje_vendidos($total,$cantidad) {

		return ($cantidad*100)/$total;
		
	}

	private function table_usuarios() {

		$usuarios = $this->Master_m->filas('usuarios');
		$usuarios_data = new Data_usuarios($usuarios);
		$path = set_realpath('').'api\datatable.json';
		file_put_contents($path,json_encode($usuarios_data));

	}

	private function get_header() {
		$base_url['url'] = base_url();
		return $this->load->view('includes/header',$base_url);
	}

}

class Data_usuarios {

	public $aaData = '';

	function __construct($aaData="null") {
		$this->aaData = $aaData;
	}

}