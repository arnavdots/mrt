<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Helpers\MrtHelpers;
use Modules\Permission\Entities\Permission;
use Auth;
use Modules\Enquiry\Entities\Enquiry;

class DashboardController extends Controller {
    public $user;
    public function __construct() { 
        parent::__construct();
        
        $this->middleware(function ($request, $next) {
            //$this->user = Auth::guard('admin')->user()->id;
            if (MrtHelpers::canAccessToModule(request()->segment(2)) == '0') {
                return redirect('admin/home');
            }
            return $next($request);
        });         
        
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('admin.dashboard', compact('results'));
    }

}
