<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\MrtModels\User;
use App\MrtModels\Role;
use Modules\Branch\Entities\Branch;
use App\MrtModels\Modules;
use App\MrtModels\SubModules;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\PermissionUser;
use Modules\Enquiry\Entities\EnquiryStatus;
use Auth;
use Illuminate\Support\Facades\Log;

class MrtHelpers {

    public static function full_name($first_name, $last_name) {
        return $first_name . ', ' . $last_name;
    }

    public static function date_format($date) {
        return date('d F,Y', strtotime($date));
    }

    public static function datetime_format($date) {
        return date('d F,Y H:i:s', strtotime($date));
    }
    
    public static function dateFormat($date) {
        return date('m/d/Y', strtotime($date));
    }
    
    public static function timeFormat($date) {
        return date('g:i a', strtotime($date));
    }

    /**
     * Function for listing modules
     * 
     */
    public static function modules() {
        $modules = Modules::where('status', 1)->orderBy('order')->with('submodules')->get();
        return $modules;
    }

    /**
     * Function for getting all permissions 
     * 
     */
    public static function userPermissions($userId = 1) {
        $permissions = Permission::all();
        return $permissions;
    }
	/**
     * Function for getting permissions for selected user
     * 
     */
	 public static function selectedUserPermissions($userId) {
        $selectedPermissions = PermissionUser::select('permission_id')->where('user_id',$userId)->get();
        return $selectedPermissions;
    }
	 /**
     * Function for CHECK permissions for selected user already exist or not 	
     * 
     */
	public static function checkPermitionExist($userId){
		$count = PermissionUser::where('user_id',$userId)->get()->count();
		return $count;
	}
    /**
     * User listing in dropdown function
     */
    public static function userList() {
        $users = User::where('is_active', 1)->orderBy('first_name')->pluck('first_name', 'id')->toArray();
        return $users;
    }
	

    /**
     * Function for getting Menus on dashboard
     * 
     */
    public static function navigationMenus() {

        $controller = array();
        $id = Auth::guard('admin')->user()->id;
        $permition = Permission::with('userPermissions');
        $permition = $permition->whereHas('userPermissions', function( $query ) use($id) {
            $query->where('permissions_user.user_id', $id);
        });
        $permition = $permition->get()->toArray();

        if ($permition) {
            foreach ($permition as $k => $v) {
                $controller[] = strtolower($v['controller_name']);
            }
        }

        if ($controller) {
            $menus = Modules::whereIn('controller', $controller)->where('status', '1')->orderBy('order', 'ASC')->get();
            return $menus;
        } else {
            return false;
        }
    }

    /**
     * Function for show concnate two param
     * 
     */
    public static function concnate($param1, $param2) {
        $fullname = $param1 . ' ' . $param2;
        return $fullname;
    }

