<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_m extends CI_Model {

    function __construct(){
        parent::__construct();
    }
    
    public function validar($tabla=false, $donde=false, $or_=false) {
        if ($tabla || $donde || $or_)
            return $this->db
                        ->where($donde)
                        ->or_where($or_)
                        ->get($tabla)
                        ->result();    
        else 
            return false;
    }
    
}