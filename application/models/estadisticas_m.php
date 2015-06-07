<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estadisticas_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }

   public function count_ventas($id_hacienda,$fecha=' = CURDATE()') {
      return $this->db
         ->select('COUNT(*) AS total')
         ->where('tipo_pago = "Pagado" AND id_hacienda = "'.$id_hacienda.'" AND DATE(fecha) '.$fecha)
         ->get('info_compra')
         ->result();
   }    

   public function count_visitas($id_hacienda,$fecha=' = CURDATE()') {
      return $this->db
         ->select('COUNT(*) AS total')
         ->where('id_hacienda = "'.$id_hacienda.'" AND DATE(fecha) '.$fecha)
         ->get('visitas')
         ->result();
   }

   public function count_kits($id_hacienda,$fecha=' = CURDATE()') {
      return $this->db
         ->select('COUNT(*) AS total')
         ->where('id_hacienda = "'.$id_hacienda.'" AND DATE(fecha_entrega) '.$fecha)
         ->get('kit')
         ->result();
   }

}