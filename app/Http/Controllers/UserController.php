<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
// use App\Notifications\VerifyApiEmail;
use App\Models\User;
use SMTPValidateEmail\Validator as SmtpEmailValidator;
use Illuminate\Support\Facades\Validator;

use App\Models\Data;
// use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('nApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        }
        else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'role' => 'required'
        ]);

        if($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $userId = $user->id;
        if($input['role'] == 'admin') {
            $user->assignRole('admin');
        }
        if($input['role'] == 'anggota') {
            $user->assignRole('anggota');
        }
        if($input['role'] == 'penjual') {
            $user->assignRole('penjual');
        }

        event(new Registered($user));
        $success['message'] = "Please verify your email that we've sent to your mailbox";
        $success['token'] = $user->createToken('nApp')->accessToken;
        $success['name'] = $user->name;
        $success['role'] = $user->getRoleNames();
        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function logout(Request $request) {
        $logout = $request->user()->token()->revoke();
        if($logout) {
            return response()->json(['message' => 'successfully logged out']);
        } else {
            return response()->json(['error' => 'there is no token in authorization / token has been expired'], 401);
        }
    }

    public function details()
    {
        $user = Auth::user();
        $id = $user['id'];
        $user['role'] = $user->getRoleNames();
        $user['data'] = Data::where('user_id', $id)->get();
        unset($user['roles']);
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function allDetails()
    {
        $user = User::with('data')->get();
        // unset($user['role']);
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function getUsersByRole($role) {
        $roles = Role::where('name', $role)->get();
        $users = User::role($role)->with('data')->get();
        if(!$roles) {
            return response()->json(["error" => "There is no role with name " . $role], 404);
        }
        return response()->json(["user" => $users], 200);
    }

    public function delete(User $user)  //self deleting
    {
        $getuser = Auth::user();
        $id = $getuser['id'];
        $user = User::where('id',$id)->first();    
        if ($user->delete()) {
            return ["status" => "Berhasi Menghapus Data"];
        }  else {
            return ["status" => "Gagal Menghapus Data"];
        }
    }

    public function deleteMember($id)
    {      
        $user = User::where('id',$id)->first();    
        if ($user->delete()) {
            return ["status" => "Berhasi Menghapus Data"];
        }  else {
            return ["status" => "Gagal Menghapus Data"];
        }
    }

    public function updateProf(Request $request, User $user)
    { 
        $getuser = Auth::user();
        $userId = $getuser['id'];
        $update = User::where('id',$userId)->first();
        $update->name = $request->name;
        $update->email = $request->email;                    
        if ($update->update()) {
            return ["status" => "Berhasi Mengupdate Data"];
        }  else {
            return ["status" => "Gagal Mengupdate Data"];
        }
        return back();
    }   

    public function updatePass(Request $request, User $user)
    { 
        $getuser = Auth::user();
        $userId = $getuser['id'];
        // $userCpass = $getuser['c_password'];
        $update = $user->find($userId)->first();       
        $update->password = Hash::make($request->password);              
        // $update['c_password']  = 'same:password';
        if ($update->save()) {
            return ["status" => "Berhasi Mengubah Password"];
        }  else {
            return ["status" => "Gagal Mengubah Password"];
        }
        return back();
    }   


}
