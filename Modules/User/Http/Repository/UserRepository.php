<?php

namespace Modules\User\Http\Repository;

use Modules\User\Entities\User;
use App\MrtModels\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Registration;
use App\Helpers\CsvHelpers;
use App\Helpers\PDFHelpers;

class UserRepository {
    
    /**
     * find records into database
     * @param object $request
     * @return Users
     */
    public static function search($request = null) {
        
        $query = User::query();

        // ajax search
        if (!empty($request->search)) {
            $query->where(function ($subquery) use ($request) {
                $subquery->orWhere('first_name', 'like', "%$request->search%")
                        ->orWhere('last_name', 'like', "%$request->search%")
                        ->orWhere('email', 'like', "%$request->search%")
                        ->orWhere('mobile', 'like', "%$request->search%");
            });
        }

        if (!empty($request->role)) {
            $query->where('email', '==', $request->role);
        }

        if (isset($request->status) && $request->status != '') {
            $status = (!empty($request->status)) ? true : false;
            $query->where('is_active', $status);
        }
        
        $sort = 'id';
        $order = 'DESC';
        if ((isset($request->sort) && $request->sort != '') || (isset($request->order) && $request->order != '')) {
            $sort = $request->sort;
            $order = $request->order;
        }
        
        $query->orderBy($sort, $order);

        // on page load
        $results = $query->sortable()->paginate(config('siteconstants.PER_PAGE_LIMIT'));

        return $results;
    }

    /**
     * get all roles
     */
    public static function roles() {

        $results = Role::get()->pluck('display_name', 'id');

        return $results;
    }

    /**
     * save record into database
     * @param object $request
     * @param string $randomPassword
     * @return User|boolean
     */
    public static function save($request) {

        $user = new User;
        
        $randomPassword = User::RandomAlphaNumericPassword(10);
            
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = Hash::make($randomPassword);
        $user->is_active = (!empty($request->is_active)) ? true : false;
        $user->remote_access = (!empty($request->remote_access)) ? true : false;
        
        if ($user->save()) {
            
            $user->roles()->sync($request->role);

            $user->permissions()->sync(config('user_modules.' . $request->role));
            
            // send email
            $to = $user->email;
            $data = array(
                'name' => $user->first_name,
                'email' => $user->email,
                'randomPassword' => $randomPassword,
            );
            Mail::to($to)->send(new Registration($data));
                
            return $user;
        } else {
            return false;
        }
    }

    /**
     * update record into database
     * @param type $request
     * @return User|boolean
     */
    public static function update($request) {

        $all = $request->all();
            
        $user = User::findOrFail($all['id']);

        $user->first_name = $all['first_name'];
        $user->last_name = $all['last_name'];
        $user->mobile = $all['mobile'];
        $user->is_active = (!empty($all['is_active'])) ? true : false;
        $user->remote_access = (!empty($request->remote_access)) ? true : false;
            
        if ($user->save()) {
            
            $user->roles()->sync($all['role']);
            
            return $user;
        } else {
            return false;
        }
    }
    
    /**
     * export database records in pdf
     * @param object $request
     * @return pdf
     */
    public static function export_PDF($request) {

        $titles = ['Name', 'Email', 'Mobile'];

        $results = User::all();

        $data = [];
        foreach ($results as $user) {
            $data[] = array(
                $user['first_name'] . ' ' . $user['last_name'],
                $user['email'],
                $user['mobile'],
            );
        }

        $filename = 'users';

        return PDFHelpers::export_PDF($titles, $data, $filename);
    }
    
    /**
     * export database records in csv
     * @param object $request
     * @return pdf
     */
    public static function export_csv($request) {

        $filename = 'users.csv';

        $titles = array('Name', 'Email', 'Mobile');

        $results = User::all();

        $data = array();
        foreach ($results as $user) {
            $data[] = array(
                $user['first_name'] . ' ' . $user['last_name'],
                $user['email'],
                $user['mobile'],
            );
        }

        return CsvHelpers::export_csv($titles, $data, $filename);
    }
    
}
