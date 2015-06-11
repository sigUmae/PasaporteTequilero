<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    public function fechas($condicion) {
    
      return $this->db
        ->select('DAY(info_compra.fecha) AS dia, MONTH(info_compra.fecha) AS mes, YEAR(info_compra.fecha) AS year')
        ->get_where('info_compra',$condicion)
        ->result();
      
    }
    
    public function get_rol($id_usuario=false) {
        if ($id_usuario) {
            return $this->db
              ->join('roles','id_rol = roles.id AND usuarios.id = '.$id_usuario.'')
              ->get('usuarios')
              ->result();
        }    
        else { 
            return false;
        }
    }
    
    public function count_web($fecha='= CURDATE()') {
    
      return $this->db
        ->select('count(info_compra.id_web) AS data')
        ->where('DATE(fecha) '.$fecha.' AND status ="1" AND id_web="1"')
        ->get('info_compra')
        ->result();
    }

    public function comision_day($day,$vendedor,$id_vendedor,$con_vendedor='') {
    
      return $this->db
        ->select('count(*) AS pasaportes')
        ->join('info_compra','fecha_comision.id_pasaporte = info_compra.id_pasaporte AND info_compra.id_'.$vendedor.' = "'.$id_vendedor.'" AND info_compra.status_comision = "2"')
        ->where('info_compra.status = "1" AND DATE(fecha_comision.fecha) = DATE_SUB(CURDATE(),INTERVAL '.$day.' DAY) '.$con_vendedor)
        ->get('fecha_comision')
        ->result();

    }


    public function count_days($day,$tabla,$status="1",$con_vendedor="") {
    
        return $this->db
          ->select('count(*) AS pasaportes')
          ->where('DATE(fecha) = DATE_SUB(CURDATE(),INTERVAL '.$day.' DAY) AND status = "'.$status.'" '.$con_vendedor)
          ->get($tabla)
          ->result();
      
    }

    public function count_days_kit($day,$status="2",$con_vendedor="") {
    
        return $this->db
          ->select('count(*) AS pasaportes')
          ->where('DATE(fecha_entrega) = DATE_SUB(CURDATE(),INTERVAL '.$day.' DAY) AND status = "'.$status.'" '.$con_vendedor)
          ->get('kit')
          ->result();
      
    }

    public function get_id_vendedor($condicion) {
    
      return $this->db
        ->join($condicion['vendedor'],'usuarios.id_'.$condicion['vendedor'].' = '.$condicion['vendedor'].'.id AND usuarios.id = "'.$condicion['id_usuario'].'"')
        ->get('usuarios')
        ->result();
      
    }

    public function count_pasaportes($condicion=false,$fecha = '= CURDATE()') { 
        if ($condicion) {
          return $this->db
            ->select('count(*) AS pasaportes')
            ->where('DATE(fecha) '.$fecha)
            ->get_where('info_compra',$condicion)
            ->result();
        } 
        else {
          return false;
        }
    }

    public function count_by_vendedor($vendedor=false,$fecha='= CURDATE()') {
      if ($vendedor) {
        return $this->db
          ->select('count(info_compra.id_'.$vendedor.') AS data, '.$vendedor.'.'.$vendedor.' AS label')
          ->join($vendedor,'info_compra.id_'.$vendedor.' = '.$vendedor.'.id')
          ->where('info_compra.status = "1" and DATE(fecha) '.$fecha)
          ->group_by('info_compra.id_'.$vendedor)
          ->get('info_compra')
          ->result();
      } 
      else {
        return false;
      }
    }

}