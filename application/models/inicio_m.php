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

}