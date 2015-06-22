<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pdf_test extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }

    public function pdf_test_1() {

    	$this->load->library('Pdf');
        $pdf = new Pdf('P', 'mm', 'Letter', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Israel Parra');
        $pdf->SetTitle('Ejemplo de provincías con TCPDF');
        $pdf->SetSubject('Tutorial TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
        $pdf->setPrintHeader(false);
        // $pdf->setPrintFooter(false);
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
        // $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        // $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));
		// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
        // $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        // $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // $pdf->setFooterData(array(255,255,255),array(0,0,0));   
		// se pueden modificar en el archivo tcpdf_config.php de libraries/config
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		//relación utilizada para ajustar la conversión de los píxeles
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 		// ---------------------------------------------------------
		// establecer el modo de fuente por defecto
        $pdf->setFontSubsetting(true);
		// Establecer el tipo de letra
		//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
		// Helvetica para reducir el tamaño del archivo.
        $pdf->SetFont('freemono', '', 14, '', true);
		// Añadir una página
		// Este método tiene varias opciones, consulta la documentación para más información.
        $pdf->AddPage();
        // $txt = "You can also export 2D barcodes in other formats (PNG, SVG, HTML). Check the examples inside the barcode directory.\n";
        // $pdf->MultiCell(70, 50, $txt, 0, 'J', false, 1, 125, 30, true, 0, false, true, 0, 'T', false);
        $style = array(
            'border' => false,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        $html = '<table border="0">
                <tr>
                    <td align="center" colspan="3">
                        <img src="'.base_url('slider-tequila.png').'" alt="test alt attribute" width="500" height="100" border="0">
                    </td>
                </tr>
                <tr colspan="3">
                    <td height="30" ></td>
                </tr>
                <tr>
                    <td>
                        <img src="'.base_url('haciendas-sauza.jpg').'" alt="test alt attribute" width="383" height="270" border="0">
                    </td>
                    <td>
                        <img src="'.base_url('haciendas-herradura.jpg').'" alt="test alt attribute" width="383" height="270" border="0">
                    </td>
                    <td>
                        <img src="'.base_url('haciendas-cofradia.jpg').'" alt="test alt attribute" width="383" height="270" border="0">
                    </td>
                </tr>
                <tr colspan="3">
                    <td height="50" ></td>
                </tr>
                <tr>
                    <td align="center" colspan="2">
                        <img src="'.base_url('pasaporte.png').'" alt="test alt attribute" width="500" height="350" border="0">
                    </td>
                    <td align="center">
                    </td>
                </tr>
                </table>';
        $pdf->writeHTML($html, true, false, true, false, '');
        $style = array(
            // 'border' => 2,
            'vpadding' => 'auto',
            'hpadding' => 'auto',
            'fgcolor' => array(0,0,0),
            'bgcolor' => false, //array(255,255,255)
            'module_width' => 1, // width of a single module in points
            'module_height' => 1 // height of a single module in points
        );
        $pdf->write2DBarcode('www.vivepueblosmagicos.mx/pasaporte', 'QRCODE,L', 135, 135, 50, 50, $style, 'N');
        $pdf->Text(130,130,'Escanea el código QR');
        $nombre_archivo = utf8_decode("Pasaporte.pdf");
        $pdf->Output($nombre_archivo, 'I');
    }

}