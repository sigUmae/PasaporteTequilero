<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio_m extends CI_Model {

    function __construct(){
        parent::__construct();
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

    // DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(visitas.fecha) < CURDATE()

    public function count_days($day,$tabla,$status="1") {
    
        return $this->db
          ->select('count(*) AS pasaportes')
          ->where('DATE(fecha) = DATE_SUB(CURDATE(),INTERVAL '.$day.' DAY) AND status = "'.$status.'"')
          ->get($tabla)
          ->result();
      
    }

    public function get_id_vendedor($condicion) {
    
      // SELECT * FROM usuarios JOIN hacienda ON usuarios.id_hacienda = hacienda.id AND usuarios.id = '9'
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
          ->where('DATE(fecha) '.$fecha)
          ->group_by('info_compra.id_'.$vendedor)
          ->get('info_compra')
          ->result();
      } 
      else {
        return false;
      }
    }

}