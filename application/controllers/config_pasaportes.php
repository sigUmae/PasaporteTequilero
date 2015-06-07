<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_pasaportes extends CI_Controller {

	function __construct() {

        parent::__construct();
        $this->load->model(array('Inicio_m','Config_pasaporte_m'));
        $this->load->library('My_PHPMailer');
        $this->load->library('Payu_lib');

    }

    public function index() {

        redirect('inicio/index');

    }

    private function pay_payu($datos) {
    
        $reference = $datos['referencia'];
        $value = "821";
        try {
            $parameters = array(
                PayUParameters::ACCOUNT_ID => "535213",
                PayUParameters::REFERENCE_CODE => $reference,
                PayUParameters::DESCRIPTION => "Pasaporte tequilero",
                PayUParameters::VALUE => $value,
                PayUParameters::CURRENCY => "MXN",
                PayUParameters::BUYER_NAME => $datos['buyer_name'], 
                PayUParameters::BUYER_EMAIL =>  $datos['buyer_email'], 
                PayUParameters::BUYER_CONTACT_PHONE =>  $datos['telefono'],
                PayUParameters::BUYER_DNI => $datos['dni'],
                PayUParameters::BUYER_STREET =>  $datos['domicilio'],
                PayUParameters::BUYER_STREET_2 => $datos['domicilio'], 
                PayUParameters::BUYER_CITY =>  $datos['ciudad'],
                PayUParameters::BUYER_STATE =>  $datos['estado'],
                PayUParameters::BUYER_COUNTRY =>  $datos['pais'], 
                PayUParameters::BUYER_POSTAL_CODE => $datos['cp'], 
                PayUParameters::BUYER_PHONE =>  $datos['telefono'],
                PayUParameters::PAYER_NAME => $datos['buyer_name'],
                PayUParameters::PAYER_EMAIL => $datos['buyer_email'], 
                PayUParameters::PAYER_CONTACT_PHONE =>  $datos['telefono'], 
                PayUParameters::PAYER_DNI => $datos['dni'],
                PayUParameters::PAYER_STREET => $datos['domicilio'],
                PayUParameters::PAYER_STREET_2 => $datos['domicilio'],
                PayUParameters::PAYER_CITY => $datos['ciudad'],
                PayUParameters::PAYER_STATE => $datos['estado'],
                PayUParameters::PAYER_COUNTRY => $datos['pais'], 
                PayUParameters::PAYER_POSTAL_CODE => $datos['cp'], 
                PayUParameters::PAYER_PHONE => $datos['telefono'], 
                PayUParameters::CREDIT_CARD_NUMBER => $datos['num_tarjeta'],
                PayUParameters::CREDIT_CARD_EXPIRATION_DATE => $datos['f_expiracion_input'],
                PayUParameters::CREDIT_CARD_SECURITY_CODE=> $datos['c_seguridad'],
                PayUParameters::INSTALLMENTS_NUMBER => "1", 
                PayUParameters::COUNTRY => PayUCountries::MX,
                PayUParameters::DEVICE_SESSION_ID => "vghs6tvkcle931686k1900o6e1",
                PayUParameters::IP_ADDRESS => "127.0.0.1",
                PayUParameters::PAYER_COOKIE=>"pt1t38347bs6jc9ruv2ecpv7o2",
                PayUParameters::USER_AGENT=>"Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0"
            );
             switch ($datos['tarjeta']) {
                case '1': // VISA
                    $parameters[PayUParameters::PAYMENT_METHOD] = PaymentMethods::VISA;
                    break;
                case '2': // MASTERCARD
                    $parameters[PayUParameters::PAYMENT_METHOD] = PaymentMethods::MASTERCARD;
                    break;
            }  
            $response = PayUPayments::doAuthorizationAndCapture($parameters);
            if ($response) {
                return $response;  
            } 
        }
        catch (PayUException $e)
        {
            print_r($e->getMessage());
        }
    }


    public function pagar_comision() {
    
        $id_pasaporte = $this->input->post('id_pasaporte',true);
        $ajax_request = $this->input->is_ajax_request();
        if ($id_pasaporte and $ajax_request) {
            $existe = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $id_pasaporte));
            if (!empty($existe)) {
                // $id_vendedor
                $this->Master_m->update('info_compra',array('status_comision' => '2'),array('id_pasaporte' => $id_pasaporte));
                $this->Master_m->insert('fecha_comision',array('id_pasaporte' => $id_pasaporte)); 
                echo 'Hecho';
            } 
            else {
                echo 'Pasaporte no encontrado';
            }
         } 
         else {
             echo 'Ha ocurrido un error';
         }
          
        
    }

    public function comisiones() {
    
        $valid = $this->menu();
        $tipo = $this->input->get('tipo',true); 
        $id_hacienda = $this->input->get('id',true);
        if ($tipo and $tipo) {
            $vendedor_ = array('1' => 'hacienda', '2' => 'aliado');
            $vendedor_ha = $this->Master_m->filas($vendedor_[$tipo]);
            $existe = false;
            foreach ($vendedor_ha as $vendedor) {
                if (md5($vendedor->id) == $id_hacienda) {
                    $id_hacienda = $vendedor->id;
                    $existe = true;
                    break;
                }
            }
            if ($existe) {
                $estado_compra = array('Pagado ' => '1', 'En proceso' => '2');
                $valid['pasaportes'] = $this->Master_m->filas_condicion('info_compra',array('id_'.$vendedor_[$tipo] => $id_hacienda));
                foreach ($valid['pasaportes'] as $key => $value) {
                    if ($value->tipo_pago == 'Pagado') {
                        $valid['pasaportes'][$key]->efectivo = '1'; // Efectivo
                    }
                    else if ($value->tipo_pago == 'En proceso') {

                        $valid['pasaportes'][$key]->efectivo = '2'; // En proceso
                    }
                }
                $this->load->view('config_pasaportes/comision_v',$valid);
            }
            else {
                redirect('config_pasaportes/comisiones');
            }
        } 
        else if(!$tipo and !$tipo) {
            $valid['comisiones'] = $this->comision_por_vendedor();

            $this->load->view('config_pasaportes/comisiones_v',$valid);   
        }
        
    }

    private function comision_vendedor($condiciones) {
    
        $pasaportes = $this->Master_m->filas_condicion('info_compra',$condiciones);
        
    }

    private function comision_por_vendedor() {
    
        $haciendas = $this->Master_m->filas('hacienda');
        $aliado = $this->Master_m->filas('aliado');
        foreach ($haciendas as $key => $value) {
            $comision_vendedor[] = $this->get_comision('id_hacienda',$value->id);
            if (!empty($comision_vendedor[$key])) {
                $no_pagado = $this->Config_pasaporte_m->comision_status($value->id,'id_hacienda','1');
                $efectivo = $this->Config_pasaporte_m->comision_efectivo($value->id,'id_hacienda','1'); // tipo pago
                $tarjeta = $this->Config_pasaporte_m->comision_efectivo($value->id,'id_hacienda','2');
                $comision_vendedor[$key]['no_pagado'] = $no_pagado[0]->pasaportes;
                $comision_vendedor[$key]['pagado'] = $efectivo[0]->compra;
                $comision_vendedor[$key]['efectivo'] = $tarjeta[0]->compra;
            }
        }
        $total = count($comision_vendedor);
        foreach ($aliado as $key => $value) {
            $comision_vendedor[] = $this->get_comision('id_aliado',$value->id);
            if (!empty($comision_vendedor[$total+$key])) {
                $no_pagado = $this->Config_pasaporte_m->comision_status($value->id,'id_aliado','1');
                $efectivo = $this->Config_pasaporte_m->comision_efectivo($value->id,'id_aliado','1'); // tipo pago
                $tarjeta = $this->Config_pasaporte_m->comision_efectivo($value->id,'id_aliado','2');
                $comision_vendedor[$total+$key]['no_pagado'] = $no_pagado[0]->pasaportes;
                $comision_vendedor[$total+$key]['pagado'] = $efectivo[0]->compra;
                $comision_vendedor[$total+$key]['efectivo'] = $tarjeta[0]->compra;
            }
        }
        return $comision_vendedor;
    }

    private function get_comision($vendedor,$id) {

        if ($vendedor == 'id_hacienda') {
            $comision_vendedor = $this->Config_pasaporte_m->total_comisiones_h($vendedor,$id);
            $tipo_vendedor = '1'; // Hacienda
        } 
        else {
            $comision_vendedor = $this->Config_pasaporte_m->total_comisiones_a($vendedor,$id);
            $tipo_vendedor = '2'; // Aliado
        }
        $estado_pago = array(null => '0', 'En proceso' => '1', 'Pagado' => '2');
        $comisiones = array(
            'vendedor' => $comision_vendedor[0]->vendedor, 
            'comision' => $comision_vendedor[0]->comision,
            'id_vendedor' => $comision_vendedor[0]->id_vendedor,
            'tipo' => $tipo_vendedor,
            'estado_pago' => $estado_pago[$comision_vendedor[0]->tipo_pago]
        );
        return $comisiones;
        
    }

    public function reportes() {

    	$valid = $this->menu();
    	$rol = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
    	$rol = $rol[0]->id_rol;
    	if ($valid and ($rol == 1 || $rol == 2)) {
    		switch ($rol) {
    			case 1:
    				// $this->tabla_reportes();
    				// $this->load->view('config_pasaportes/reportes_v',$valid);
    				break;	
    			case 2:
    				$this->load->view('config_pasaportes/ventas_v',$valid);
    				break;
    		}
    	} 
    	else {
    		redirect('login/index');
    	}

    }

    public function visitas() {

    	$valid = $this->menu();
    	$rol = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
    	$rol = $rol[0]->id_rol;
    	if ($valid and ($rol == 1 || $rol == 2 || $rol == 3)) {
    		switch ($rol) {
    			case 1:
                    $valid['pasaportes'] = $this->Config_pasaporte_m->reporte_visitas();
                    $valid = $this->visita_hacienda($valid);
    				$this->load->view('config_pasaportes/reportes_visitas_v',$valid);
    				break;	
    			case 2:
                    $valid['pasaportes'] = $this->Master_m->filas_condicion('info_compra',array(
                        // $vendedor.' !=' => '0',
                        // $vendedor => $id_hacienda,
                        'tipo_pago'=> 'Pagado',
                        'status' => '1'
                    ));
                    $valid['pasaportes'] = $this->visitas_($valid);
    				$this->load->view('config_pasaportes/registro_visita_v',$valid);
    				break;
                case 3:
                    $valid['pasaportes'] = $this->visitas_('id_aliado');
                    $this->load->view('config_pasaportes/registro_visita_v',$valid);
                    break;
    		}
    	} 
    	else {
    		redirect('login/index');
    	}

    }

    private function visita_hacienda($valid) {

        foreach ($valid['pasaportes'] as $key => $value_v) {
            if ($value_v->sauza == 0) {
                $valid['pasaportes'][$key]->sauza = 'haciendas-sauza-gris.jpg';
            } 
            else {
                $valid['pasaportes'][$key]->sauza = 'haciendas-sauza.jpg';
            }
            if ($value_v->herradura == 0) {
                $valid['pasaportes'][$key]->herradura = 'haciendas-herradura-gris.jpg';
            } 
            else {
                $valid['pasaportes'][$key]->herradura = 'haciendas-herradura.jpg';
            }
            if ($value_v->cofradia == 0) {
                $valid['pasaportes'][$key]->cofradia = 'haciendas-cofradia-gris.jpg';
            } 
            else {
                $valid['pasaportes'][$key]->cofradia = 'haciendas-cofradia.jpg';
            }
        }
        return $valid;

    }

    public function rango_fechas() {
    
        $rango1 = $this->input->get('rango_visitas',true);
        $rango2 = $this->input->get('rango_ventas',true);
        if ($rango1 || $rango2) {
            $tipos_rango = array(
                'hoy' => '= CURDATE()',
                // 'ayer' => '>= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(visitas.fecha) < CURDATE()',
                'mes' => '>= DATE_SUB(CURDATE(), INTERVAL DAYOFMONTH(CURDATE())-1 DAY)'
            );
            if ($rango1 and $rango1 == 'ayer') {
                $tipos_rango['ayer'] = '>= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(visitas.fecha) < CURDATE()';
            } 
            else {
                $tipos_rango['ayer'] = '>= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND DATE(info_compra.fecha) < CURDATE()';
            }
            if ($rango1 == 'entre' || $rango2 == 'entre') {
                $fecha1 = $this->input->get('fecha1',true);
                $fecha2 = $this->input->get('fecha2',true);
                if ($rango1) {
                    $tipos_rango['entre'] = '>= "'.$fecha1.'" AND DATE(visitas.fecha) <= "'.$fecha2.'"';
                } 
                else {
                    $tipos_rango['entre'] = '>= "'.$fecha1.'" AND DATE(info_compra.fecha) <= "'.$fecha2.'"';
                }   
            } 
            if ($rango1 == 'fecha' || $rango2 == 'fecha') {
                $fecha1 = $this->input->get('fecha1',true);
                $tipos_rango['fecha'] = ' = "'.$fecha1.'"';
            }
            $valid = $this->menu();
            if ($rango1) {
                $valid['pasaportes'] = $this->Config_pasaporte_m->reporte_visitas($tipos_rango[$rango1]);
                $valid = $this->visita_hacienda($valid);
                $this->load->view('config_pasaportes/reportes_visitas_v',$valid);
            } 
            else {
                $valid['pasaportes'] = $this->Config_pasaporte_m->reporte_ventas($tipos_rango[$rango2]);
                $valid = $this->kit($valid);
                $this->load->view('config_pasaportes/reportes_ventas_a_v',$valid);
            }
        } 
        else {

        }
        
    }

    private function visitas_($valid) {

        $kits = $this->Master_m->filas('kit');
        foreach ($valid['pasaportes'] as $key => $value_v) {
            $valid['pasaportes'][$key]->kit = '0';
            foreach ($kits as $kit) {
                if ($value_v->id_pasaporte == $kit->id_pasaporte and $kit->status == '1') {
                    $valid['pasaportes'][$key]->kit = '1';
                } 
                else if ($value_v->id_pasaporte == $kit->id_pasaporte and $kit->status == '2') {
                    $valid['pasaportes'][$key]->kit = '2';
                }
            }
        }
        return $valid['pasaportes'];
        
    }

    public function ventas() {

    	$valid = $this->menu();
    	$rol = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
    	$rol = $rol[0]->id_rol;
        $action = $this->input->get('action',true);
    	if ($valid and ($rol == 1 || $rol == 2 || $rol == 3)) {
            if ($action and $action == 'venta') {
        		switch ($rol) {
                    case 1:
                        redirect('inicio/index');
                        break;
        			case 2:
                        $valid['vendedor'] = 'Hacienda';
                        $valid['n_vendedor'] = $this->get_ha($this->session->userdata('id_usuario'),'hacienda');
        				$this->load->view('config_pasaportes/ventas_v',$valid);
        				break;
                    case 3:
                        $valid['vendedor'] = 'Aliado';
                        $valid['n_vendedor'] = $this->get_ha($this->session->userdata('id_usuario'),'aliado');
                        $this->load->view('config_pasaportes/ventas_v',$valid);
                        break;
        		}
            }
            else {
                switch ($rol) {
                    case 1:
                        $valid['pasaportes'] = $this->Master_m->filas('info_compra');
                        $valid = $this->kit($valid);
                        $this->load->view('config_pasaportes/reportes_ventas_a_v',$valid);
                        break;
                    case 2:
                        $valid['ventas_'] = $this->get_ha_('id_hacienda',$this->session->userdata('id_usuario'));
                        $this->load->view('config_pasaportes/reporte_ventas_v',$valid);
                        break;
                    case 3:
                        $valid['ventas_'] = $this->get_ha_('id_aliado',$this->session->userdata('id_usuario'));
                        $this->load->view('config_pasaportes/reporte_ventas_v',$valid);
                        break;
                }
            }
    	} 
    	else {
    		redirect('login/index');
    	}

    }

    public function kit_() {
    
        $id_pasaporte = $this->input->post('id_pasaporte',true);
        $ajax_request = $this->input->is_ajax_request();
        if ($id_pasaporte and $ajax_request) {
            $id_hacienda = $this->Inicio_m->get_id_vendedor(array(
                'vendedor' => 'hacienda', 
                'id_usuario' => $this->session->userdata('id_usuario')
            ));
            if (!empty($id_hacienda)) {
                $id_hacienda = $id_hacienda[0]->id_hacienda;
                $this->Master_m->update('kit',array(
                    'status' => '2', 
                    'id_hacienda' => $id_hacienda,
                    'fecha_entrega' => date('Y-m-d H:i:s')
                    ),array(
                        'id_pasaporte' => $id_pasaporte, 
                        'status' => '1'
                    )
                );
                echo 'Kit agregado';
            }
            else {
                echo 'Hacienda no encontrada';
            }
        } 
        else {
            echo 'Ha ocurrido un error';
        }
        
    }

    private function kit($valid) {
    
        $kits = $this->Master_m->filas('kit');
        foreach ($valid['pasaportes'] as $key => $value_v) {
            if ($value_v->sauza == 0) {
                $valid['pasaportes'][$key]->sauza = 'haciendas-sauza-gris.jpg';
            } 
            else {
                $valid['pasaportes'][$key]->sauza = 'haciendas-sauza.jpg';
            }
            if ($value_v->herradura == 0) {
                $valid['pasaportes'][$key]->herradura = 'haciendas-herradura-gris.jpg';
            } 
            else {
                $valid['pasaportes'][$key]->herradura = 'haciendas-herradura.jpg';
            }
            if ($value_v->cofradia == 0) {
                $valid['pasaportes'][$key]->cofradia = 'haciendas-cofradia-gris.jpg';
            } 
            else {
                $valid['pasaportes'][$key]->cofradia = 'haciendas-cofradia.jpg';
            }
            $valid['pasaportes'][$key]->kit = '0';
            foreach ($kits as $kit) {
                if ($value_v->id_pasaporte == $kit->id_pasaporte and $kit->status == '1') {
                    $valid['pasaportes'][$key]->kit = '1';
                } 
                else if ($value_v->id_pasaporte == $kit->id_pasaporte and $kit->status == '2') {
                    $valid['pasaportes'][$key]->kit = '2';
                }
            }
        }
        return $valid;
        
    }

    private function get_ha_($vendedor,$id_usuario) {
    
        $id_vendedor = $this->Master_m->filas_condicion('usuarios',array('id' => $id_usuario));

        if (!empty($id_vendedor)) {
            switch ($vendedor) {
                case 'id_hacienda':
                    $id_vendedor = $id_vendedor[0]->id_hacienda;
                    break;
                case 'id_aliado':
                    $id_vendedor = $id_vendedor[0]->id_aliado;
                    break;
            }
            return $this->Master_m->filas_condicion('info_compra',array($vendedor => $id_vendedor));
        }
        else {

        }
        
    }

    private function get_ha($id_usuario,$vendedor) {
    
        $id_vendedor = $this->Master_m->filas_condicion('usuarios',array('id' => $id_usuario));

        if (!empty($id_vendedor)) {
            switch ($vendedor) {
                case 'hacienda':
                    $id_vendedor = $id_vendedor[0]->id_hacienda;
                    break;
                case 'aliado':
                    $id_vendedor = $id_vendedor[0]->id_aliado;
                    break;
            }
            $vendedor_ = $this->Master_m->filas_condicion($vendedor,array('id' => $id_vendedor));
            switch ($vendedor) {
                case 'hacienda':
                    return $vendedor_[0]->hacienda;
                case 'aliado':
                    return $vendedor_[0]->aliado;
            }
        } 
        else {
            return false;
        }
        
    }

    public function id_pasaporte() {
    
        $ajax_request =  $this->input->is_ajax_request();
        if ($ajax_request) {
            $venta = $this->Config_pasaporte_m->last_id('info_compra');
            echo $venta[0]->id+1;
        } 
        else {
            # code...
        }
        
    }

    public function info_pasaporte() {

    	$pasaporte = $this->input->post('pasaporte',true);
    	$ajax_request =  $this->input->is_ajax_request();

    	if ($ajax_request and $pasaporte) {
    		$pertenece = $this->Master_m->filas_condicion('p_tequilero',array('id' => $pasaporte));
    		if (!empty($pertenece)) {
    			echo $pertenece[0]->pertenece;
    		}
    		else echo 'No encontrado';
    	}

    }

    public function realizar_venta() {

    	$id_pasaporte = $this->input->post('id_pasaporte',true);
        $vendedor = $this->input->post('vendedor',true);
        $n_vendedor = $this->input->post('n-vendedor',true);
        $propietario = $this->input->post('propietario',true);
        $pago = $this->input->post('pago',true);
        $telefono = $this->input->post('telefono',true);
        $correo = $this->input->post('correo',true);
    	$domicilio = $this->input->post('domicilio',true);
        $ajax_request =  $this->input->is_ajax_request();

        $dni = $this->input->post('dni',true);
        $ciudad = $this->input->post('ciudad',true);
        $estado = $this->input->post('estado',true);
        $pais = $this->input->post('pais',true);
        $cp = $this->input->post('cp',true);
        $num_tarjeta = $this->input->post('num_tarjeta',true);
        // $r_num_tarjeta = $this->input->post('r_num_tarjeta',true);
        $f_expiracion_input = $this->input->post('f_expiracion_input',true);
        $c_seguridad = $this->input->post('c_seguridad',true);
        $tarjeta = $this->input->post('tarjeta',true);
    	
        if ($ajax_request and 
            $vendedor and
            $id_pasaporte and 
            $propietario and 
            $pago and
            $n_vendedor) {

            $this->form_validation->set_rules('id_pasaporte','ID pasaporte','required|integer|is_unique[info_compra.id]');
            $this->form_validation->set_rules('vendedor','Hacienda/aliado','required');
            $this->form_validation->set_rules('n-vendedor','Vendedor','required');
            $this->form_validation->set_rules('propietario','Propietario','required|min_length[4]|max_length[128]');
            $this->form_validation->set_rules('pago','Pago','required|integer');

            if ($pago == '1') { // efectivo
                $this->form_validation->set_rules('telefono','Teléfono','integer');
                $this->form_validation->set_rules('correo','Correo','is_unique[info_compra.correo]|valid_email');
            }
            else if($pago == '2') { // tarjeta
                if ($dni and
                    $ciudad and
                    $estado and
                    $pais and
                    $cp and
                    $num_tarjeta and
                    // $r_num_tarjeta and
                    $f_expiracion_input and
                    $c_seguridad and
                    $tarjeta) {
                    $this->form_validation->set_rules('telefono','Teléfono','required|integer');
                    $this->form_validation->set_rules('correo','Correo','required|is_unique[info_compra.correo]|valid_email');
                    $this->form_validation->set_rules('domicilio','Domicilio','required');
                    $this->form_validation->set_rules('dni','DNI','required');
                    $this->form_validation->set_rules('ciudad','Ciudad','required');
                    $this->form_validation->set_rules('estado','Estado','required');
                    $this->form_validation->set_rules('pais','País','required');
                    $this->form_validation->set_rules('cp','Código Postal','required|integer'); // pendiente
                    $this->form_validation->set_rules('num_tarjeta','Número de tajeta','required|integer'); // pendiente
                    // $this->form_validation->set_rules('r_num_tarjeta','Repetir número de tajeta','required'); // pendiente
                    // $this->form_validation->set_rules('fecha_e_i','Fecha de expiración','required');
                } 
                else {
                    echo 'Error';
                    exit();
                }
            }
            else {
                echo 'Tipo de pago no válido';
                exit();
            }
            
            $this->form_validation->set_error_delimiters('','');
            
            if ($this->form_validation->run() == false) {
                echo validation_errors();
            }
            else {
                $existe = $this->Master_m->filas_condicion($n_vendedor,array($n_vendedor => $vendedor));
                if (!empty($existe)) {
                    $id_pasaporte = md5(rand());
                    $pa = '1';
                    if ($pago == '2') {
                        $this->init(true);
                        $response = PayUPayments::doPing();
                        if ($response->code == 'SUCCESS') {
                            // 260 VISA
                            // 261 MASTERCARD
                            $paymentMethods = array('1' => '260', '2' => '261');
                            $valido = $this->metodos_pago_activos($paymentMethods[$tarjeta]);
                            if ($valido) {
                                $referencia = md5(date("Y-m-d H:i:s").$id_pasaporte);
                                $datos = array(
                                    'buyer_name' => $propietario,
                                    'buyer_email' => $correo,
                                    'telefono' => $telefono,
                                    'dni' => $dni,
                                    'domicilio' => $domicilio,
                                    'ciudad' => $ciudad,
                                    'estado' => $estado,
                                    'pais' => 'MX',
                                    'cp' => $cp,
                                    'telefono' => $telefono,
                                    'num_tarjeta' => $num_tarjeta,
                                    'f_expiracion_input' => $f_expiracion_input,
                                    'c_seguridad' => $c_seguridad,
                                    'tarjeta' => $tarjeta,
                                    'referencia' => $referencia
                                );
                                $response = $this->pay_payu($datos);
                                if ($response->code == 'SUCCESS') {
                                    $info_venta = array();
                                    $state = $response->transactionResponse->state;
                                    switch ($state) {
                                        case 'DECLINED':
                                        case 'EXPIRED':
                                        case 'ERROR':
                                            print_r($response->transactionResponse->responseCode.' -');
                                            print_r($response->transactionResponse->responseMessage);
                                            exit();
                                            break;
                                        case 'PENDING':        
                                            print_r($response->transactionResponse->pendingReason.' - ');
                                            $pa = '2';
                                            break;
                                        case 'APPROVED':
                                            $pa = '1';
                                            break;
                                    }
                                    $info_venta = array(
                                        'order_id' =>  $response->transactionResponse->orderId,
                                        'transaction_id' =>  $response->transactionResponse->transactionId,
                                        // 'authorization_code' =>  $response->transactionResponse->authorizationCode,
                                        'id_pasaporte' =>  $id_pasaporte,
                                        'referencia' =>  $referencia
                                    );
                                    $this->Master_m->insert('info_tarjeta',$info_venta);
                               } 
                                else {
                                    echo 'Error con la tarjeta';
                                }
                            } 
                            else {
                                echo 'Servicio de pago de tarjeta PayU caído';
                                exit();
                            }
                            
                        }
                        else {
                            echo 'Servicio PayU caído';
                            exit();
                        }
                    }
                    $pago_ = array('1' => 'Pagado', '2' => 'En proceso');
                    $this->Master_m->insert('info_compra',array(
                        'propietario' => $propietario,
                        'id_'.$n_vendedor => $existe[0]->id,
                        'tipo_pago' => $pago_[$pa],
                        'telefono' => $telefono,
                        'correo' => $correo,
                        'domicilio' => $domicilio,
                        'id_pasaporte' => $id_pasaporte,
                        'vendedor' => $vendedor,
                        'efectivo_tarjeta' => $pago
                    ));
                    echo 'Hecho';
                } 
                else {
                    echo 'Vendedor no registrado'; // no existe vendedor  
                }
            }
    	}
    	else {
           echo 'Ha ocurrido un error'; // Error
        }

    }

    private function init($value) {
        
        Environment::setPaymentsCustomUrl('https://api.payulatam.com/payments-api/4.0/service.cgi');
        Environment::setReportsCustomUrl('https://api.payulatam.com/reports-api/4.0/service.cgi'); 
        Environment::setSubscriptionsCustomUrl('https://api.payulatam.com/payments-api/rest/v4.3/');
        PayU::$apiKey = '0A8OCq1iL6g9cTKAh4M9sis4t7';
        PayU::$apiLogin = 'R1gSWkk4uJ59TuH';
        PayU::$merchantId = '533273';
        PayU::$language = SupportedLanguages::ES;
        PayU::$isTest = $value;

    }

    private function metodos_pago_activos($payment=false) {

        // $response = PayUPayments::doPing();
        // if ($response->code == 'SUCCESS') {
            $array = PayUPayments::getPaymentMethods();
            $payment_methods = $array->paymentMethods;
            if ($payment) {
                foreach ($payment_methods as $payment_method) {
                    if ($payment_method->id == $payment) {
                       return true;
                    }
                }
                return false;
            } 
            else {
                return $payment_methods;
            }
        // } 
        // else {
        //     return false;
        // }
        
    }

    public function visitado() {

    	$pasaporte = $this->input->post('id_pasaporte',true);
        $ajax_request = $this->input->is_ajax_request();
    	if ($pasaporte and $ajax_request) {
    		$valido = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $pasaporte));
    		if (!empty($valido)) {
    			$info_usuario = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
    			if (!empty($info_usuario)) {
                    $id_hacienda = $info_usuario[0]->id_hacienda;
                    $hacienda = $this->Master_m->filas_condicion('hacienda',array('id' => $id_hacienda));
                    if (!empty($hacienda)) {
                        $hacienda = $hacienda[0]->hacienda;
                        $correo = $valido[0]->correo;
                        $this->Master_m->insert('visitas',array(
                            'id_hacienda' => $id_hacienda,
                            'id_pasaporte' => $pasaporte
                        ));
                        $nombre_hacienda = array('1' => 'sauza','2' => 'herradura', '3' => 'cofradia');
                        $this->Master_m->update('info_compra',array($nombre_hacienda[$id_hacienda] => '1'),array('id_pasaporte' => $pasaporte));
                        $haciendas = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $pasaporte));
                        if (!empty($haciendas)) {
                            $sauza = $haciendas[0]->sauza;
                            $herradura = $haciendas[0]->herradura;
                            $cofradia = $haciendas[0]->cofradia;
                            if ($sauza == '1' and $herradura == '1' and $cofradia == '1') {
                                $kit = $this->Master_m->filas_condicion('kit',array('id_pasaporte' => $pasaporte));
                                if (empty($kit)) {
                                     $this->Master_m->insert('kit',array('id_pasaporte' => $pasaporte));
                                }
                            }
                        } 
                        else {
                            echo 'Ha ocurrido un error';   
                        }
                        if ($correo != '') {
                            $usuario = $info_usuario[0]->usuario;
                            $info_msj = array(
                                'dominio' => 'no-reply@tequila.mx', 
                                'origen' => 'Hacienda Pasaporte tequila', 
                                'asunto' => 'Visita', 
                                'texto' => 'Gracias por su visita a '.$hacienda, 
                                'destino' => $correo,
                                'usuario' => $usuario
                            );
                            $enviado = $this->enviar_msj($info_msj);
                            if (!$enviado) {
                                echo 'Correo enviado'; // Success  
                            }
                            else {
                                echo 'Error al enviar correo'; // Error al enviar
                            }
                        } 
                        else {
                            echo 'Correo no válido';
                        }
                    } 
                    else {
                        echo 'Hacienda no encontrada'; // Hacienda no encontrada
                    }
                } 
                else {
                    echo 'Usuario no encotrando'; // Usuario no encotrando
                }
    		}
    		else {
                echo 'Pasaporte no encontrado'; // Pasaporte no encontrado
    		}
    	}
        else {
            print_r('Error'); // Error
        }

    }

    private function enviar_msj($info_msj) {

        date_default_timezone_set('America/Mazatlan');
        $mail = new PHPMailer();
        $mail->IsSMTP(); 
        $mail->SMTPAuth   = true; 
        $mail->SMTPSecure = 'ssl';  
        $mail->Host       = 'smtp.gmail.com';      
        $mail->Port       = 465;                   
        $mail->Username   = 'pasaporte.tequila@gmail.com';  
        $mail->Password   = 'pasaporte_tequila';            
        $mail->SetFrom($info_msj['dominio'], $info_msj['origen']); 
        $mail->Subject    = $info_msj['asunto'];
        $mail->Body       = $info_msj['texto'];
        // $mail->AltBody    = $info_msj['texto'];
        $mail->AddAddress($info_msj['destino'], $info_msj['usuario']);
        $mail->CharSet = 'UTF-8';

        if(!$mail->Send()) {
           return $mail->ErrorInfo;
        } 
        else {
            return false;
        }

    }

    public function info_pasaporte_() {

    	$pasaporte = $this->input->post('pasaporte',true);
    	$ajax_request =  $this->input->is_ajax_request();

    	if ($ajax_request and $pasaporte) {
    		$pertenece = $this->Master_m->filas_condicion('p_tequilero',array('id' => $pasaporte));
    		if (!empty($pertenece)) {
    			echo $pertenece[0]->vendedor;
    		}
    		else echo 'No encontrado';
    	}

    }

    private function menu() {

    	if ($this->session->userdata('login')) {
			$data['rol'] = $this->Inicio_m->get_rol($this->session->userdata('id_usuario'));
			$data['avatar'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
			$data['avatar'] = $data['avatar'][0]->avatar;
			$data['header'] = $this->get_header();
			$data['menu_1'] = $this->Master_m->filas_condicion('menu_1',array('id_rol' => $data['rol'][0]->id_rol));
			$data['id_rol'] = $data['rol'][0]->id;
            $data['rol'] = $data['rol'][0]->roles;
			$data['id_usuario'] = md5($this->session->userdata('id_usuario'));
			foreach ($data['menu_1'] as $menu_1) {
				$response = $this->Master_m->filas_condicion('menu_2',array('id_menu1' => $menu_1->id));
				if (!empty($response)) {
					foreach ($response as $value) {
						$data['menu_2'][] = $value;
					}	
				} 
			}
			foreach ($data['menu_2'] as $menu_2) {
				$response = $this->Master_m->filas_condicion('menu_3',array('id_menu2' => $menu_2->id));
				foreach ($response as $value) {	
					$data['menu_3'][] = $value;	
				}
			}
            switch ($data['id_rol']) {
                case '1':
                    $data['color_1'] = 'c-admin';
                    $data['color_2'] = 'c-admin-50';
                    break;
                case '2':
                    $data['color_1'] = 'c-hacienda';
                    $data['color_2'] = 'c-hacienda-50';
                    break;
                case '3':
                    $data['color_1'] = 'c-aliado';
                    $data['color_2'] = 'c-aliado-50';
                    break;
                default:
                    $data['color_1'] = 'blue';
                    $data['color_2'] = 'blue-50';
                    break;
            }
			return $data;
		
		} 
		else {
			return false;
		}

    }

    private function get_header() {
		$base_url['url'] = base_url();
		return $this->load->view('includes/header',$base_url);
	}

	private function tabla_visitas() {

		$id_hacienda = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
    	$id_hacienda = $id_hacienda[0]->id_hacienda;
		$hacienda = $this->Master_m->filas_condicion('hacienda',array('id' => $id_hacienda));
    	$hacienda = $hacienda[0]->hacienda;
  		// echo $id_hacienda; exit();
		// $pasaporte = $this->Config_pasaporte_m->estado_p_($hacienda);
		// echo '<pre>';
		// print_r($this->db->last_query()); exit();
		$pasaporte = $this->Master_m->filas_condicion('info_compra',array( $hacienda.' =' => '0'));
		// print_r($this->db->last_query()); exit();
		$pasaporte_data = new Data_usuarios($pasaporte);
		$path = set_realpath('').'api\datatable_reporte_.json';
		file_put_contents($path,json_encode($pasaporte_data));

	}

	private function tabla_reportes() {

		$pasaporte = $this->Config_pasaporte_m->estado_p();
		$pasaporte_data = new Data_usuarios($pasaporte);
		$path = set_realpath('').'api\datatable_reporte.json';
		file_put_contents($path,json_encode($pasaporte_data));

	}

}

class Data_usuarios {

	public $aaData = '';

	function __construct($aaData="null") {
		$this->aaData = $aaData;
	}

}