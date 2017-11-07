<?php

namespace Modules\Gallery\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Http\Requests\GalleryRequest;
use App\Helpers\ImageHelpers;
use Illuminate\Support\Facades\File;
use App\Helpers\MrtHelpers;

class GalleryController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {
        try {
            $url = route('gallery.create');
            $query = Gallery::query();            
            // ajax search
            if ($request->ajax()) {
                if (!empty($request->search)) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->orWhere('product_code', 'like', "%$request->search%")
                                ->orWhere('image', 'like', "%$request->search%");
                    });                  
                }
                if (isset($request->status) && $request->status != '') {
                    //$status = (!empty($request->status)) ? true : false;                    
                    //return $query->where('is_active', $status);
                    $query->status($query,$request->status);
                }
                if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
                    $sort = $request->sort;
                    $order = $request->order;
                    $query->orderBy($sort, $order);
                }

                $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
                if ($request->action == 'search' || isset($request->sort)) {
                    return view('gallery::partials.listing', compact('results', 'url'));
                } else {
                    return view('gallery::index', compact('results', 'url'));
                }
            }
            $query->orderBy('created_at', 'DESC');
            $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));
        } catch (\Exception $e) {
            return redirect()->route('gallery')->with('error', $e->getMessage());
        }

        return view('gallery::index', compact('results', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $url = 'gallery.store';
        $gallery = new Gallery;
        return view('gallery::create', compact('gallery', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(GalleryRequest $request) {
                
        try {
            
            $files = MrtHelpers::getMultipleFiles($_FILES['image']);            
            foreach ($files as $photo) {
                $imageObj = new ImageHelpers($photo);
                if ($imageObj->uploaded) {
                    $product = $request->product_code;
                    $imageObj->file_new_name_body = $product;
                    $uploadPath = config('filesystems.disks.gallery.root');
                    $imageObj->Process($uploadPath . $product);
                    if ($imageObj->processed) {                        
                        $filename = $imageObj->file_dst_name;
                        $gallery = Gallery::create(['product_code' => $product, 'image' => $filename]);                        
                    } else {                        
                        $errMsg[] = $imageObj->error;
                    }
                } 
            }
            if ($gallery) {
                return array(
                    'status' => 'success',
                    'message' => __('gallery::gallery.message.add-success'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('gallery::gallery.message.error'),
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
        return view('gallery::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit() {
        return view('gallery::edit');
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
    public function destroy($id) {
        try {
            $record = Gallery::findOrFail($id)->delete();
            if($record) {    
                $result = array(
                    'status' => 'success', 
                    'message' => __('gallery::gallery.message.delete-success'), 
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('gallery::gallery.message.error'));
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
            $record = Gallery::findOrFail($id);            
            $record->is_active = (empty($record->is_active)) ? true : false;
            if($record->save()) {            
                $status = ($record->is_active) ? 'Active' : 'Deactive';                
                $result = array(
                    'status' => 'success', 
                    'message' => __('gallery::gallery.message.update-status-success'), 
                    'text' => $status
                );            
            } else {                
                $result = array('status' => 'error', 'message' => __('gallery::gallery.message.error'));
            }            
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }        
        return $result;
        
    }

}
