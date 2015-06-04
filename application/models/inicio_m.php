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

    public function count_pasaportes($condicion=false) { 
        if ($condicion) {
          return $this->db
            ->select('count(*) AS pasaportes')
            ->get_where('info_compra',$condicion)
            ->result();
        } 
        else {
          return false;
        }
    }

    public function count_by_vendedor($vendedor=false) {
      if ($vendedor) {
        return $this->db
          ->select('count(info_compra.id_'.$vendedor.') AS data, '.$vendedor.'.'.$vendedor.' AS label')
          ->join($vendedor,'info_compra.id_'.$vendedor.' = '.$vendedor.'.id')
          ->group_by('info_compra.id_'.$vendedor)
          ->get('info_compra')
          ->result();
      } 
      else {
        return false;
      }
    }

}