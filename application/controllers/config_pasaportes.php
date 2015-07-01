<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_pasaportes extends CI_Controller {

	function __construct() {
    parent::__construct();
        $this->load->model(array('Inicio_m','Config_pasaporte_m'));
        $this->load->library('my_phpmailer');
        // $this->load->library('Payu_lib');
    }

    public function index() {

	$conexion_l = $this->conexion_landing();
        redirect('inicio/index');

    }
    
    public function revisar_compras_landing() {

        $ajax_request = $this->input->is_ajax_request();
        if ($ajax_request) {
            $conexion_l = $this->conexion_landing();
            $sql = 
            'SELECT * FROM _referencias
            JOIN _user_refe
            ON _referencias.idReferencia = _user_refe.idReferencia
            AND _referencias.status = "APROVED"
            JOIN _usuarios
            ON _user_refe.idUsuario = _usuarios.idUsuario
            AND _usuarios.status = "1"';
            $result = $conexion_l->query($sql,MYSQLI_USE_RESULT);
            if (!$result){
                echo "Error: (" . $conexion_l->errno . ") " . $conexion_l->error;
                exit();
            }
            else {
                while($pasaporte = $result->fetch_object()) {
                    $ya_agregado = $this->Master_m->filas_condicion('info_compra',array('id_landing' => $pasaporte->idUsuario));
                    if (empty($ya_agregado)) {
                        $id_pasaporte = md5(rand());
                        $this->Master_m->insert('info_compra',array(
                            'propietario' => $pasaporte->nombre,
                            'id_web' => '1',
                            'referencia' => $pasaporte->idReferencia,
                            'tipo_pago' => 'Pagado',
                            'efectivo_tarjeta' => '2', 
                            'telefono' => $pasaporte->telefono,
                            'correo' => $pasaporte->email,
                            'id_pasaporte' => $id_pasaporte,
                            'vendedor' => 'Web',
                            'id_landing' => $pasaporte->idUsuario
                        ));   
                    }
                }
                echo '1';
            }
            $result->close();
            $conexion_l->close();
        }
        
    }

    private function conexion_landing() {

        $mysqli = new mysqli("localhost", "pasaport_root", "feliPE#$12jesus", "pasaport_tequilero");
        if ($mysqli->connect_errno) {
             die("Error: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
        }
        return $mysqli;
        
    }
    
    private function email_html($url) {
    
    	return '<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta content="telephone=no" name="format-detection" />
      <meta content="width=mobile-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no" name="viewport" />
      <meta content="IE=9; IE=8; IE=7; IE=EDGE" http-equiv="X-UA-Compatible" />
      <link href="https://fonts.googleapis.com/css?family=Lato:400,300,700,400italic,300italic" rel="stylesheet" type="text/css">
      <title>Generación de Pasaportes</title>
      <style type="text/css">
         /* This is to overwrite Outlook.com’s Embedded CSS */
         table {border-collapse:separate;}
         #back-contain { background-size: contain; }
         a, a:link, a:visited {text-decoration: none; color: #00788a;}
         h2,h2 a,h2 a:visited,h3,h3 a,h3 a:visited,h4,h5,h6,.t_cht {color:#000 !important;}
         p {margin-bottom: 0}
         .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td {line-height: 100%;}                   
         .ExternalClass {width: 100%;}/**This is to center your email in Outlook.com************/
         /* General Resets */
         #outlook a {padding:0;}
         body, #body-table {height:100% !important; width:100% !important; margin:0 auto; padding:0; line-height:100% !important; font-family: Lato, sans-serif;}
         img, a img {border:0; outline:none; text-decoration:none;}
         .image-fix {display:block;}
         table, td {border-collapse:collapse;}
         /* Client Specific Resets */
         .ReadMsgBody {width:100%;} .ExternalClass{width:100%;}
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100% !important;}
         .ExternalClass * {line-height: 100% !important;}
         table, td {mso-table-lspace:0pt; mso-table-rspace:0pt;}
         img {outline: none; border: none; text-decoration: none; -ms-interpolation-mode: bicubic;}
         body, table, td, p, a, li, blockquote {-ms-text-size-adjust:100%; -webkit-text-size-adjust:100%;}
         body.outlook img {width: auto !important;max-width: none !important;}
         /* Start Template Styles */
         /* Main */
         body{ -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         body, #body-table {background-color: #e6e7eb; margin:0 auto !important;; text-align:center !important;}
         p {padding:0; margin: 0; line-height: 24px; font-family: Lato, sans-serif;}
         a, a:link {color: #1c344d;text-decoration: none !important;}
         .footer-link a, .nav-link a {color: #fff6e5;}
         /* Yahoo Mail */
         .thread-item.expanded .thread-body{background-color: #000000 !important;}
         .thread-item.expanded .thread-body .body, .msg-body{display:block !important;}
         #body-table .undoreset table {display: table !important;table-layout: fixed !important;}
         /* Start Media Queries */
         @media only screen and (max-width: 800px) {
         a[href^="tel"], a[href^="sms"] {text-decoration: none;pointer-events: none;   cursor: default;}
         .mobile_link a[href^="tel"], .mobile_link a[href^="sms"] {text-decoration: default; pointer-events: auto;cursor: default;} 
         *[class].mobile-width {width: 700px !important; padding: 0 4px;}
         *[class].center-stack {padding-bottom:30px !important; text-align:center !important; height:auto !important;}
         *[class].bottom-stack {padding-bottom:30px !important;}
         *[class].stack {padding-bottom:30px !important; height: auto !important;}
         *[class].gallery {padding-bottom: 20px!important;}
         *[class].fluid-img {height:auto !important; max-width:600px !important; width: 100% !important;}
         *[class].block {display: block!important;}
         *[class].midaling { width:100% !important; border:none !important; }
         *[class].full-width-layout {width: 100%!important;}
         *[class].test-hidden-space{ height:40px !important;}
         *[class].test-center{ width:100% !important; height:auto !important;text-align:center;}   
         *[class].bg-res1{ background-position: center center !important;background-size: 100% 200% !important; padding:40px 0px !important;}
         *[class].bg-res2{ background-position: center center !important;background-size: 100% 200% !important;padding:40px 0px !important;}
         *[class].res-space{ height:50px !important;}
         }
         @media only screen and (max-width: 700px) {
         *[class].full-width {width: 100%!important;}
         *[class].mobile-width {width: 600px !important; padding: 0 4px;}
         *[class].content-width {width: 540px!important;}
         *[class].icon-columns{ width:540px !important; border:none !important; }
         *[class].mockup-width{ width:33% !important;}
         *[class].center {text-align:center !important; height:auto !important;}
         *[class].section-white{ background-color:#FFFFFF; background:none!important;}
         *[class].hidden-space{ height:0px !important;}
         *[class].no-padding{ padding:0px !important;}
         }
         @media only screen and (max-width: 640px) {
         *[class].mobile-width {width: 480px!important; padding: 0 4px;}
         *[class].content-width {width: 360px!important;}
         *[class].icon-columns{ width:360px !important; border:none !important; }
         *[class].center {text-align:center !important; height:auto !important;  width:100%;}
         }
         @media only screen and (max-width: 480px) {
         *[class].full-width {width: 100%!important;}
         *[class].mobile-width {width: 360px!important; padding: 0 4px;}
         *[class].content-width {width: 300px!important;}
         *[class].icon-columns{ width:300px !important; border:none !important; }
         *[class].center {text-align:center !important; height:auto !important;  width:100%;}
         *[class].center-stack {padding-bottom:30px !important; text-align:center !important; height:auto !important;}
         *[class].stack {padding-bottom:30px !important; height: auto !important;}
         *[class].gallery {padding-bottom: 20px!important;}
         *[class].midaling { width:100% !important; border:none !important; }
         }
         @media only screen and (max-width: 360px) {
         *[class].full-width {width: 100%!important;}
         *[class].mobile-width {width: 100%!important; padding: 0 4px;}
         *[class].content-width {width: 280px!important;}
         *[class].icon-columns{ width:290px !important; border:none !important; }
         *[class].center {text-align:center !important; height:auto !important;  width:100%;}
         *[class].center-stack {padding-bottom:30px !important; text-align:center !important; height:auto !important;}
         *[class].stack {padding-bottom:30px !important; height: auto !important;}
         *[class].gallery {padding-bottom: 20px!important;}
         *[class].fluid-img {height:auto !important; max-width:600px !important; width: 100% !important; min-width:320px !important;}
         *[class].midaling { width:100% !important; border:none !important;}
         }
      </style>
      <!-- Inline Styles and Media Queries Ends -->
   </head>
   <body>
      <!-- Banner Begins -->
      <table id="body-table" bgcolor="#e6e7eb" border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;">
         <tbody>
            <tr>
               <td align="center" valign="top">
                  <!-- Table Outer Begins -->
                  <table width="800" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="mobile-width">
                     <tbody>
                        <tr>
                           <td align="center">
                              <!-- View Online Tag Begins -->
                              <table width="100%" bgcolor="#e5e7eb" align="center" border="0" cellspacing="0" cellpadding="0">
                                 <tbody>
                                    <!-- Start Space -->                            
                                    <tr>
                                       <td height="10"></td>
                                    </tr>
                                    <!-- Start Space -->                            
                                    <tr>
                                       <td height="10"></td>
                                    </tr>
                                    <!-- End Space -->                                 
                                 </tbody>
                              </table>
                              <!-- View Online Tag Ends --> 
                              <!-- Menu & Header Begins -->
                              <table width="800" border="0" cellspacing="0" cellpadding="0" class="mobile-width">
                                 <tbody>
                                    <tr>
                                       <td>
                                          <!-- Bg Image -->
                                          <table bgcolor="#CCCCCC" width="100%" cellspacing="0" cellpadding="0" border="0" background="https://www.pasaportetequilero.mx/img_p/header-img.jpg" style="background-repeat: no-repeat!important; background-position: center center;background-size: contain;" class="full-width">
                                             <tbody>
                                                <tr>
                                                   <td align="center">
                                                      <!-- Menu Section / Logo -->
                                                      <table width="640" cellspacing="0" cellpadding="0" border="0" class="content-width">
                                                         <tbody>
                                                            <tr>
                                                               <td>
                                                                  <!-- Start Logo -->
                                                                  <table width="190" align="left" cellspacing="0" cellpadding="0" border="0" class="center">
                                                                     <tbody>
                                                                        <tr>
                                                                           <td valign="middle">
                                                                           </td>
                                                                        </tr>
                                                                     </tbody>
                                                                  </table>
                                                                  <!-- End Logo -->
                                                                  <!-- Start Nav -->
                                                                  <table align="right" cellspacing="0" cellpadding="0" border="0" class="content-width">
                                                                     <tbody>
                                                                        <tr>
                                                                           <td height="20" class="center">&nbsp;</td>
                                                                        </tr>
                                                                        <tr>
                                                                        </tr>
                                                                        <tr>
                                                                           <td height="15" class="center">&nbsp;</td>
                                                                        </tr>
                                                                     </tbody>
                                                                  </table>
                                                                  <!-- End Nav -->
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                      <!-- Menu Section / Logo Ends -->
                                                      <!-- Header Content Begins -->
                                                      <table width="640" cellspacing="0" cellpadding="0" border="0" class="content-width">
                                                         <tbody>
                                                            <tr>
                                                               <td>

                                                                  <!-- Right Part Image -->
                                                                  <table width="300" align="center" cellspacing="0" cellpadding="0" border="0" class="content-width">
                                                                     <tbody>
                                                                        <tr>
                                                                            <td align="center" class="center" height="300px">
                                                                              <a href="https://www.pasaportetequilero.mx" >
                                                                                 <img src="http://www.pasaportetequilero.mx/img_p/logo.png"  alt="" editable="true"/>
                                                                              </a>
                                                                           </td>
                                                                        </tr>
                                                                     </tbody>
                                                                  </table>
                                                                  <!-- Right Part Image End -->                                                          
                                                               </td>
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                      <!-- Header Content Ends -->
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <!-- Menu & Header Ends -->
                              <!-- Latest Post 1/3 Begins -->
                              <table width="800" border="0" cellspacing="0" cellpadding="0" class="mobile-width"> 
                                 <tbody>
                                    <!-- Start Space -->                            
                                    <tr>
                                       <td height="60"></td>
                                    </tr>
                                    <!-- End Space --> 
                                    <tr>
                                       <td align="center">
                                          <!-- 1/3 Post Right -->
                                          <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="content-width">
                                             <tbody>
                                                <tr>
                                                    <td align="center" style="font-family: Lato, sans-serif; font-size: 30px; text-transform:uppercase; mso-line-height-rule:exactly; line-height:45px; font-weight:300; color: #343a32;" mc:edit="post-main-title">                                        
                                                            <multiline label="latest-post-main-title">
                                                                    ¡ESTÁS A UN PASO DE LA VIVENCIA TEQUILERA!
                                                            </multiline>                                             
                                                    </td>
                                                </tr>
                                                 <tr style="margin-left: 60px;margin-right: 60px;">
                                                    <td align="center" style="font-family: Lato, sans-serif; font-size: 14px;mso-line-height-rule:exactly; line-height:21px; font-weight:300; color: #343a32;" mc:edit="post-main-text">                                         
                                                            <multiline label="1-column-text1">
                                                                    Gracias por comprar tu Pasaporte Tequilero, el siguiente paso es descargar tu Pasaporte Tequilero Virtual, el cual te servirá para reclamar tu Pasaporte Físico, ingresa a la liga y descarga tu pasaporte virtual.
                                                            </multiline>                                             
                                                    </td>                  
                                                 </tr>
                                                <tr>
                                                    <td align="center">
                                                        <br><br>
                                                        <a href="'.$url.'">
                                                            <img src="https://www.pasaportetequilero.mx/img_p/btn-descarga.png">
                                                        </a>
                                                    </td>
                                                </tr> 
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>

                                 </tbody>
                              </table>

                              <!-- Testimonial Begins -->
                              <table width="800" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width-layout">
                                 <tbody>
                                    <tr>
                                       <td align="center">
                                          <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
                                             <tbody>
                                                <!-- Start Space -->                            
                                                <tr>
                                                   <td height="70"></td>
                                                </tr>
                                                <!-- End Space --> 
                                                <tr>
                                                   <td>
                                                      <table width="300" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width">
                                                         <tbody>
                                                            <tr>
                                                               <td align="center" >
                                                                   <img src="https://www.pasaportetequilero.mx/img_p/herradura-logo.png" style="width: 80%">
                                                               </td>
                                                               <td align="center" >
                                                                   <img src="https://www.pasaportetequilero.mx/img_p/sauza-logo.png" style="width: 80%">
                                                               </td>
                                                               <td align="center" >
                                                                   <img src="https://www.pasaportetequilero.mx/img_p/cofradia-logo.png" style="width: 80%">
                                                               </td>                                                                
                                                            </tr>
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                                <!-- Start Space -->                            
                                                <tr>
                                                   <td height="30"></td>
                                                </tr>
                                                <!-- End Space --> 
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <!-- Testimonial Ends -->
                              <!-- Contact Box Begins -->
                              <table width="800" bgcolor="#24272c" align="center" border="0" cellspacing="0" cellpadding="0" class="full-width-layout">
                                 <tbody>
                                    <tr>
                                       <td align="center">
                                          <!-- Post Left -->
                                          <table width="640"  align="center" border="0" cellspacing="0" cellpadding="0" class="content-width">
                                             <tbody>
                                                <tr>
                                                   <td align="center">
                                                      <table width="100%" align="left" border="0" cellspacing="0" cellpadding="0" class="content-width">
                                                         <tbody>
                                                            <!-- Start Space -->                            
                                                            <tr>
                                                               <td height="40"></td>
                                                            </tr>
                                                            <!-- End Space -->                              
                                                            <tr>
                                                               <td align="center" style="font-family: Lato, sans-serif; font-size: 16px; mso-line-height-rule:exactly; line-height:21px; font-weight:300;color: #FFFFFF;" mc:edit="contact-text1">
                                                                  <multiline label="contact-box-text1">
                                                                     Contacto y Soporte
                                                                  </multiline>
                                                               </td>
                                                            </tr>                            
                                                            <tr>
                                                               <td height="40"></td>
                                                            </tr>
                                                            <!-- End Space -->                                    
                                                         </tbody>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <!-- Table Outer Ends -->
               </td>
            </tr>
         </tbody>
      </table>
      <!-- End of banner -->
   </body>
</html>';
    
    }

    public function asignar() {
    
        $id_pasaporte = $this->input->post('id_pasaporte',true);
        $id_fisico = $this->input->post('id_fisico',true);
        $ajax_request = $this->input->is_ajax_request();
        if ($id_pasaporte and $id_fisico and $ajax_request) {
            $this->Master_m->update('info_compra',array('id_fisico' => $id_fisico),array('id_pasaporte' => $id_pasaporte));
            echo 'Hecho';
        }
    }
    
    public function enviar_pasaporte() {
    
        $id_pasaporte = $this->input->post('id_pasaporte',true);
        $ajax_request = $this->input->is_ajax_request();
        if ($id_pasaporte and $ajax_request) {
            $info_compra = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $id_pasaporte));
            //$info_msj = array(
             //   'dominio' => 'no-replay@pasaportetequilero.mx',
             //   'origen' => 'Pasaporte tequilero', 
             //   'asunto' => 'Pasaporte', 
             //   'texto' => 'ID virtual: '.$info_compra[0]->id_pasaporte. ' ID físico: '.$info_compra[0]->id_fisico,
             //   'destino' => $info_compra[0]->correo,
             //   'usuario' => $info_compra[0]->propietario
            //);
            $info_msj = array(
                            'dominio' => 'no-replay@pasaportetequilero.mx',
                            'origen' => 'Pasaporte Tequilero', 
                            'asunto' => 'Compra de pasaporte tequilero', 
                            'destino' => $info_compra[0]->correo,
                            'usuario' => $info_compra[0]->propietario,
                            'url_acceso' => base_url('pasaporte_virtual/acceso?id='.$id_pasaporte),
                            'id_pasaporte' => $id_pasaporte
                        );
            $enviado = $this->enviar_msj_html($info_msj);
            //$enviado = $this->enviar_msj($info_msj);
            if (!$enviado) {
                echo 'Pasaporte enviado'; // Success  
            }
            else {
                echo 'Error al enviar pasaporte'; // Error al enviar
            }
        }
        
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
                    $id_hacienda = $this->Inicio_m->get_id_vendedor(array(
                        'vendedor' => 'hacienda',
                        'id_usuario' => $this->session->userdata('id_usuario')
                    ));  
                    $id_hacienda = $id_hacienda[0]->id_hacienda;
                    $hacienda = array('1' => 'sauza','2' => 'herradura', '3' => 'cofradia');
                    $valid['id_hacienda_v'] = $hacienda[$id_hacienda];
                    $valid['pasaportes'] = $this->Master_m->filas_condicion('info_compra',array('status' => '1','tipo_pago' => 'Pagado'));
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
                $venta = $this->Config_pasaporte_m->last_id('info_compra');
                $valid['total_id'] = '0';
                if (!empty($venta)) {
                    $valid['total_id'] = $venta[0]->id+1;
                }
                else {
                    $valid['total_id'] = 1;
                }
        		switch ($rol) {
                    case 1:
                        redirect('inicio/index');
                        break;
        	case 2: 
                        $valid['vendedor'] = 'Hacienda';
                        $valid['n_vendedor'] = $this->get_ha($this->session->userdata('id_usuario'),'hacienda');
                        //exit();
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
                        $valid['pasaportes'] = $this->Master_m->filas_condicion('info_compra',array('status' => '1'));
                        $valid = $this->kit($valid);
                        $this->load->view('config_pasaportes/reportes_ventas_a_v',$valid);
                        break;
                    case 2:
                        // $valid['ventas_'] = $this->get_ha_('id_hacienda',$this->session->userdata('id_usuario'));
                        $valid['ventas_'] = $this->Master_m->filas_condicion('info_compra',array('status' => '1'));
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

    public function g_reporte() {
      $ventas = true;
      $pasaportes = '';
      $rol = $this->input->get('rol',true);
      $visita = $this->input->get('visita',true);
      if ($rol) {
        $this->excel->setActiveSheetIndex(0);
        if ($rol == '1') {
            if ($visita) {
              $pasaportes = $this->Config_pasaporte_m->reporte_visitas();
              $this->excel->getActiveSheet()->setTitle('Visitas');
              $this->excel->getActiveSheet()->setCellValue('A1','ID pasaporte');
              $this->excel->getActiveSheet()->setCellValue('B1','Propietario');
              $this->excel->getActiveSheet()->setCellValue('C1','Vendedor');
              $this->excel->getActiveSheet()->setCellValue('D1','Haciendas visitadas');
              $this->excel->getActiveSheet()->setCellValue('E1','Fecha visitada');
              $this->excel->getActiveSheet()->setCellValue('F1','Fecha de compra');
              $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
              $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
              $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
              $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
              $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
              $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
              $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
              $this->excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              // $this->excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $this->excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $this->excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $this->excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $this->excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
              $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
              $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
              $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
              $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
              $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
              $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
              for ($i=2; $i < count($pasaportes)+2; $i++) { 
                    $this->excel->getActiveSheet()->setCellValue('A'.(string)$i,$pasaportes[$i-2]->id);
                    $this->excel->getActiveSheet()->setCellValue('B'.(string)$i,$pasaportes[$i-2]->propietario);
                    $this->excel->getActiveSheet()->setCellValue('C'.(string)$i,$pasaportes[$i-2]->vendedor);
                    $hacienda_visitas = ($pasaportes[$i-2]->sauza == '1')?'Sauza ':'';
                    $hacienda_visitas .= ($pasaportes[$i-2]->herradura == '1')?'Herradura ':'';
                    $hacienda_visitas .= ($pasaportes[$i-2]->cofradia == '1')?'Cofradia':'';
                    $this->excel->getActiveSheet()->setCellValue('D'.(string)$i,$hacienda_visitas);
                    $this->excel->getActiveSheet()->setCellValue('E'.(string)$i,$pasaportes[$i-2]->fecha);
                    $this->excel->getActiveSheet()->setCellValue('F'.(string)$i,$pasaportes[$i-2]->fecha_visita);
              }
              $filename = 'Reporte_ventas_'.date('Y-m-d h:i:sa').'.xls';
            }
            else {
              $pasaportes = $this->Master_m->filas_condicion('info_compra',array('status' => '1'));
            }
            $rango1 = $this->input->get('rango_visitas',true);
            $rango2 = $this->input->get('rango_ventas',true);
            if ($rango1 || $rango2) {
                $tipos_rango = array(
                    'hoy' => '= CURDATE()',
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
                if ($rango1) {
                    $pasaportes = $this->Config_pasaporte_m->reporte_visitas($tipos_rango[$rango1]);
                    if (!empty($pasaportes)) {
                      $this->excel->getActiveSheet()->setTitle('Visitas');
                      $this->excel->getActiveSheet()->setCellValue('A1','ID pasaporte');
                      $this->excel->getActiveSheet()->setCellValue('B1','Propietario');
                      $this->excel->getActiveSheet()->setCellValue('C1','Vendedor');
                      $this->excel->getActiveSheet()->setCellValue('D1','Haciendas visitadas');
                      $this->excel->getActiveSheet()->setCellValue('E1','Fecha visitada');
                      $this->excel->getActiveSheet()->setCellValue('F1','Fecha de compra');
                      $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
                      $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
                      $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
                      $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
                      $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
                      $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setSize(12);
                      $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                      $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                      $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                      $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                      $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
                      $this->excel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
                      $this->excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      // $this->excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $this->excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $this->excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $this->excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $this->excel->getActiveSheet()->getStyle('F')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                      $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                      $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                      $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                      $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                      $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
                      $this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
                      for ($i=2; $i < count($pasaportes)+2; $i++) { 
                            $this->excel->getActiveSheet()->setCellValue('A'.(string)$i,$pasaportes[$i-2]->id);
                            $this->excel->getActiveSheet()->setCellValue('B'.(string)$i,$pasaportes[$i-2]->propietario);
                            $this->excel->getActiveSheet()->setCellValue('C'.(string)$i,$pasaportes[$i-2]->vendedor);
                            $hacienda_visitas = ($pasaportes[$i-2]->sauza == '1')?'Sauza ':'';
                            $hacienda_visitas .= ($pasaportes[$i-2]->herradura == '1')?'Herradura ':'';
                            $hacienda_visitas .= ($pasaportes[$i-2]->cofradia == '1')?'Cofradia':'';
                            $this->excel->getActiveSheet()->setCellValue('D'.(string)$i,$hacienda_visitas);
                            $this->excel->getActiveSheet()->setCellValue('E'.(string)$i,$pasaportes[$i-2]->fecha);
                            $this->excel->getActiveSheet()->setCellValue('F'.(string)$i,$pasaportes[$i-2]->fecha_visita);
                      }
                      $filename = 'Reporte_ventas_'.date('Y-m-d h:i:sa').'.xls';
                    } 
                    else {
                      redirect('inicio/index','refresh');
                    }
                    
                } 
                else {
                    $pasaportes= $this->Config_pasaporte_m->reporte_ventas($tipos_rango[$rango2]);
                    if (!empty($pasaportes)) {
                      $ventas = true;
                    } 
                    else {
                      redirect('inicio/index','refresh');
                    }
                }
          } 
          if ($ventas) {
            $this->excel->getActiveSheet()->setTitle('Ventas');
            $this->excel->getActiveSheet()->setCellValue('A1','ID pasaporte');
            $this->excel->getActiveSheet()->setCellValue('B1','Propietario');
            $this->excel->getActiveSheet()->setCellValue('C1','Fecha de compra');
            $this->excel->getActiveSheet()->setCellValue('D1','Vendedor');
            $this->excel->getActiveSheet()->setCellValue('E1','Haciendas visitadas');
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
            $this->excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('E')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            for ($i=2; $i < count($pasaportes)+2; $i++) { 
                  $this->excel->getActiveSheet()->setCellValue('A'.(string)$i,$pasaportes[$i-2]->id);
                  $this->excel->getActiveSheet()->setCellValue('B'.(string)$i,$pasaportes[$i-2]->propietario);
                  $this->excel->getActiveSheet()->setCellValue('C'.(string)$i,$pasaportes[$i-2]->fecha);
                  $this->excel->getActiveSheet()->setCellValue('D'.(string)$i,$pasaportes[$i-2]->vendedor);
                  $hacienda_visitas = ($pasaportes[$i-2]->sauza == '1')?'Sauza ':'';
                  $hacienda_visitas .= ($pasaportes[$i-2]->herradura == '1')?'Herradura ':'';
                  $hacienda_visitas .= ($pasaportes[$i-2]->cofradia == '1')?'Cofradia':'';
                  $this->excel->getActiveSheet()->setCellValue('E'.(string)$i,$hacienda_visitas);
            }
            $filename = 'Reporte_ventas_'.date('Y-m-d h:i:sa').'.xls';
          }
        } 
        else if ($rol == '2') {
          $action = $this->input->get('action',true);
          if ($action == 'venta') {
            $id_hacienda = $this->Master_m->filas_condicion('usuarios',array(
              'id'     => $this->session->userdata('id_usuario'),
              'status' => '1' 
            ));
            if(!empty($id_hacienda)) {
              $id_hacienda = $id_hacienda[0]->id_hacienda;
              $nombre_hacienda = array(
                '1' => 'Sauza',
                '2' => 'Herradura',
                '3' => 'Cofradia'
              );
            $pasaportes = $this->get_ha_('id_hacienda',$this->session->userdata('id_usuario'));
            $this->excel->getActiveSheet()->setTitle('Ventas de hacienda - '.$nombre_hacienda[$id_hacienda]);
            $this->excel->getActiveSheet()->setCellValue('A1','ID pasaporte');
            $this->excel->getActiveSheet()->setCellValue('B1','Propietario');
            $this->excel->getActiveSheet()->setCellValue('C1','Fecha de compra');
            $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
            $this->excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // $this->excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            for ($i=2; $i < count($pasaportes)+2; $i++) { 
                  $this->excel->getActiveSheet()->setCellValue('A'.(string)$i,$pasaportes[$i-2]->id);
                  $this->excel->getActiveSheet()->setCellValue('B'.(string)$i,$pasaportes[$i-2]->propietario);
                  $this->excel->getActiveSheet()->setCellValue('C'.(string)$i,$pasaportes[$i-2]->fecha);
                }
                $filename = 'Reporte_ventas_'.date('Y-m-d h:i:sa').'.xls';
            }
            else {
               redirect('inicio/index','refresh');
            }
          } 
          else if ($action == 'visitas') {
            $id_hacienda = $this->Master_m->filas_condicion('usuarios',array(
              'id'     => $this->session->userdata('id_usuario'),
              'status' => '1' 
            ));
            if(!empty($id_hacienda)) {
              $id_hacienda = $id_hacienda[0]->id_hacienda;
              $nombre_hacienda = array(
                '1' => 'Sauza',
                '2' => 'Herradura',
                '3' => 'Cofradia'
              );
              $pasaportes = $this->Config_pasaporte_m->get_visita_propietario($id_hacienda);
              if (!empty($pasaportes)) {
                $this->excel->getActiveSheet()->setTitle('Visitas de hacienda - '.$nombre_hacienda[$id_hacienda]);
                $this->excel->getActiveSheet()->setCellValue('A1','ID pasaporte');
                $this->excel->getActiveSheet()->setCellValue('B1','Propietario');
                $this->excel->getActiveSheet()->setCellValue('C1','Fecha de visita');
                $this->excel->getActiveSheet()->setCellValue('D1','Fecha de compra');
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setSize(12);
                $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
                $this->excel->getActiveSheet()->getStyle('A')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('C')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getStyle('D')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
                $this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
                for ($i=2; $i < count($pasaportes)+2; $i++) { 
                  $this->excel->getActiveSheet()->setCellValue('A'.(string)$i,$pasaportes[$i-2]->id_pasaporte_i);
                  $this->excel->getActiveSheet()->setCellValue('B'.(string)$i,$pasaportes[$i-2]->propietario);
                  $this->excel->getActiveSheet()->setCellValue('C'.(string)$i,$pasaportes[$i-2]->f_visita);
                  $this->excel->getActiveSheet()->setCellValue('D'.(string)$i,$pasaportes[$i-2]->f_compra);
                }
                $filename = 'Reporte_visitas_'.date('Y-m-d h:i:sa').'.xls';
              } 
              else {
                redirect('inicio/index','refresh');
              }
            }
          }
        }
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"'); 
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
        $objWriter->save('php://output');
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
            return $this->Master_m->filas_condicion('info_compra',array($vendedor => $id_vendedor, 'status' => '1'));
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
            if (!empty($venta)) {
                 echo $venta[0]->id+1;
            }
            else {
                echo 1;
            }
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
        $fisico = $this->input->post('fisico',true);
    	$id_fisico = $this->input->post('id_fisico',true);
    	$referencia_on = $this->input->post('referencia_on',true);
        $referencia = $this->input->post('referencia',true);
    	$submit_id = $this->input->post('submit_id',true);
        $ajax_request =  $this->input->is_ajax_request();

        // print_r($this->input->post('submit')); exit();
         // print_r('_frm_'.$submit_id); exit();
    	
        if ($ajax_request and 
            $vendedor and
            $id_pasaporte and 
            $propietario and 
            $pago and $fisico ) {

            if ($this->input->post('submit') == 'frm-'.$submit_id) { 

                $this->form_validation->set_rules('id_pasaporte','ID pasaporte','required|integer|is_unique[info_compra.id]');
                $this->form_validation->set_rules('vendedor','hacienda/aliado','required');
                $this->form_validation->set_rules('propietario','propietario','required|min_length[4]|max_length[128]');
                $this->form_validation->set_rules('pago','pago','required|integer');
                $this->form_validation->set_rules('telefono','teléfono','integer');
                $this->form_validation->set_rules('correo','correo','required|valid_email');
                
                if ($fisico == '1') {
                    $this->form_validation->set_rules('id_fisico','ID pasaporte físico','required|is_unique[info_compra.id_fisico]');
                }
                if ($referencia_on== '1') {
                    $this->form_validation->set_rules('referencia','número de referencia','required|integer');
                }
                
                $this->form_validation->set_error_delimiters('','');
                
                if ($this->form_validation->run() == false) {
                    echo validation_errors();
                }
                else {
                    $existe = $this->Master_m->filas_condicion($n_vendedor,array($n_vendedor => $vendedor));
                    if (!empty($existe)) {
                        $numero = rand();
                        $id_pasaporte = md5($numero);
                        $pago_ = array('1' => 'Pagado', '2' => 'Pagado');
                        $this->Master_m->insert('info_compra',array(
                            'propietario' => $propietario,
                            'id_'.$n_vendedor => $existe[0]->id,
                            'tipo_pago' => $pago_[$pago],
                            'telefono' => $telefono,
                            'correo' => $correo,
                            'domicilio' => $domicilio,
                            'id_pasaporte' => $id_pasaporte,
                            'vendedor' => $vendedor,
                            'efectivo_tarjeta' => $pago,
                            'id_fisico' => $id_fisico,
                            'referencia' => $referencia
                        ));
                        $mensaje = array(
                            'no' => 'Su compra ha sido realizada con el pasaporte ID provisional: '.$numero.' Pasaporte virtual: '.base_url().'pasaporte_virtual/acceso?id='.$id_pasaporte,
                            '1' => 'Su compra ha sido realizada con el pasaporte ID: '.$id_fisico.' Pasaporte virtual: '.base_url().'pasaporte_virtual/acceso?id='.$id_pasaporte
                        );
                        $info_msj = array(
                            'dominio' => 'no-replay@pasaportetequilero.mx',
                            'origen' => 'Pasaporte Tequilero', 
                            'asunto' => 'Compra de pasaporte tequilero', 
                            // 'texto' => $mensaje[$fisico],
                            /*'texto' => 'Gracias por comprar tu Pasaporte Tequilero, el siguiente paso es descargar tu Pasaporte Tequilero Virtual, el cual te servirá para reclamar tu Pasaporte Físico, ingresa a la liga y asigna un usuario: '.base_url().'pasaporte_virtual/acceso?id='.$id_pasaporte,*/
                            'destino' => $correo,
                            'usuario' => $propietario,
                            'url_acceso' => base_url('pasaporte_virtual/acceso?id='.$id_pasaporte),
                            'id_pasaporte' => $id_pasaporte
                        );
                        // $enviado = $this->enviar_msj($info_msj);
                        $enviado = $this->enviar_msj_html($info_msj);
                        if (!$enviado) {
                            echo 'Correo enviado - '; // Success  
                        }
                        else {
                           print_r ('Error al enviar correo: '.$enviado); // Error al enviar
                        }
                       echo 'Hecho';
                    } 
                    else {
                        echo 'Vendedor no registrado'; // no existe vendedor  
                    }
                }
            }
            else {
                print_r($this->input->post('submit'));
                echo 'Error';
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
                        $propietario =  $valido[0]->propietario;
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
                                'dominio' => 'no-replay@pasaportetequilero.mx', 
                                'origen' => 'Pasaporte tequilero', 
                                'asunto' => 'Visita', 
                                'texto' => 'Gracias por su visita a '.$hacienda, 
                                'destino' => $correo,
                                'usuario' => $propietario
                            );
                            $enviado = $this->enviar_msj($info_msj);
                            if (!$enviado) {
                                echo 'Correo enviado'; // Success  
                            }
                            else {
                                print_r ('Error al enviar correo: '.$enviado); // Error al enviar
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

    // $message = str_replace('%testusername%', $username, $message); 
    // $message = str_replace('%testpassword%', $password, $message); 

    private function enviar_msj_html($info_msj) {

        // $message = file_get_contents(base_url('assets/email/email.html'));
        // $message = str_replace('%url_acceso%',$info_msj['url_acceso'],$message); 
        $mail = new PHPMailer;
        $mail->IsSMTP(); 
        $mail->SMTPAuth   = true; 
        $mail->SMTPSecure = 'tls';  
        $mail->Host       = 'pasaportetequilero.mx';     
        //$mail->Host       = 'smtp.gmail.com'; 
        $mail->Port       = 587;                   
        $mail->Username   = 'no-replay@pasaportetequilero.mx';  
        $mail->Password   = '&{p$v[9DwCO}';      
        //$mail->Username   = 'pasaporte.tequila@gmail.com';  
        //$mail->Password   = 'pasaporte_tequila';
        $mail->SetFrom($info_msj['dominio'], $info_msj['origen']); 
        $mail->From = 'no-replay@pasaportetequilero.mx';
        $mail->Subject    = $info_msj['asunto'];
        $mail->Body       = $this->email_html(base_url('pasaporte_virtual/acceso?id='.$info_msj['id_pasaporte']));
        // $mail->AltBody    = $info_msj['texto'];
        // $mail->MsgHTML($message);
        $mail->IsHTML(true);
        $mail->AddAddress($info_msj['destino'], $info_msj['usuario']);
        $mail->CharSet = 'UTF-8';

        if(!$mail->Send()) {
           return $mail->ErrorInfo;
        } 
        else {
            return false;
        }

    }

    private function enviar_msj($info_msj) {

        // date_default_timezone_set('America/Mazatlan');
        //require 'PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        $mail->IsSMTP(); 
        $mail->SMTPAuth   = true; 
        $mail->SMTPSecure = 'tls';  
        $mail->Host       = 'pasaportetequilero.mx';     
        //$mail->Host       = 'smtp.gmail.com'; 
        $mail->Port       = 587;                   
        $mail->Username   = 'no-replay@pasaportetequilero.mx';  
       	$mail->Password   = '&{p$v[9DwCO}';      
        //$mail->Username   = 'pasaporte.tequila@gmail.com';  
        //$mail->Password   = 'pasaporte_tequila';
        $mail->SetFrom($info_msj['dominio'], $info_msj['origen']); 
        $mail->From = 'no-replay@pasaportetequilero.mx';
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
      $data['correo'] = $this->Master_m->filas_condicion('usuarios',array('id' => $this->session->userdata('id_usuario')));
			$data['correo'] = $data['correo'][0]->correo;
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

}