    public static function getSubModules($slug) {
        if ($slug) {
            $module_id = self::getModuleIdBySlug($slug);
            $controller = array();
            $id = Auth::guard('admin')->user()->id;
            $permition = Permission::with('userPermissions');
            $permition = $permition->whereHas('userPermissions', function( $query ) use($id) {
                $query->where('permissions_user.user_id', $id);
            });
            $permition = $permition->get()->toArray();
            if ($permition) {
                foreach ($permition as $k => $v) {
                    $controller[] = strtolower($v['controller_name']);
                }
            }
            if ($controller) {
                $sub_modules = SubModules::where('module_id', $module_id)->whereIn('controller', $controller)->where('status', '1')->orderBy('order', 'ASC')->get();
                return $sub_modules;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public static function getModuleIdBySlug($slug) {        
        $module_id = Modules::select('id')->where('slug', $slug)->first();
        return $module_id->id;
    }

    /**
     * Function for get role name of login user
     * $param : Module slug
     */
    public static function getRoleName() {

        $getUsersWithRole = User::where('id', Auth::guard('admin')->user()->id)->with('roles')->first();
        if ($getUsersWithRole['roles']) {
            return $getUsersWithRole['roles'][0];
        }
        return $getUsersWithRole['roles'][0] = '';
    }

    /**
     * Function for get role name of login user
     * $param : Module slug
     */
    public static function canAccessToModule($slug) {
        $userId = Auth::guard('admin')->user()->id;       
        $fails = 0;
        $controller_name = self::getModuleController($slug);
        //$userId = Auth::guard('admin')->user()->id;
        if ($controller_name) {
            $permitions_id = self::getPermitionId($controller_name);
            if (!empty($permitions_id)) {

                $permition = PermissionUser::where('user_id', $userId)->whereIn('permission_id', $permitions_id)->get()->count();
                
                return $permition;
            } else {
                return $fails;
            }
        } else {
            return $fails;
        }
    }

    /**
     * Function for get modules controller name
     * $param : Module slug
     */
    public static function getModuleController($slug) {
        $controller = Modules::select('controller')->where('slug', $slug)->first();
        return $controller->controller;
    }

    /**
     * Function for get all permition ids of user and modules
     * $param : Module slug
     */
    public static function getPermitionId($controller_name) {
        $permition = array();
        $permition_id = Permission::select('id')->where('controller_name', strtolower($controller_name))->get()->toArray();
        foreach ($permition_id as $k => $v) {
            $permition[] = $v['id'];
        }
        return $permition;
    }

    /**
     * Function for get all sales consultants
     * 
     */
    public static function getAllConsultants() {
        $role_id = '7';
        $consultants = User::where('is_active', 1)->with('roles');
        $consultants = $consultants->whereHas('roles', function( $query ) use($role_id) {
            $query->where('roles.id', $role_id);
        });
        $consultants = $consultants->pluck('first_name', 'id');
        return $consultants;
    }

    /**
     * Function for get all branches     * 
     */
    public static function getAllBranches() {
        $branches = Branch::where('is_active', 1)->pluck('name', 'id');
        return $branches;
    }

    /**
     * Function for get all status     * 
     */
    public static function getEnquiryStatus() {
        $enquiryStatus = EnquiryStatus::pluck('title', 'id');
        return $enquiryStatus;
    }
    
    /**
     * Function for get all task priorities
     */
    public static function getTaskPriorities() {
        $enquiryPriorities = ['urgent'=>'Urgent', 'medium'=>'Medium', 'low'=>'Low'];
        return $enquiryPriorities;
    }
    
    /**
     * Function for get all task status
     */
    public static function getTaskStatus() {
        $taskStatus = ['Current','Completed'];
        return $taskStatus;
    }
    
    /**
     * Function for get all task views
     */
    public static function getTaskViews() {
        $taskviews = ['Private','Public'];
        return $taskviews;
    }
    
    /**
     * Custom Error Log globle function
     */
    public static function customErrorLog($msg){
		$PATH = config('constants.LOG_CONFIG_PATH') ;
        $data = date('Y');
        $datam = date('m');
        $time = date('Y-m-d');
        Log::useFiles($PATH.$data.'/'.$datam.'/'.$time.'-log.log', 'info');
        Log::error($msg);
    }
    
    /**
     * Get all status
     */
    public static function getStatus(){
        return ['' => 'All', '1' => 'Active', '0' => 'Deactive'];
    }

    
    /**
     * Time Difference
    */
    public static function exceedTime($created){
        
        $current = date('Y-m-d H:i:s');
        $time_limit = config('constants.TASK_TIME_LIMIT') ;
        $diff = strtotime($current) - strtotime($created);
        $diff_in_hrs = $diff/60;
        if($diff_in_hrs > $time_limit){
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @param files get-Files
     * @return Fiels
     */
    public static function getMultipleFiles($file_post) {
        
        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);
        
        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }
        
        return (object) $file_ary;
    }
}
