<?php 

   require 'phpqrcode/qrlib.php'; 
   $tempDir = base_url('qr').'/';
   $hoy = date("Y-m-d-H-i-s").$propiteario;  
   $fileName =$hoy.'.png'; 
   $pngAbsoluteFilePath = $tempDir.$fileName; 
   $urlRelativeFilePath = $fileName; 
   if (!file_exists($pngAbsoluteFilePath)) { 
      QRcode::png($url_virtual,'qr/'.$fileName);
   } 
   else { 
   }  
?>
<page>
   <html>
      <body>
         <div style="margin: 20px 20px 20px 20px;width: 70%;margin-left: 110px;">
         <img src="<?php echo base_url('pasaporte_acceso.png'); ?>" style="width: 70%">
         <p style="margin-top: -505px;margin-left: 30px;color: #444;opacity: 0.5;font-size: 10px"><?php echo $propiteario; ?></p>
         <img src="<?php echo 'qr/'.$fileName; ?>" style="margin-top: 160px;margin-left: 25px;width: 17%">
         <img src="<?php echo base_url('pimgpsh_fullsize_distr.jpg'); ?>" style="margin-top: -30px;float: right">
         </div>
      </body>
   </html>
</page>
<?php
    $content = ob_get_clean();
    require 'html2pdf_v4.03/html2pdf.class.php';
    try
    {
        $pdf = new HTML2PDF('P', 'A4', 'fr','UTF-8');
        $pdf->writeHTML($content);
        $pdf->Output('PasaporteTequilero.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }    
?>