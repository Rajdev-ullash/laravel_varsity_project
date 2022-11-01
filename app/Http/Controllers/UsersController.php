<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Session;
class UsersController extends Controller
{
    public function home(){
        return view('home.home');
    }
    public function teacherRegister(){
        return view('users.teacherRegister');
    }
    public function teacherLogin(){
        return view('users.teacherLogin');
    }
    public function studentRegister(){
        return view('users.studentRegister');
    }
    public function studentLogin(){
        return view('users.studentLogin');
    }

    public function adminLogin(){
        return view('users.adminLogin');
    }

    public function store(Request $request){
        $obj = new User();
        $obj->name = $request->name;
        $obj->uid = intval($request->uid);
        $obj->email = $request->email;
        $obj->role = $request->role;
        $obj->password = md5($request->password);

        if($obj->save()){
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully'
            ]);

        }
        // else{
        //     return response()->json([
        //         'status' => $obj,
        //         'message' => 'User not created'
        //     ]);
        // }

    }

    public function userLogin(Request $request){
        $email = $request->email;
        $pass = $request->password;

        $user = User::where('email','=',$email)
                ->where('password','=', md5($pass))
                ->first();
        // dd($user);
        if($user){
            if($user->active == 0){
               return response()->json([
                'status' => 'error',
                'message' => 'Account not approved yet by admin'
            ]);
            }
            else{
                $request->session()->put('username',$user->name);
                $request->session()->put('userrole',$user->role);
                $request->session()->put('userid',$user->id);
                $request->session()->put('useremail',$user->email);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful'
                ]);
            }
        }
        else{
            return response()->json([
                    'status' => 'err',
                    'message' => 'Email or password not matched'
                ]);
        }

        
       

    }

    public function adminLoginStore(Request $request){
        $email = $request->email;
        $pass = $request->password;

        $user = Admin::where('email','=',$email)
                ->where('password','=', $pass)
                ->first();
        // dd($user);
        if($user){
                $request->session()->put('username',$user->name);
                $request->session()->put('userrole',$user->role);
                $request->session()->put('userid',$user->id);
                $request->session()->put('useremail',$user->email);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login successful'
                ]);
            
        }
        else{
            return response()->json([
                    'status' => 'err',
                    'message' => 'Email or password not matched'
                ]);
        }

        
       

    }

        
}
