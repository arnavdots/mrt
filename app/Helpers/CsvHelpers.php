<?php

namespace App\Helpers;

class CsvHelpers {

    public static function export_csv($titles, $data, $filename) {
        $fp = fopen('php://output', 'w');

        fputcsv($fp, $titles);
        foreach ($data as $fields) {
            fputcsv($fp, $fields);
        }

        fclose($fp);

        $ctype = 'application/force-download';
        header("Cache-Control: cache, must-revalidate");
        header("Pragma: public");
        header('Content-Type: ' . $ctype);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }

}
