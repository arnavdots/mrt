<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Topic;
use Modules\Training\Entities\Section;
use Modules\Training\Http\Requests\TopicRequest;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            
            $url = route('topic.create');            
            // ajax search
            $query = Topic::query();            
            if ($request->ajax()) {                
                if (!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->where('name', 'like', "%$request->search%");
                        
                        $subquery->orWhereHas('sections', function( $q ) use($request) {
                            $q->where('sections.name', 'like', "%$request->search%");
                        });
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
                    return view('training::topic.partials.listing', compact('results','url'));
                } else {                      
                    return view('training::topic.index', compact('results','url'));
                }
            }
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
                        
        } catch (\Exception $e) {
            return redirect()->route('topic')->with('error', $e->getMessage());
        }        
        return view('training::index', compact('results','url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {        
        $url = 'topic.store';
        $sections = Section::where('is_active','1')->pluck('name','id');
        $topic = new Topic;        
        return view('training::topic.create', compact('topic', 'url', 'sections'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(TopicRequest $request)
    {   
        try {
            $input['is_active'] = (!empty($request->is_active)) ? true : false;
            $input['name'] = $request->name;
            $input['section_id'] = $request->section;
            $topic = Topic::create($input);
            if($topic) {                                 
                return array(
                    'status' => 'success', 
                    'message' => __('training::topic.message.add-success'),
                );                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('training::topic.message.error'),
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
        return view('training::topic.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $url = 'topic.update';
        $sections = Section::where('is_active','1')->pluck('name','id');
        $topic = Topic::findOrFail($id);           
        return view('training::topic.create', compact('topic', 'url', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(TopicRequest $request)
    {
        try{
            $input['is_active'] = (!empty($request->is_active)) ? true : false;
            $input['name'] = $request->name;
            $input['section_id'] = $request->section;
            $topic = Topic::whereId($request->id)->update($input);
            if($topic) {                                 
                return array(
                    'status' => 'success', 
                    'message' => __('training::topic.message.update-success'),
                );                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('training::topic.message.error'),
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
            $topic = Topic::findOrFail($id)->delete();
            if($topic) {    
                $result = array(
                    'status' => 'success', 
                    'message' => __('training::topic.message.delete-success'), 
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('training::topic.message.error'));
            }            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }        
        return $result;
    }
    
    
    /**
     * Change status method via ajax
     */
    public function changeStatus($id){                
        try {
            $record = Topic::findOrFail($id);            
            $record->is_active = (empty($record->is_active)) ? true : false;
            if($record->save()) {            
                $status = ($record->is_active) ? 'Active' : 'Deactive';                
                $result = array(
                    'status' => 'success', 
                    'message' => __('training::topic.message.update-status-success'), 
                    'text' => $status
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('training::topic.message.error'));
            }            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }        
        return $result;
        
    }
    
    
}
