<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    public function filas_condicion($tabla=false, $donde=false){
        if ($tabla || $donde)
            return $this->db->get_where($tabla, $donde)->result();
        else 
            return false;
    }
    public function filas($tabla=false){
        if ($tabla)
            return $this->db->get($tabla)->result(); 
        else
            return false;
    }

    public function insert($tabla=false, $datos=false){
        if ($tabla || $datos)
           $this->db->insert($tabla, $datos);
        else
            return false;
    }
    public function update($tabla=false, $datos=false, $condiciones=false ){
        if ($tabla || $datos || $condiciones)
            $this->db->update($tabla, $datos, $condiciones);
        else
            return false;
    }
    
}