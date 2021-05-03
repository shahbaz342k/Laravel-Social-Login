<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    public function login(){
    	// echo Hash::make('admin');
    	// die;
    	if(session()->has('ADMIN_USER_ID')){
            return redirect('/admin/dashboard');
        }
    	return view('admin.login');
    }
    public function login_submit(Request $request){

    	$validate_arr = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $email = $request->get('email');
        $password = $request->get('password');
        $remember_me = $request->get('admin_remember_me');
        $result = DB::table('admins')->where('email', $email)->get();
        // print_r($result);
        // die;
        if(isset($result[0]->id)){

            if( Hash::check($password,$result[0]->password) ){
                $request->session()->flash('msg', 'Welcome Admin');
                $request->session()->put('ADMIN_USER_ID', $result[0]->id);
                $request->session()->put('ADMIN_USER_EMAIL', $result[0]->email);
                if($remember_me){
                    $cookie_time = time()+60*60*24*7; // 7 days;
                    setcookie('admin_email', $email, $cookie_time);
                    setcookie('admin_pass', $password, $cookie_time);
                }else{
                    setcookie('admin_email', $email, time()-60);
                    setcookie('admin_pass', $password, time()-60);
                }
                return redirect('admin/dashboard');
            }else{
                $request->session()->flash('msg', 'Password not matched');
                return redirect('admin/login');
            }
        }else{
            $request->session()->flash('msg', 'Please enter valid credentials');
            return redirect('admin/login');
        }
    
    }

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function logout(){
        session()->forget('ADMIN_USER_ID');
        session()->forget('ADMIN_USER_EMAIL');
        return view('admin.login');
    }

    public function list(){
        $data['users'] = DB::table('users')->orderBy('id', 'DESC')->get();
        return view('admin.users.list', $data);
    }
    public function create(){
        return view('admin.users.create');
    }
    public function create_submit(Request $request){
        // dd($request->all());

        $validate_arr = $request->validate([
            "name" => 'required',
            "email" => 'required|unique:users',
            "password" => 'required',
        ]);
        $data = array(
           'name' => $request->get('name'),           
           'email' => $request->get('email'),
           'password' => Hash::make($request->get('password')),
           'created_at' => date('Y-m-d h:i:s'),
           'status' => $request->get('status')
        );
        
        DB::table('users')->insert($data);
        $request->session()->flash('msg', 'User added successfully!');
        return redirect('admin/users');

    }

    public function edit_users($id){
        $data['user'] = DB::table('users')->find($id);
        // dd($data);
        // die;
        return view('admin.users.edit', $data);
    }

    public function update_users(Request $request, $id){

        $validate_arr = $request->validate([
            "name" => 'required',
            "email" => 'required',
        ]);
        $data = array(
           'name' => $request->get('name'),           
           'email' => $request->get('email'),
           'status' => $request->get('status'),
           'updated_at' => date('Y-m-d h:i:s'),
        );
        DB::table('users')->where('id', $id)->update($data);
        $request->session()->flash('msg', 'User Updated Sucessfuly !');
        return redirect('/admin/users');
    }

    public function delete_user(Request $request, $id){
        DB::table('users')->where('id', $id)->update(['status' => 0]);
        $user = User::findOrFail($id);
        $user->delete();
        // 'deleted_at' = $user->deleted_at;
       // return response()->json(['deleted_at' => $blog->deleted_at], 200);
        //DB::table("users")->where('id',$id)->delete();
        $request->session()->flash('msg', 'User Deleted Successfully');
        return redirect('/admin/users');
    }
    public function activeDeactive(Request $request, $id){
         $data = DB::table('users')->find($id);
         $status = $data->status;
         if ($status == 1) {
              DB::table('users')->where('id', $id)->update(['status' => 0]);
              $request->session()->flash('msg', 'User Deactive Sucessfuly !');
              
         }else{
            DB::table('users')->where('id', $id)->update(['status' => 1]);
            $request->session()->flash('msg', 'User Active Sucessfuly !');
         }
         
         return redirect('/admin/users');

    }

    public function Restore(Request $request, $id){
        User::withTrashed()->find($id)->restore();
        $request->session()->flash('msg', 'User Restore Sucessfuly !');
        return redirect('/admin/users');
    }

    public function profile(Request $request){

        $data['profile'] = Admin::find(session('ADMIN_USER_ID'));
        // $request->session()->flash('msg', 'User Restore Sucessfuly !');
        return view('admin.profile', $data);
    }

    public function updateProfile(Request $request, $id){

        $data = Admin::find($id);
        $validate_arr = $request->validate([
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);


        $data = array(
           'password' => Hash::make($request->get('password')),
           'updated_at' => date('Y-m-d h:i:s'),
        );
        // print_r($data);
        // exit;
        DB::table('admins')->where('id', $id)->update($data);
        $request->session()->flash('msg', 'Password Updated Sucessfuly !');
        return redirect('/admin/dashboard');
        // $request->session()->flash('msg', 'User Restore Sucessfuly !');
        
    }
    
}
