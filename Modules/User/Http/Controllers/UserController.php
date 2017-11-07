<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Modules\User\Http\Requests\UserRequest as UserRequest;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\User\Entities\User;
use App\MrtModels\Role;
use Illuminate\Support\Facades\Redirect;
use Modules\User\Http\Repository\UserRepository;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request) {
        $url = route('users.create');
        
        try {
            // ajax search
            if ($request->ajax()) {
                $results = UserRepository::search($request);
                return view('user::partials.listing', compact('results', 'url'));
            }
            
            // on page load
            $results = UserRepository::search($request);
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            MrtHelpers::customErrorLog($errorMsg);
            return redirect()->route('users')->with('error', $errorMsg);
        }
        
        $roles = UserRepository::roles();
        return view('user::index', compact('results', 'url', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create() {
        $disabled = '';
        $url = 'users.store';
        $userRole = 7;

        $user = new User;

        $roles = UserRepository::roles();

        return view('user::create', compact('user', 'disabled', 'url', 'roles', 'userRole'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(UserRequest $request) {
        try {
            
            $user = UserRepository::save($request);
            
            if($user) {
                return array(
                    'status' => 'success',
                    'message' => __('user::user.user_added'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('user::user.user_not_added'),
                    'errors' => $validator->getMessageBag()->toArray()
                );
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            MrtHelpers::customErrorLog($errorMsg);
            return array('status' => 'error', 'message' => $errorMsg);
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id) {
        $disabled = 'readonly';
        $url = 'users.update';
        $userRole = 7;

        $user = User::find($id);

        foreach ($user->roles as $role) {
            $userRole = $role->id;
        }

        $roles = UserRepository::roles();

        return view('user::create', compact('user', 'disabled', 'url', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(UserRequest $request) {

        try {
            
            $user = UserRepository::update($request);
            
            if($user) {
                return array(
                    'status' => 'success',
                    'message' => __('user::user.user_updated'),
                );
            } else {
                return array(
                    'status' => 'error',
                    'message' => __('user::user.user_not_updated'),
                    'errors' => $validator->getMessageBag()->toArray(),
                );
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            MrtHelpers::customErrorLog($errorMsg);
            return array('status' => 'error', 'message' => $errorMsg);
        }
    }

    /**
     * Export users.
     * @return null
     */
    public function export($type, Request $request) {
        if ($type == 'pdf') {
            return UserRepository::export_PDF($request);
        } else {
            return UserRepository::export_csv($request);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id) {
        try {
            
            $record = User::findOrFail($id)->delete();

            if ($record) {

                $result = array(
                    'status' => 'success',
                    'message' => __('category::category.record_deleted_successfully'),
                );
            } else {

                $result = array('status' => 'error', 'message' => __('user::user.record_can_not_delete_try_again'));
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            MrtHelpers::customErrorLog($errorMsg);
            $result = array('status' => 'error', 'message' => $errorMsg);
        }

        return $result;
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show() {
        return view('category::show');
    }

    /**
     * active/deactive the specified resource.
     * @return Response
     */
    public function changeStatus($id) {
        try {
            $record = User::find($id);

            $record->is_active = (empty($record->is_active)) ? true : false;

            if ($record->save()) {

                $status = ($record->is_active) ? 'Active' : 'Deactive';

                $result = array(
                    'status' => 'success',
                    'message' => __('user::user.status_updated_successfully'),
                    'text' => $status
                );
            } else {

                $result = array('status' => 'error', 'message' => __('user::user.status_not_update_try_again'));
            }
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            MrtHelpers::customErrorLog($errorMsg);
            $result = array('status' => 'error', 'message' => $errorMsg);
        }

        return $result;
    }

}
