<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller {

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
			$data['id_rol'] = $data['rol'][0]->id;
			$data['rol'] = $data['rol'][0]->roles;
			$data['id_usuario'] = md5($this->session->userdata('id_usuario'));
			switch ($data['id_rol']) {
				case '1':
					$data['color_1'] = 'c-admin';
					$data['color_2'] = 'c-admin-50';
					$data['admin'] = '1';
					$total_vendidos = $this->Inicio_m->count_pasaportes(array('status' => '1','tipo_pago' => 'Pagado'),'= CURDATE()');
					if ($total_vendidos[0]->pasaportes == '0') {
						$obj = new stdClass();
						$obj->label = 'Vendedor';
						$obj->data = '0';
						$vendidos = array($obj);
					} 
					else {
						$vendidos = $this->count($total_vendidos[0]->pasaportes);
						$data['total_ventas'] = $total_vendidos[0]->pasaportes.' pasaportes';
					}
					$semena_venta = $this->count_day('info_compra','1','AND tipo_pago = "Pagado"');
					$semena_visita = $this->count_day('visitas');
					$semena_kit = $this->count_days_kit('2');
					$semena_comision = $this->fecha_comision();
					$vendidos_;
					foreach($vendidos as $venta) {
						if($venta->data > '0') {
							$venta->data = round($venta->data);
							$vendidos_[] = $venta;	
						}
					}
					
					$data['ventas'] = json_encode($vendidos);
					$data['ventas_semana'] = json_encode($semena_venta);
					$data['semena_visita'] = json_encode($semena_visita);
					$data['semena_kit'] = json_encode($semena_kit);
					$data['semena_comision'] = json_encode($semena_comision);
					$data['total_vendidos'] = $total_vendidos[0]->pasaportes;
					break;
				case '2':
					$data['admin'] = '2';
					$data['color_1'] = 'c-hacienda';
					$data['color_2'] = 'c-hacienda-50';

					$id_hacienda = $this->Inicio_m->get_id_vendedor(array(
						'vendedor' => 'hacienda',
						'id_usuario' => $this->session->userdata('id_usuario')
					));
					if (!empty($id_hacienda)) {
						$id_hacienda = $id_hacienda[0]->id_hacienda;
						$data['count'] = $this->count_dsm('hacienda',$id_hacienda);
						$semena_venta = $this->count_day('info_compra','1','AND status="1" AND id_hacienda = "'.$id_hacienda.'" AND tipo_pago = "Pagado"');
						$data['ventas_semana'] = json_encode($semena_venta);
						$semena_visitas = $this->count_day('visitas','1','AND id_hacienda = "'.$id_hacienda.'"');
						$data['semana_visitas'] = json_encode($semena_visitas);
						$semena_kit = $this->count_days_kit('2','AND id_hacienda = "'.$id_hacienda.'"');
						$data['semena_kit'] = json_encode($semena_kit);
						$semana_comision = $this->count_days_comision('hacienda',$id_hacienda);
						$data['semana_comision'] = json_encode($semana_comision);
					}
					else {
						$this->session->sess_destroy();
						redirect('login/index');
					}

					break;
				case '3':
					$usuario = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
					$data['activador'] = $usuario[0]->activador;
					$data['admin'] = '3';
					$data['color_1'] = 'c-aliado';
					$data['color_2'] = 'c-aliado-50';
					$id_aliado = $this->Inicio_m->get_id_vendedor(array(
						'vendedor' => 'aliado',
						'id_usuario' => $this->session->userdata('id_usuario')
					));
					if (!empty($id_aliado)) {
						$id_aliado = $id_aliado[0]->id_aliado;
						$data['count'] = $this->count_dsm('aliado',$id_aliado);
					}

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

	private function count_dsm($vendedor,$id_vendedor) {
	
		$total_vendidos = $this->Inicio_m->count_pasaportes(array(
			'status' => '1',
			'tipo_pago' => 'Pagado',
			'id_'.$vendedor => $id_vendedor
		),'= CURDATE()');
		$count['total_v_dia'] = $total_vendidos[0]->pasaportes;
		$total_vendidos = $this->Inicio_m->count_pasaportes(array(
			'status' => '1',
			'tipo_pago' => 'Pagado',
			'id_'.$vendedor => $id_vendedor
		),'>= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND DATE(FECHA) != CURDATE()');
		$count['total_v_semana'] = $total_vendidos[0]->pasaportes;
		$total_vendidos = $this->Inicio_m->count_pasaportes(array(
			'status' => '1',
			'tipo_pago' => 'Pagado',
			'id_'.$vendedor => $id_vendedor
		),'>= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND DATE(FECHA) != CURDATE()');
		$count['total_v_mes'] = $total_vendidos[0]->pasaportes;
		return $count;
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

	private function count_days_comision($vendedor,$id_vendedor,$con_vendedor="") {
	
		$semana = array();
		for ($i=1; $i <= 7; $i++) {
			$day = $this->Inicio_m->comision_day($i,$vendedor,$id_vendedor,$con_vendedor);
			$semana[] = new stdClass();
			$semana[$i-1]->label = 'Dia '.$i;
			$semana[$i-1]->data = $day[0]->pasaportes;
		}
		return $semana;
		
	}

	private function count_days_kit($status="1",$con_vendedor="") {
	
		$semana = array();
		for ($i=1; $i <= 7; $i++) {
			$day = $this->Inicio_m->count_days_kit($i,$status,$con_vendedor);
			$by_day = array($i,(int)$day[0]->pasaportes);
			$semana[] = $by_day; 
		}
		return $semana;
		
	}

	private function count_day($tabla,$status="1",$con_vendedor="") {
	
		$semana = array();
		for ($i=1; $i <= 7; $i++) {
			$day = $this->Inicio_m->count_days($i,$tabla,$status,$con_vendedor);
			$by_day = array($i,(int)$day[0]->pasaportes);
			$semana[] = $by_day; 
		}
		return $semana;
		
	}

	private function count($total_vendidos) {
	
		$vendidos = $this->Inicio_m->count_by_vendedor('hacienda');
		$vendidos_a = $this->Inicio_m->count_by_vendedor('aliado');	
		$vendidos_web = $this->Inicio_m->count_web();	
		foreach ($vendidos_a as $value) {
			$vendidos[] = $value;
		}
		foreach ($vendidos_web as $key => $value) {
			$value->label = 'Web';
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