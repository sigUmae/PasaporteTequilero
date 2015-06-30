<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas extends CI_Controller {

   function __construct() {
        parent::__construct();
        $this->load->model(array('Inicio_m','Config_pasaporte_m','Estadisticas_m'));
    }

   public function index() {
      
      $valid = $this->menu();
      $valid = $this->estadisticas_hoy($valid);
      $this->load->view('estadisticas/estadisticas_v',$valid);

   }

   public function estadisticas_hoy($valid) {
   
      $id_hacienda = $this->Inicio_m->get_id_vendedor(array(
         'vendedor' => 'hacienda', 
         'id_usuario' => $this->session->userdata('id_usuario')
      ));
      if ($id_hacienda and !empty($id_hacienda)) {
         $id_hacienda = $id_hacienda[0]->id_hacienda;
         $ventas = $this->Estadisticas_m->count_ventas($id_hacienda);
         $valid['total_ventas'] = $ventas[0]->total;
         $visitas = $this->Estadisticas_m->count_visitas($id_hacienda);
         $valid['total_visitas'] = $visitas[0]->total;
         $kits = $this->Estadisticas_m->count_kits($id_hacienda);
         $valid['total_kits'] = $kits[0]->total;
      } 
      else {
         # code...
      }
      // echo '<pre>';
      // print_r($ventas); exit();
      return $valid;
      
   }

   private function get_header() {
      $base_url['url'] = base_url();
      return $this->load->view('includes/header',$base_url);
   }

   private function menu() {

      if ($this->session->userdata('login')) {
         $data['rol'] = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
         $data['avatar'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
         $data['avatar'] = $data['avatar'][0]->avatar;
         $data['correo'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
      $data['correo'] = $data['correo'][0]->correo;
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
                     $data['admin'] = '1';
                    $data['color_1'] = 'c-admin';
                    $data['color_2'] = 'c-admin-50';
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
         return $data;
      
      } 
      else {
         return false;
      }

    }

}
