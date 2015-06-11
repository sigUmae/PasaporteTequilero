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
                $pdf->Image(base_url('pasaporte/pasaporte_virtual_acceso.png'),10,10,410,500,'PNG','','',true,150,'',false,false,0,false,false,false);
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