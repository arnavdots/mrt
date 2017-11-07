<?php

namespace Modules\Test\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use PDF;
use App\Helpers\CsvHelpers;
use App\Helpers\ImageHelpers;

class TestController extends Controller {

    /**
     * export csv
     * @return csv file
     */
    public function export_csv() {
        //dump('export-csv is called');die;

        $filename = 'example.csv';

        $titles = array('Name', 'Email', 'Mobile');

        $data = array(
            array('Sohan', 'sohan@yopmail.com', '9887693769'),
            array('Shishupal', 'shishupal@yopmail.com', '9887693768'),
            array('Khushaboo', 'khushaboo@yopmail.com', '9887693767'),
            array('Mukesh', 'mukesh@yopmail.com', '9887693766'),
        );

        return CsvHelpers::export_csv($titles, $data, $filename);
    }

    /**
     * generate pdf
     * @return pdf file
     */
    public function generate_pdf() {
        //dump('generate-pdf');die;

        PDF::SetTitle('Hello World');
        PDF::AddPage();
        PDF::Write(0, 'Hello World');
        PDF::Output('hello_world.pdf');
    }

    /**
     * generate barcode
     * @return Response
     */
    public function generate_barcode() {
        //dump('generate barcode');die;
        // define barcode style
        $style = array(
            'position' => '',
            'align' => 'C',
            'stretch' => false,
            'fitwidth' => true,
            'cellfitalign' => '',
            'border' => true,
            'hpadding' => 'auto',
            'vpadding' => 'auto',
            'fgcolor' => array(0, 0, 0),
            'bgcolor' => false, //array(255,255,255),
            'text' => true,
            'font' => 'helvetica',
            'fontsize' => 8,
            'stretchtext' => 4
        );
        
        PDF::SetTitle('Products');
        PDF::AddPage();
        
        // CODE 128 AUTO
        PDF::Cell(0, 0, 'CODE 128 AUTO', 0, 1);
        PDF::write1DBarcode('CODE 128 AUTO', 'C128', '', '', '', 18, 0.4, $style, 'N');
        
        PDF::Output('example_027.pdf', 'I');
    }

    /**
     * image form
     * @return Response
     */
    function image_upload() {
        
        if(!empty($_POST)) {
            
            $foo = new ImageHelpers($_FILES['image']); 
            if ($foo->uploaded) {
               // save uploaded image with no changes
               $foo->Process(public_path('/').'example/upload/files/');
               if ($foo->processed) {
                 echo 'original image copied';
               } else {
                 echo 'error : ' . $foo->error;
               }
            }
            
        }
        
        return view('test::image_upload');
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index() {
        return view('test::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('test::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show() {
        return view('test::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit() {
        return view('test::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request) {
        
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy() {
        
    }

}
