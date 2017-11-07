<?php

namespace Modules\Enquiry\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Enquiry\Http\Requests\EnquiryRequest;
use App\Helpers\MrtHelpers;
use Modules\Enquiry\Entities\Enquiry;
use App\MrtModels\Branch;

class EnquiryController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {

        try {
            // ajax search
            $query = Enquiry::query();
            $query->where('is_deleted', false);

            if ($request->ajax()) {

                if (!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->orWhere('contact_name', 'like', "%$request->search%")
                                ->orWhere('contact_email', 'like', "%$request->search%")
                                ->orWhere('contact_number', 'like', "%$request->search%")
                                ->orWhere('contact_address_line_1', 'like', "%$request->search%")
                                ->orWhere('contact_address_line_2', 'like', "%$request->search%")
                                ->orWhere('contact_postcode', 'like', "%$request->search%")
                                ->orWhere('note', 'like', "%$request->search%");
                    });
                }
                if (!empty($request->consultant)) {
                    $query->where('assignee_id', '=', $request->consultant);
                }
                if (!empty($request->branch)) {
                    $query->where('branch_id', '=', $request->branch);
                }
                if (isset($request->status) && $request->status != '') {
                    $status = $request->status;
                    $query->where('status_id', $status);
                }
                if (!empty($request->date_range)) {
                    $dateRange = explode("-", $request->date_range);
                    $query->whereDate('created_at', '>=', date('Y-m-d', strtotime(trim($dateRange[0]))));
                    $query->whereDate('created_at', '<=', date('Y-m-d', strtotime(trim($dateRange[1]))));
                }
                if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
                    $sort = $request->sort;
                    $order = $request->order;
                    $query->orderBy($sort, $order);
                }
                $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
                if ($request->action == 'search') {
                    return view('enquiry::partials.listing', compact('results'));
                } else {
                    return view('enquiry::index', compact('results'));
                }
            }

            // default last week records

            $query->whereDate('created_at', '>=', date('Y-m-d', strtotime('-7 day')));
            $query->whereDate('created_at', '<=', date('Y-m-d'));

            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));

            //dd($results);
        } catch (\Exception $e) {
            return redirect('dashboard')->with('error', $e->getMessage());
        }
        return view('enquiry::index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('enquiry::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(EnquiryRequest $request) {
        $input = $request->all();
        echo "<pre>";
        print_r($request);
        echo "</pre>";
        die;

        try {
            $enquiry = new Enquiry();
            $enquiry->name = $request->name;
            $enquiry->display_name = $request->display_name;
            $enquiry->description = $request->description;
            if ($enquiry->save()) {
                return redirect('enquiry')->with('success', __('enquiry::enquiry.message.update-success'));
            }
        } catch (\Exception $e) {
            return redirect('enquiry')->with('error', __('enquiry::enquiry.message.error'));
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show() {
        return view('enquiry::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit() {
        return view('enquiry::edit');
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
