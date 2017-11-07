<?php

namespace Modules\Permission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Permission\Entities\Permission;
use Modules\Permission\Entities\PermissionUser;
use Illuminate\Support\Facades\Redirect;
use Modules\Permission\Http\Requests\CreatePermission;
use Modules\Permission\Http\Requests\UpdatePermission;
use App\Helpers\MrtHelpers;
use App\MrtModels\Role;
use validator;
class PermissionController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {
        $userId = '';
		$url ='permission.store';
        $user_per = array();
        try {
            $permissions = array();
            $users = MrtHelpers::userList();
            if ($_POST) {
				$validator = \Validator::make($request->all(), ['user_id' => 'required',],[
						'user_id.required' => __('permission::permission.message.userId'),]);
				if ($validator->fails()) {return  Redirect::back()->withErrors($validator)->withInput();}
                if ($request->has('user_id')) {
                    $userId = $request->input('user_id');
                    $permissions = MrtHelpers::userPermissions($request->input('user_id'));
                    $selectedPermissions = MrtHelpers::selectedUserPermissions($request->input('user_id'));
                    if ($selectedPermissions) {
                        foreach ($selectedPermissions as $k => $v) {
                            $user_per[] = $v['permission_id'];
                        }
                    }
                } else {
                    $users = MrtHelpers::userList();
                }
            } else {

                $users = MrtHelpers::userList();
            }
        } catch (\Exception $e) {
			MrtHelpers::customErrorLog($e->getMessage());
            return Redirect::back();
        }
        return view('permission::index', compact('users', 'permissions', 'userId', 'user_per','url'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        return view('permission::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request) {
        try {
            $inputs = $request->except('_token', 'submit');
            if (!empty($inputs['permissions'])) {
                if (MrtHelpers::checkPermitionExist($request['userId']) > 0) {
                    if (PermissionUser::where('user_id', $request['userId'])->delete()) {
                        foreach ($inputs['permissions'] as $permissions) {
                            $PermissionUser = new PermissionUser();
                            $PermissionUser->permission_id = $permissions;
                            $PermissionUser->user_id = $request['userId'];
                            $PermissionUser->save();
                        }
                    }
                } else {
                    foreach ($inputs['permissions'] as $permissions) {
                        $PermissionUser = new PermissionUser();
                        $PermissionUser->permission_id = $permissions;
                        $PermissionUser->user_id = $request['userId'];

                        $PermissionUser->save();
                    }
                }
            } else {
				return array(
					'status' => 'success', 
					'message' => __('permission::permission.message.add-success'),
				);
            }
			
			return array(
				'status' => 'success', 
				'message' => __('permission::permission.message.add-success'),
			);

            //return redirect()->route('permission')->with('success', __('permission::permission.message.add-success'));
            
        } catch (\Exception $e) {
			MrtHelpers::customErrorLog($e->getMessage());
            return array(
				'status' => 'success', 
				'message' => __('permission::permission.message.error'),
			);
        }

        return redirect()->route('permission');

    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show() {
        return view('permission::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id) {
        $permission = Permission::find($id);
        return view('permission::edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(CreatePermission $request) {
        try {
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            if ($permission->save()) {
                return redirect('permission')->with('success', __('permission::permission.message.update-success'));
            }
        } catch (\Exception $e) {
			MrtHelpers::customErrorLog($e->getMessage());
            return redirect('permission')->with('error', __('permission::permission.message.error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->back()->with('success', __('permission::permission.message.delete-success'));
    }

}
