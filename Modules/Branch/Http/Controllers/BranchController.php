<?php

namespace Modules\Branch\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Branch\Http\Requests\BranchRequest as BranchRequest;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Branch\Entities\Branch;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\MrtModels\Country;
use App\MrtModels\States;
use App\MrtModels\Suburb;
use Auth;

class BranchController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {

        try {
            $query = Branch::query();
            $query->with(['Suburb', 'States']);
            $query->where('is_deleted', false);
            // ajax search
            if ($request->ajax()) {
                if (!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->orWhere('name', 'like', "%$request->search%")
                                ->orWhere('branch_code', 'like', "%$request->search%")
                                ->orWhere('postcode', 'like', "%$request->search%")
                                ->orWhere('address_line_1', 'like', "%$request->search%")
                                ->orWhere('address_line_2', 'like', "%$request->search%");
                    
                        $subquery->orWhereHas('Suburb', function( $q ) use($request) {
                            $q->where('suburb.name', 'like', "%$request->search%");
                        });
                        $subquery->orWhereHas('States', function( $q ) use($request) {
                            $q->where('states.name', 'like', "%$request->search%");
                        });
                    });
                }
                if (isset($request->status) && $request->status != '') {
                    $status = (!empty($request->status)) ? true : false;
                    $query->where('is_active', $status);
                }

                if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
                    $sort = $request->sort;
                    $order = $request->order;

                    $query->orderBy($sort, $order);
                }

                $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));

                return view('branch::partials.listing', compact('results', 'url'));
            }

            // on page load
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
        } catch (\Exception $e) {
            return redirect()->route('branch')->with('error', $e->getMessage());
        }

        $url = route('branch.create');
        return view('branch::index', compact('url', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $selected_country = '';
        $selected_state = '';
        $selected_suburb = '';
        $url = 'branch.store';
        $branch = new Branch;
        $country = Country::pluck('country_name', 'id')->toArray();
        return view('branch::create', compact('branch', 'url', 'country', 'selected_country', 'selected_state', 'selected_suburb'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(BranchRequest $request) {
        //dd($request->toArray());
        try {
            $branch = new Branch;

            $branch->name = $request->name;
            $branch->branch_code = $request->branch_code;
            $branch->address_line_1 = $request->address_line_1;
            $branch->address_line_2 = $request->address_line_2;
            $branch->country_id = $request->country_id;
            $branch->state_id = $request->state_id;
            $branch->suburb_id = $request->suburb_id;
            $branch->postcode = $request->postcode;
            $branch->branch_ip = $request->branch_ip;
            $branch->is_active = (!empty($request->is_active)) ? true : false;
            $branch->creator_id = Auth::guard('admin')->user()->id;
            $branch->modifier_id = Auth::guard('admin')->user()->id;

            if ($branch->save()) {

                return array(
                    'status' => 'success',
                    'message' => __('branch::branch.branch_added'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('branch::branch.user_not_added'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show() {
        return view('branch::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id) {
        $url = 'branch.update';

        $branch = Branch::find($id);

        $country = Country::pluck('country_name', 'id')->toArray();
        $selected_country = $branch->country_id;
        $selected_state = $branch->state_id;
        $selected_suburb = $branch->suburb_id;

        return view('branch::create', compact('branch', 'url', 'country', 'selected_country', 'selected_state', 'selected_suburb'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(BranchRequest $request) {
        $all = $request->all();

        try {
            $branch = Branch::findOrFail($all['id']);

            $branch->name = $request->name;
            $branch->branch_code = $request->branch_code;
            $branch->address_line_1 = $request->address_line_1;
            $branch->address_line_2 = $request->address_line_2;
            $branch->country_id = $request->country_id;
            $branch->state_id = $request->state_id;
            $branch->suburb_id = $request->suburb_id;
            $branch->postcode = $request->postcode;
            $branch->branch_ip = $request->branch_ip;
            $branch->is_active = (!empty($request->is_active)) ? true : false;
            $branch->modifier_id = Auth::guard('admin')->user()->id;

            if ($branch->save()) {

                return array(
                    'status' => 'success',
                    'message' => __('branch::branch.branch_added'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('branch::branch.branch_not_updated'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $record = Branch::find($id);
            
            $record->is_deleted = true;

            if($record->save()) {
            
                $result = array(
                    'status' => 'success', 
                    'message' => __('branch::branch.record_deleted_successfully'), 
                );
            
            } else {
                
                $result = array('status' => 'error', 'message' => __('branch::branch.record_can_not_delete_try_again'));
            }
            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }
        
        return $result;
    }
    
      /**
     * active/deactive the specified resource.
     * @return Response
     */
    public function changeStatus($id)
    {
        try {
            $record = Branch::find($id);
            
            $record->is_active = (empty($record->is_active)) ? true : false;

            if($record->save()) {
            
                $status = ($record->is_active) ? 'Active' : 'Deactive';
                
                $result = array(
                    'status' => 'success', 
                    'message' => __('branch::branch.status_updated_successfully'), 
                    'text' => $status
                );
            
            } else {
                
                $result = array('status' => 'error', 'message' => __('branch::branch.status_not_update_try_again'));
            }
            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }
        
        return $result;
    }
}
