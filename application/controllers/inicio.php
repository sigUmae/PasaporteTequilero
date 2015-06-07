<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('Inicio_m');
    }

	public function index() {

		if ($this->session->userdata('login')) {
			// $this->table_usuarios();
			$data['rol'] = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
			$data['avatar'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
			$data['avatar'] = $data['avatar'][0]->avatar;
			$data['header'] = $this->get_header();
			$data['menu_1'] = $this->Master_m->filas_condicion('menu_1',array('id_rol' => $data['rol'][0]->id_rol));
			$data['id_rol'] = $data['rol'][0]->id;
			$data['rol'] = $data['rol'][0]->roles;
			$data['id_usuario'] = md5($this->session->userdata('id_usuario'));
			switch ($data['id_rol']) {
				case '1':
					$data['color_1'] = 'c-admin';
					$data['color_2'] = 'c-admin-50';
					$data['admin'] = '1';
					$total_vendidos = $this->Inicio_m->count_pasaportes(array('status' => '1','tipo_pago' => 'Pagado'),'= CURDATE()');
					// $total_vendidos[0]->pasaportes = '0';
					if ($total_vendidos[0]->pasaportes == '0') {
						$obj = new stdClass();
						$obj->label = 'Vendedor';
						$obj->data = '0';
						$vendidos = array($obj);
					} 
					else {
						$vendidos = $this->count($total_vendidos[0]->pasaportes);
						// echo '<pre>';
						// print_r($vendidos); exit();
						$data['total_ventas'] = $total_vendidos[0]->pasaportes.' pasaportes';
					}

					$semena_venta = $this->count_day('info_compra');
					$semena_visita = $this->count_day('visitas');
					$semena_kit = $this->count_day('kit','2');
					$semena_comision = $this->fecha_comision();

					// echo '<pre>';
					// print_r(json_encode($this->fecha_comision())); exit();
					
					$data['ventas'] = json_encode($vendidos);
					$data['ventas_semana'] = json_encode($semena_venta);
					$data['semena_visita'] = json_encode($semena_visita);
					$data['semena_kit'] = json_encode($semena_kit);
					$data['semena_comision'] = json_encode($semena_comision);
					$data['total_vendidos'] = $total_vendidos[0]->pasaportes;
					break;
				case '2':
					$data['admin'] = '0';
					$data['color_1'] = 'c-hacienda';
					$data['color_2'] = 'c-hacienda-50';
					break;
				case '3':
					$data['admin'] = '0';
					$data['color_1'] = 'c-aliado';
					$data['color_2'] = 'c-aliado-50';
					break;
				default:
					$data['admin'] = '0';
					$data['color_1'] = 'blue';
					$data['color_2'] = 'blue-50';
					break;
			}
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
			$this->load->view('inicio/index_v',$data);
		
		} 
		else {
			redirect('login/index');
		}
	}

	private function fecha_comision() {
	
		$semana = array();
		for ($i=1; $i <= 7; $i++) {
			$day = $this->Inicio_m->count_days($i,'fecha_comision');
			$semana[] = new stdClass();
			$semana[$i-1]->label = 'Dia '.$i;
			$semana[$i-1]->data = $day[0]->pasaportes;
		}
		return $semana;
	}

	private function count_day($tabla,$status="1") {
	
		$semana = array();
		for ($i=1; $i <= 7; $i++) {
			$day = $this->Inicio_m->count_days($i,$tabla,$status);
			$by_day = array($i,(int)$day[0]->pasaportes);
			$semana[] = $by_day; 
		}
		return $semana;
		
	}

	private function count($total_vendidos) {
	
		$vendidos = $this->Inicio_m->count_by_vendedor('hacienda');
		$vendidos_a = $this->Inicio_m->count_by_vendedor('aliado');	
		foreach ($vendidos_a as $value) {
			$vendidos[] = $value;
		}
		foreach ($vendidos as $key => $value) {
			$vendidos[$key]->data = $this->porcentaje_vendidos((int)$total_vendidos,(int)$value->data);
		}	
		return $vendidos;

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