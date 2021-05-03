<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function list($id=null){

        //return $id ? User::find($id) : User::orderBy('id', 'DESC')->get();

        if ($id) {
            $data = User::find($id);
            // print_r($data);
            // echo 'Test';
            // exit;
            if (!empty($data)) {
                return response(['msg' => 'success', 'data' => $data], 200);
            }else{
                return response(['msg' => 'not found', 'data' => $id], 404);
            }
            
        }else{
            $data = User::orderBy('id', 'DESC')->get();
            return response(['msg' => 'success', 'data' => $data], 200);
        }

    }

    public function create(Request $req){
        //
        $user = new User;
        $rules = array(
            "name" => 'required',
            "email" => 'required|unique:users',
            "password" => 'required',
        );
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }else{
            $user->name = $req->get('name');
            $user->email = $req->get('email');
            $user->status = 1;
            $user->password = Hash::make($req->get('password'));
            $user->save();
            if ($user) {
                return response(['msg' => 'User created'], 201);
            }else{
                return response(['msg' => 'Internal server error'], 500);
            }
        }
       
    }

    
    public function update(Request $request, $id){
        // echo 'tst';
        // exit;
        $user = User::find($id);
        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }else{
           if ( !empty($user) || !$user == null ) {
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->save();
               return response(['msg' => 'Update successfuly', 'user' => $user], 200);
            }else{
                return response(['msg' => 'User Not Found'], 404);
            } 
            
        }
    }

    // soft delete 
    public function delete($id){
        $data = User::find($id);
        if ($id) {
           if ( !empty($data) ) {
                DB::table('users')->where('id', $id)->update(['status' => 0]);
                $user = User::findOrFail($id);
                $user->delete();
                // 'deleted_at' => $user->deleted_at;
                return response()->json(['msg'=> 'user deleted successfuly','deleted_at' => $user->deleted_at], 200);
            }else{
                return response(['msg' => 'User not found'],404);
            }
        }else{
            return response(['msg' => 'inter server error'],500);
        }
        
    }

    // permanent delete 
    public function destroy($id){
        $user = User::find($id);
        // return $user;
        if ( !empty($user) ) {
            $result = $user->forceDelete();
            return response(['msg'=> $id.' id of user deleted successfuly'],200);
        }else{
            return response(['msg' => 'User not found'],404);
        }
    }

    public function restore($id){
        User::withTrashed()->find($id)->restore();
        return response()->json(['msg'=> 'user restored successfuly'], 200);

    }
}