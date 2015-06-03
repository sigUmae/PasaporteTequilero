<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pasaporte_virtual extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Pdf');
    }

    public function index() {        
        header("Location: http://pasaportetequilero.mx");
        die();
    }

    public function acceso() {

        $id_pasaporte = $this->input->get('id',true);
        if ($id_pasaporte) {
            $info = $this->Master_m->filas_condicion('info_compra',array('id_pasaporte' => $id_pasaporte));
            $propietario = $info[0]->propietario;
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
            $pdf->Image(base_url('pasaporte/pasaporte_acceso.png'),20,20,220,500,'PNG','','',true,150,'',false,false,0,false,false,false);
            $pdf->Image(base_url('pasaporte/logo.png'),140,215,50,40,'PNG','','',true,150,'',false,false,0,false,false,false);
            $style = array(
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false, 
                'module_width' => 1, 
                'module_height' => 1 
            );
            $pdf->write2DBarcode(base_url('ver_mas?pasaporte='.$id_pasaporte), 'QRCODE,L', 24, 170, 30, 30, $style, 'N');
            $pdf->Text(26,120,$propietario);
            $nombre_archivo = utf8_decode("Pasaporte_virtual.pdf");
            $pdf->Output($nombre_archivo, 'I');
        }
        else {

        }

    }

}