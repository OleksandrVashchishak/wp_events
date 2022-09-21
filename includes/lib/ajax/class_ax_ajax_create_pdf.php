<?php
if (!defined('ABSPATH')) {
    exit;
}

class AX_Ajax_Create_Pdf
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        add_action('wp_ajax_ax_create_pdf', array($this, 'ax_create_pdf'));
    }

    public function ax_create_pdf()
    {
        // $_POST['page']
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, 'Hello World!');
        $file = time() . '.pdf';
        $pdf->Output('F', '/' . $file, true);
    
    
        // $pdf->output($file,'D');
        ob_end_flush();
        echo 2002;
        die();
    }
}
