<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Training\Entities\Training;
use Modules\Training\Entities\Section;
use Modules\Training\Entities\Topic;
use Modules\Training\Http\Requests\TrainingRequest;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $url = route('training.create'); 
            // ajax search
            $query = Training::query();
            //$query->where('is_active', false);
            if ($request->ajax()) {

                if (!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->orWhere('title', 'like', "%$request->search%")
                                ->orWhere('description', 'like', "%$request->search%");
                        
                        $subquery->orWhereHas('sections', function( $q ) use($request) {
                            $q->where('sections.name', 'like', "%$request->search%");
                        });
                        
                        $subquery->orWhereHas('topics', function( $q ) use($request) {
                            $q->where('topics.name', 'like', "%$request->search%");
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
                    return view('training::training.partials.listing', compact('results','url'));
                } else {
                    return view('training::training.index', compact('results','url'));
                }
            }
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
            
        } catch (\Exception $e) {
            return redirect()->route('training')->with('error', $e->getMessage());
        }
        return view('training::index', compact('results','url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $url = 'training.store';
        $sections = Section::where('is_active','1')->pluck('name','id');
        $topics = Topic::where('is_active','1')->pluck('name','id');
        $training = new Training;        
        return view('training::training.create', compact('training', 'url', 'sections','topics'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(TrainingRequest $request)
    {
        try {
            $input['is_active'] = (!empty($request->is_active)) ? true : false;
            $input['title'] = $request->title;
            $input['description'] = $request->description;
            $input['section_id'] = $request->section;
            $input['topic_id'] = $request->topic;
            $training = Training::create($input);
            if($training) {                                 
                return array(
                    'status' => 'success', 
                    'message' => __('training::training.message.add-success'),
                );                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('training::training.message.error'),
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
        return view('training::training.show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $url = 'training.update';
        $sections = Section::where('is_active','1')->pluck('name','id');
        $topics = Topic::where('is_active','1')->pluck('name','id');
        $training = Training::findOrFail($id);           
        return view('training::training.create', compact('training', 'url', 'sections','topics'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(TrainingRequest $request)
    {
        try{
            $input['is_active'] = (!empty($request->is_active)) ? true : false;
            $input['title'] = $request->title;
            $input['description'] = $request->description;
            $input['section_id'] = $request->section;
            $input['topic_id'] = $request->topic;
            $training = Training::whereId($request->id)->update($input);
            if($training) {                                 
                return array(
                    'status' => 'success', 
                    'message' => __('training::training.message.update-success'),
                );                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('training::training.message.error'),
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
            $training = Training::findOrFail($id)->delete();
            if($training) {    
                $result = array(
                    'status' => 'success', 
                    'message' => __('training::training.message.delete-success'), 
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('training::training.message.error'));
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
            $record = Training::findOrFail($id);            
            $record->is_active = (empty($record->is_active)) ? true : false;
            if($record->save()) {            
                $status = ($record->is_active) ? 'Active' : 'Deactive';                
                $result = array(
                    'status' => 'success', 
                    'message' => __('training::training.message.update-status-success'), 
                    'text' => $status
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('training::training.message.error'));
            }            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }        
        return $result;
        
    }
}
