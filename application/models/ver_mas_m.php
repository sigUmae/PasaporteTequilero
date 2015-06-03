<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ver_mas_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    public function visitas($id_pasaporte,$id_hacienda) {
    	
    	return $this->db
    				->select('visitas.id_hacienda')
    				->join('visitas','info_compra.id_pasaporte = visitas.id_pasaporte AND visitas.id_hacienda = "'.$id_hacienda.'" AND info_compra.id_pasaporte = "'.$id_pasaporte.'"')
 					->limit('1')
 					->get('info_compra')
 					->result();   	

    }	

}