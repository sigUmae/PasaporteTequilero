<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pasaporte_virtual extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model('Inicio_m');
    }

    public function index() {        
        header('Location: http://pasaportetequilero.mx');
        die();
    }

    public function acceso() {

        $id_pasaporte = $this->input->get('id',true);
        if ($id_pasaporte) {
            $info = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $id_pasaporte,'status' => '1'));
            if (!empty($info)) {
                $meses = array(
                    '1' => 'Enero',
                    '2' => 'Febrero',
                    '3' => 'Marzo',
                    '4' => 'Abril',
                    '5' => 'Mayo',
                    '6' => 'Junio',
                    '7' => 'Julio',
                    '8' => 'Agosto',
                    '9' => 'Septiembre',
                    '10' => 'Octubre',
                    '11' => 'Noviembre',
                    '12' => 'Diciembre'
                );
                $propietario = $info[0]->propietario;
                $correo = $info[0]->correo;
                $fecha = $this->Inicio_m->fechas(array('id_pasaporte' => $id_pasaporte));
                $dia = $fecha[0]->dia;
                $mes = $meses[$fecha[0]->mes];
                $year = $fecha[0]->year;
                $datos = array(

                    'propiteario' => $propietario,
                    'correo' => $correo,
                    'dia' => $dia,
                    'mes_year' => $mes.' '.$year,
                    'url_virtual' => base_url('ver_mas?pasaporte='.$id_pasaporte)
                );
                // $pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);
                // $pdf->SetCreator(PDF_CREATOR);
                // $pdf->SetAuthor('pasaportetequilero.mx');
                // $pdf->SetTitle('Pasaporte tequilero');
                // $pdf->setPrintHeader(false);
                // $pdf->setPrintFooter(false);
                // $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                // $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                // $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                // $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                // $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                // $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                // $pdf->setFontSubsetting(true);
                // $path_font = set_realpath('assets/fonts').'arialbd.ttf';
                // $fontname = TCPDF_FONTS::addTTFfont($path_font,'TrueTypeUnicode','',32);
                // $pdf->SetFont($fontname,'',40,'', true);
                // $pdf->SetTextColor(20,108,133);  
                // $pdf->AddPage();

                // $pdf->Text(17,3,'Pasaporte Tequilero');
                // $pdf->SetTextColor(0,0,0); 
                // $pdf->SetFont($fontname,'',16,'', true);
                // $pdf->Text(17,20,'Propietario:');
                // $pdf->SetFont($fontname,'',12,'', true);
                // // $pdf->SetTextColor(115,117,119);
                // $pdf->Text(17,28,$propietario);
                // $pdf->SetFont($fontname,'',12,'', true);
                // $pdf->SetFont($fontname,'',18,'', true);
                // $pdf->Text(17,45,'Correo electrónico:');
                // $pdf->SetFont($fontname,'',12,'', true);
                // $pdf->Text(17,53,$correo);
                // $pdf->SetFont($fontname,'',18,'', true);
                // $pdf->Text(17,70,'Viaja a:');
                // $pdf->SetFont($fontname,'',12,'', true);
                // $pdf->Text(17,78,'Tequila, y Amatitán, Jalisco:');
                // $pdf->SetFont($fontname,'',14,'', true);
                // $pdf->Text(17,101,'Con:');
                // $pdf->SetFont($fontname,'',12,'', true);
                // $pdf->Text(17,109,'Pasaporte Tequilero:');
                // $pdf->SetFont($fontname,'',14,'', true);
                // $pdf->Text(17,134,'Destino:');
                // $pdf->SetFont($fontname,'',12,'', true);
                // $pdf->Text(17,142,'Casa Herradura, Casa Sauza, Hacienda La Cofradía:');
                // $pdf->SetFont($fontname,'',14,'', true);
                // $pdf->Text(17,167,'Duración:');
                // $pdf->SetFont($fontname,'',12,'', true);
                // $pdf->Text(17,175,'1 año a partir de la fecha:');
                // $pdf->Text(17,183,$mes.' '.$year);
                // $pdf->SetFont($fontname,'',10,'', true);
                // $pdf->Text(110,210,'Este código QR servirá para validar este');
                // $pdf->Text(110,218,'acceso virtual y entregarte');
                // $pdf->Text(9,260,'Pasaporte Tequilero | Comercializadora Popol | Tel: 01 (374) 742 7100 | Email: contacto@pasaportetequilero.mx');
                //  $style = array(
                //     'vpadding' => 'auto',
                //     'hpadding' => 'auto',
                //     'fgcolor' => array(0,0,0),
                //     'bgcolor' => false, 
                //     'module_width' => 1, 
                //     'module_height' => 1 
                // );
                // $pdf->write2DBarcode(base_url('ver_mas?pasaporte='.$id_pasaporte), 'QRCODE,L', 35, 200, 35, 35, $style, 'N');
//                 $html = 
//                 '<table>
                    
//                         <tr><td>¡Gracias por comprar Pasaporte Tequilero!</td></tr>
//                         <tr><td>Este es un Pasaporte Tequilero Virtual, el cual
// tendrás que canjear por tu Pasaporte Físico para
// el ingreso a nuestras haciendas.</td></tr>
//                         <tr><td>Además has tenido acceso a la cuponera de
// descuentos de nuestros aliados estratégicos, los
// cuales podrás consultar en:</td></tr>
//                         <tr><td>www.pasaportetequilero.mx/beneficios.php
// y que para hacerlos válidos tendrás que presentar
// tu Pasaporte Tequilero físico en sus establecimientos</td></tr>
//                         <tr><td>Además, te recordamos que tu Pasaporte Tequilero
// tiene una duración de un año a partir de esta
// fecha:</td></tr>
//     <tr><td>Esperamos que tu visita sea agradable.</td></tr>
                    
//                 </table>';
//                  $pdf->writeHTML($html, true, false, true, false, '');
                // $this->load->view('pasaporte_virtual/virtual',$datos);
                
                $pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('pasaportetequilero.mx');
                $pdf->SetTitle('Pasaporte tequilero');
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
                $pdf->setFontSubsetting(true);
                $path_font = set_realpath('assets/fonts').'arialbd.ttf';
                $fontname = TCPDF_FONTS::addTTFfont($path_font,'TrueTypeUnicode','',32);
                $pdf->SetFont($fontname,'',8,'', true);
                $pdf->SetTextColor(115,117,119); 
                $pdf->AddPage(); 
                $pdf->Image('http://localhost/pasaportetequilero/pasaporte/pasaporte_virtual_acceso.png',10,10,410,500,'PNG','','',true,150,'',false,false,0,false,false,false);
                $style = array(
                    'vpadding' => 'auto',
                    'hpadding' => 'auto',
                    'fgcolor' => array(0,0,0),
                    'bgcolor' => false, 
                    'module_width' => 1, 
                    'module_height' => 1 
                );
                $pdf->write2DBarcode(base_url('ver_mas?pasaporte='.$id_pasaporte), 'QRCODE,L', 16, 148, 28, 28, $style, 'N');
                $pdf->Text(17,103,$propietario);
                $pdf->Text(17,116,$correo);
                $pdf->SetTextColor(0,107,133); 
                $pdf->SetFont($fontname,'',40,'', true);
                $pdf->Text(83.5,198,$dia);
                $pdf->SetFont($fontname,'',10,'', true);
                $pdf->Text(82.5,213,$mes.' '.$year);
                $nombre_archivo = utf8_decode("Pasaporte_virtual.pdf");
                $pdf->Output($nombre_archivo, 'I');
            }
            else {
                header('Location: http://pasaportetequilero.mx');
            }
        }
        else {
            header('Location: http://pasaportetequilero.mx');
        }

    }

}