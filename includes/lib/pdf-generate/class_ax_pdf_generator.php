<?php
if (!defined('ABSPATH')) {
    exit;
}

class Ax_Pdf_Generator
{
    private $event_id;
    public function __construct($event_id)
    {
        $this->event_id = $event_id;
        $this->init();
    }

    private function init()
    {
        $this->generate_pdf();
    }

    public function generate_pdf()
    {
        $uploads = wp_upload_dir();
        $pdf = new FPDF('P', 'mm', 'A4');
        $event = get_post($this->event_id);
        $title = get_the_title($this->event_id);
        $content = wp_strip_all_tags(get_the_content($this->event_id));

        $location = get_post_meta($this->event_id, 'ax_country', true) . ' ' . get_post_meta($this->event_id, 'ax_location', true);
        $price = '$' . get_post_meta($this->event_id, 'ax_price', 1);

        $category = '';
        $cats = get_the_terms($event, 'events-cat');
        foreach ($cats as $cat) {
            $category .= $cat->name . ' ';
        }

        //== start get time ==//
        $_start_date = get_post_meta($this->event_id, 'ax_from_date', true);
        $_end_date = get_post_meta($this->event_id, 'ax_to_date', true);
        $_start_time = get_post_meta($this->event_id, 'ax_from_time', true);
        $_end_time = get_post_meta($this->event_id, 'ax_to_time', true);

        $start_date = date('d F', strtotime($_start_date)) . ' @ ' . $_start_time;
        $end_date = date('d F', strtotime($_end_date)) . ' @ ' . $_end_time;
        //== end get time ==//

        //== start TITLE ==//
        $pdf->SetTextColor(0, 0, 0);
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->Cell(0, 15, $title, 0, 0, 'C');
        //== end TITLE ==//

        //== start CONTENT ==//
        $pdf->Ln(22);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Write(6, $content);
        //== end CONTENT ==//

        //== start INFO ==//
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Write(6, 'Time of event:');

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Write(6, $start_date . ' - ' . $end_date);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Write(6, 'Category:');

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Write(6, $category);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Write(6, 'Location:');

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Write(6, $location);

        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Write(6, 'Price:');

        $pdf->Ln(6);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Write(6, $price);
        //== end INFO ==//

        //== start output ==//
        $file_name = $event->post_name . '-' . time() . '.pdf';
        $pdf->Output('F', $uploads['path'] . '/' . $file_name, true);
        //== end output ==//

        //== start add link to postmeta ==//
        update_post_meta($this->event_id, 'ax_pdf_link', $uploads['baseurl'] . $uploads['subdir'] . '/' . $file_name);
        //== end add link to postmeta ==//
    }
}
