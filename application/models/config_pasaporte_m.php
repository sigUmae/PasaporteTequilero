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

    public function ya_visitada($id_hacienda) {
    
        return $this->db
            ->select('info_compra.*')
            ->join('visitas','visitas.id_pasaporte = info_compra.id_pasaporte AND visitas.id_hacienda != "'.$id_hacienda.'"','right')
            ->where('info_compra.tipo_pago = "Pagado" AND info_compra.status="1"')
            ->group_by('info_compra.id')
            ->get('info_compra')
            ->result();
    }

// SELECT hacienda.hacienda, count(info_compra.id)*50 as comision 
// FROM info_compra 
// JOIN hacienda 
// ON info_compra.id_hacienda = hacienda.id 
// AND info_compra.id_hacienda = '1'
// AND info_compra.status_comision = '1'

    public function comision_status($id_vendedor,$vendedor,$status) { 
        return $this->db
                    ->select('count(*) as pasaportes')
                    ->get_where('info_compra',array($vendedor => $id_vendedor, 'status_comision' => $status))
                    ->result();        
    }

    public function comision_efectivo($id_vendedor,$vendedor,$status) { 

        return $this->db
                    ->select('count(*) as compra')
                    ->get_where('info_compra',array($vendedor => $id_vendedor, 'efectivo_tarjeta' => $status))
                    ->result();        
    }

    public function comisiones_aliado($vendedor,$id_vendedor) {

        return $this->db
                    ->select('aliado.aliado as vendedor, count(info_compra.id) as comision')
                    ->join('aliado','info_compra.'.$vendedor.' = aliado.id AND info_compra.'.$vendedor.' = "'.$id_vendedor.'" AND info_compra.status_comision = "1"')
                    ->get('info_compra')
                    ->result();        

    }

    public function total_comisiones_h($vendedor,$id_vendedor) {
    
        return $this->db
                    ->select('hacienda.hacienda as vendedor, count(info_compra.id) as comision, hacienda.id as id_vendedor, info_compra.tipo_pago as tipo_pago')
                    ->join('hacienda','info_compra.'.$vendedor.' = hacienda.id AND info_compra.'.$vendedor.' = "'.$id_vendedor.'"')
                    ->get('info_compra')
                    ->result();   
        
    }

    public function total_comisiones_a($vendedor,$id_vendedor) {

        return $this->db
                    ->select('aliado.aliado as vendedor, count(info_compra.id) as comision, aliado.id as id_vendedor, info_compra.tipo_pago as tipo_pago')
                    ->join('aliado','info_compra.'.$vendedor.' = aliado.id AND info_compra.'.$vendedor.' = "'.$id_vendedor.'"')
                    ->get('info_compra')
                    ->result();        

    }

    public function reporte_visitas($fecha="= CURDATE()") {
    
        return $this->db
                    ->select('*, visitas.fecha AS fecha_visita')
                    ->join('visitas','info_compra.id_pasaporte = visitas.id_pasaporte AND DATE(visitas.fecha) '.$fecha)
                    // ->join('hacienda','hacienda.id = visitas.id_hacienda')
                    ->group_by('info_compra.id')
                    ->get('info_compra')
                    ->result();
        // CURDATE() hoy
        // DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(visitas.fecha) < CURDATE() ayer
        // DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)
    }
    
    public function reporte_ventas($fecha="= CURDATE()") {
    
        return $this->db
                    ->where('DATE(info_compra.fecha) '.$fecha)
                    ->get('info_compra')
                    ->result();
        
    }

    public function visita_hacienda($id_pasaporte) {
    
        return $this->db
                    ->join('visitas','info_compra.id_pasaporte = visitas.id_pasaporte AND visitas.id_pasaporte = '.$id_pasaporte)
                    ->join('hacienda','visitas.id_hacienda = hacienda.id')
                    ->group_by('hacienda.id')
                    ->get('info_compra')
                    ->result();
        
    }

}