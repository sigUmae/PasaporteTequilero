<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf extends TCPDF {

    function __construct(){
        parent::__construct();
    }

    public function Footer() {
        // Position at 25 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        $this->Image(
            base_url('bg-haciendas.jpg'), 
            0, // x 
            240, // y
            210, // width 
            60, // heigth 
            'JPG', 
            'http://www.vivepueblosmagicos.mx/pasaporte', 
            '', // align 
            true, // resize
            150, // dpi
            '', // palign
            false, // ismask
            false, // imgmask
            0, // border
            false, // fitbox 
            false, // hidden
            false // fitonpage
        );
         $this->Image(
            base_url('logo-min.png'), 
            20, // x 
            240, // y
            80, // width 
            60, // heigth 
            'PNG', 
            'http://www.vivepueblosmagicos.mx/pasaporte', 
            '', // align 
            true, // resize
            150, // dpi
            '', // palign
            false, // ismask
            false, // imgmask
            0, // border
            false, // fitbox 
            false, // hidden
            false // fitonpage
        );
        $this->SetTextColor(255,255,255);
        $this->SetFont('helvetica', 'N', 10);
        $txt = 'Pasaporte Tequilero es tu acceso a nuestras tres casas tequileras (Casa Herradura, Casa Sauza y Hacienda La Cofradí­a) aconpañado de verdaderos maestros tequileros, en donde podrás conocer el proceso de producción y la historia de esta bebida mexicana por exelencia.';
        // $this->Cell(0, 0,'', 0, 0, 'C');
        $this->MultiCell(70, 50, $txt, 0, 'J', false, 1, 110, 250, true, 0, false, true, 0, 'T', false);
        // $this->Ln();
        // $this->Cell(0,0,'www.clientsite.com - T : +91 1 123 45 64 - E : info@clientsite.com', 0, false, 'C', 0, '', 0, false, 'T', 'M');   
        // Page number
        // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

}