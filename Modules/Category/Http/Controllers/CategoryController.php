<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Category\Http\Requests\CategoryRequest as CategoryRequest;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {       
        $url = route('category.create');
        
        try {
            $query = Category::query();
            $query->where('is_deleted', false);
            
            // ajax search
            if($request->ajax()) {

                if(!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->orWhere('name', 'like', "%$request->search%")
                                 ->orWhere('slug', 'like', "%$request->search%");
                    });
                }

                if(isset($request->status) && $request->status != '') {
                    $status = (!empty($request->status)) ? true : false;
                    $query->where('is_active', $status);
                }
                
                if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
                    $sort = $request->sort;
                    $order = $request->order;
                    $query->orderBy($sort, $order);
                }
                
                $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
                
                return view('category::partials.listing', compact('results', 'url'));
            }
            
            // on page load
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
            
        } catch (\Exception $e) {
            //dd($e);
            return redirect()->route('category')->with('error', $e->getMessage());
        }
        
        //dd($results);
        
        return view('category::index', compact('results', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $url = 'category.store';
        
        $category = new Category;
        
        return view('category::create', compact('category', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(CategoryRequest $request)
    {
        //dd($request);
        try {
            $category = new Category;
            
            $category->name = $request->name;
            $category->slug = Category::createSlug($request->name);
            $category->is_active = (!empty($request->is_active)) ? true : false;
            
            if($category->save()) {
                
                return array(
                    'status' => 'success', 
                    'message' => __('category::category.category_added'),
                );
                
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('category::category.category_not_added'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $url = 'category.update';
        
        $category = Category::find($id);
        
        return view('category::create', compact('category', 'url'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(CategoryRequest $request)
    {
        $all=$request->all();
        
        try {
            $category = Category::findOrFail($all['id']);
            
            $category->name = $all['name'];
            $category->slug = Category::createSlug($request->name);
            $category->is_active = (!empty($all['is_active'])) ? true : false;
            
            if($category->save()) { 
                
                return array(
                    'status' => 'success', 
                    'message' => __('category::category.category_updated'),
                );
            } else {
                return array(
                    'status' => 'error', 
                    'message' => __('category::category.category_not_updated'),
                    'errors' => $validator->getMessageBag()->toArray(),
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
            $record = Category::find($id);
            
            $record->is_deleted = true;

            if($record->save()) {
            
                $result = array(
                    'status' => 'success', 
                    'message' => __('category::category.record_deleted_successfully'), 
                );
            
            } else {
                
                $result = array('status' => 'error', 'message' => __('category::category.record_can_not_delete_try_again'));
            }
            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }
        
        return $result;
    }
    
    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('category::show');
    }
    
    /**
     * active/deactive the specified resource.
     * @return Response
     */
    public function changeStatus($id)
    {
        try {
            $record = Category::find($id);
            
            $record->is_active = (empty($record->is_active)) ? true : false;

            if($record->save()) {
            
                $status = ($record->is_active) ? 'Active' : 'Deactive';
                
                $result = array(
                    'status' => 'success', 
                    'message' => __('category::category.status_updated_successfully'), 
                    'text' => $status
                );
            
            } else {
                
                $result = array('status' => 'error', 'message' => __('category::category.status_not_update_try_again'));
            }
            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }
        
        return $result;
    }

}
