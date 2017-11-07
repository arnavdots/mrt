<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Section;
use Modules\Training\Http\Requests\SectionRequest;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $url = route('section.create'); 
            // ajax search
            $query = Section::query();
            if ($request->ajax()) {
                if (!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->where('name', 'like', "%$request->search%");
                    });
                }
                if (isset($request->status) && $request->status != '') {
                    $status = $request->status;
                    $query->where('is_active', $status);
                }
                if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
                    $sort = $request->sort;
                    $order = $request->order;
                    $query->orderBy($sort, $order);
                }
                $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
                if ($request->action == 'search' || isset($request->sort)) {
                    return view('training::section.partials.listing', compact('results','url'));
                } else {                   
                    return view('training::section.index', compact('results','url'));
                }
            }            
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));            
            
        } catch (\Exception $e) {
            return redirect()->route('section')->with('error', $e->getMessage());
        }
        return view('training::index', compact('results','url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $url = 'section.store';        
        $section = new Section;        
        return view('training::section.create', compact('section', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(SectionRequest $request)
    {
        try {            
            $input['is_active'] = (!empty($request->is_active)) ? true : false;
            $input['name'] = $request->name;
            $section = Section::create($input);
            if($section) {                                 
                return array(
                    'status' => 'success', 
                    'message' => __('training::section.message.add-success'),
                );                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('training::section.message.error'),
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
    public function show()
    {
        return view('training::section.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $url = 'section.update';
        $section = Section::findOrFail($id); 
        return view('training::section.create', compact('section', 'url'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(SectionRequest $request)
    {
        try{
            $input['is_active'] = (!empty($request->is_active)) ? true : false;
            $input['name'] = $request->name;
            $section = Section::whereId($request->id)->update($input);
            if($section) {                                 
                return array(
                    'status' => 'success', 
                    'message' => __('training::section.message.update-success'),
                );                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('training::section.message.error'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        }catch (\Exception $e) {
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
            $section = Section::findOrFail($id)->delete();
            if($section) {    
                $result = array(
                    'status' => 'success', 
                    'message' => __('training::section.message.delete-success'), 
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('training::section.message.error'));
            }            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }        
        return $result;
    }
    
    /**
     * Change status 
     */
    public function changeStatus($id){                
        try {
            $record = Section::findOrFail($id);            
            $record->is_active = (empty($record->is_active)) ? true : false;
            if($record->save()) {            
                $status = ($record->is_active) ? 'Active' : 'Deactive';                
                $result = array(
                    'status' => 'success', 
                    'message' => __('training::section.message.update-status-success'), 
                    'text' => $status
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('training::section.message.error'));
            }            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }        
        return $result;
        
    }
}
