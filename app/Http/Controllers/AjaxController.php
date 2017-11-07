<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\MrtModels\States;
use App\MrtModels\Suburb;
use Modules\Training\Entities\Section;
use Modules\Branch\Entities\Branch;
class AjaxController extends Controller {

    /**
     * Ajax based function for change record status
     * @param type $model
     * @param type $id
     * @return type
     */
    public function status_change($model, $id) {
        try {

            $modelClass = '\Modules\\'+$model+'\Entities\\'.$model;
            
            $record = $modelClass::find($id);

            $record->is_active = (empty($record->is_active)) ? true : false;

            $record->save();

            $status = ($record->is_active) ? 'Active' : 'Deactive';
            $message = 'Status changed successfully';

            $result = array('status' => 'success', 'message' => $message, 'text' => $status);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }

        return $result;
    }

    /**
     * Ajax based function for (soft) delete table record 
     * @param type $model
     * @param type $id
     * @return string
     */
    public function delete_record($model, $id) {
        try {

            $modelClass = '\Modules\\'+$model+'\Entities\\'.$model;

            $record = $modelClass::find($id);

            $record->is_deleted = true;

            $record->save();

            $message = 'Record deleted successfully';

            $result = array('status' => 'success', 'message' => $message);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $result = array('status' => 'error', 'message' => $message);
        }

        return $result;
    }

     public function getStates($id,$form_id=null){
		
            if($id){
               if($form_id==null){
                       $selected_state = '';
               }else{
                       $selected_state =  Branch::select('state_id')->where('id',$form_id)->first();
                       $selected_state = $selected_state->state_id;
                      
               }
               $states = States::where('country_id',$id)->pluck('name','id')->prepend('Select a state', '');
               return view('elements.sub_dropdown',compact('states','selected_state'));
            }
		
	}
	public function getCities($id,$form_id=null){
		if($id){
		   if($form_id==null){
			   $selected_suburb = '';
		   }else{
			   $selected_suburb =  Branch::select('suburb_id')->where('id',$form_id)->first();
                           $selected_suburb = $selected_suburb->suburb_id;
		   }
                    $suburb = Suburb::where('state_id',$id)->pluck('name','id')->prepend( 'Select a suburb', '');
                    return view('elements.sub_dropdown',compact('suburb','selected_suburb'));
		}
		
	}

}
