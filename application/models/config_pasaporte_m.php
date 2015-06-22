<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_pasaporte_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    public function estado_p() {
        return $this->db
                    ->join('estado_pasaporte','p_tequilero.estado = estado_pasaporte.id')
                    ->get('p_tequilero')
                    ->result();
    }

    public function estado_p_($hacienda="") {
        return $this->db
                    ->join('estado_pasaporte','p_tequilero.estado = estado_pasaporte.id AND '.$hacienda.' = "0"')
                    ->get('p_tequilero')
                    ->result();
    }

    public function last_id($tabla="usuarios") {
    
        return $this->db
                    ->order_by('id','desc')
                    ->limit('1')
                    ->get($tabla)
                    ->result();
        
    }

    public function comision_status($id_vendedor,$vendedor,$status) { 
        return $this->db
                    ->select('count(*) as pasaportes')
                    ->get_where('info_compra',array($vendedor => $id_vendedor, 'status_comision' => $status, 'status' => '1'))
                    ->result();        
    }

    public function comision_efectivo($id_vendedor,$vendedor,$status) { 

        return $this->db
        	->select('count(*) as compra')
                ->get_where('info_compra',array($vendedor => $id_vendedor, 'efectivo_tarjeta' => $status, 'status' => '1'))
                ->result();        
    }

    public function comisiones_aliado($vendedor,$id_vendedor) {

        return $this->db
        	->select('aliado.aliado as vendedor, count(info_compra.id) as comision')
                ->join('aliado','info_compra.'.$vendedor.' = aliado.id AND info_compra.'.$vendedor.' = "'.$id_vendedor.'" AND info_compra.status_comision = "1" AND status = "1"')
        	->get('info_compra')
                ->result();        

    }

    public function total_comisiones_h($vendedor,$id_vendedor) {
    
        return $this->db
                    ->select('hacienda.hacienda as vendedor, count(info_compra.id) as comision, hacienda.id as id_vendedor, info_compra.tipo_pago as tipo_pago')
                    ->join('hacienda','info_compra.'.$vendedor.' = hacienda.id AND info_compra.'.$vendedor.' = "'.$id_vendedor.'" AND info_compra.status_comision = "1"')
                    ->get('info_compra')
                    ->result();   
        
    }

    public function total_comisiones_a($vendedor,$id_vendedor) {

        return $this->db
                    ->select('aliado.aliado as vendedor, count(info_compra.id) as comision, aliado.id as id_vendedor, info_compra.tipo_pago as tipo_pago')
                    ->join('aliado','info_compra.'.$vendedor.' = aliado.id AND info_compra.'.$vendedor.' = "'.$id_vendedor.'" AND info_compra.status_comision = "1"')
                    ->get('info_compra')
                    ->result();        

    }

    public function reporte_visitas($fecha="= CURDATE()") {
    
        return $this->db
                    ->select('*, visitas.fecha AS fecha_visita')
                    ->join('visitas','info_compra.id_pasaporte = visitas.id_pasaporte AND info_compra.status = "1" AND DATE(visitas.fecha) '.$fecha)
                    ->group_by('info_compra.id')
                    ->get('info_compra')
                    ->result();
    }
    
    public function reporte_ventas($fecha="= CURDATE()") {
    
        return $this->db
                    ->where('status = "1" AND DATE(info_compra.fecha) '.$fecha)
                    ->get('info_compra')
                    ->result();
        
    }

    public function visita_hacienda($id_pasaporte) {
    
        return $this->db
                    ->join('visitas','info_compra.id_pasaporte = visitas.id_pasaporte AND visitas.id_pasaporte = '.$id_pasaporte)
                    ->join('hacienda','visitas.id_hacienda = hacienda.id AND status = "1"')
                    ->group_by('hacienda.id')
                    ->get('info_compra')
                    ->result();
        
    }

}