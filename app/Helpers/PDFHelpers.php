<?php

namespace App\Helpers;

use PDF;

class PDFHelpers {

    public static function export_PDF($titles, $data, $filename) {
        
        $html = '';
        $html .= '<table>';
        
        $html .= '<thead>';
        $html .= '<tr>';
        foreach ($titles as $title) {
            $html .= '<td>'. $title .'</td>';
        }
        $html .= '</tr>';
        $html .= '</thead>';
        

        $html .= '<tbody>';
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $value) {
                $html .= '<td>' . $value . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        
        $html .= '</table>';

        PDF::SetTitle($filename);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output($filename.'.pdf');
    }

}
