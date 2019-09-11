<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\User;

class UserController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        ##from http://www.php-dev-zone.com/2018/02/lumen-rest-api-authentication.html
        $this->validate($request, [
        'email'    => 'required',
        'password' => 'required'
       ]);
      
        $user = User::where('email', $request->input('email'))->first();
      
        if(Hash::check($request->input('password'), $user->password)){
         $apikey = str_random(32);
         User::where('email', $request->input('email'))->update(['api_token' => $apikey]);
         
         return response()->json(['status' => 'success','api_token' => $apikey,
            'isSuper' => $user['isSuper'],'isUser' => $user['isUser']]);
        }else{
      
            return response()->json(['status' => 'fail'],401);
        }
      }

    public function list(){
        if(Gate::allows('trySuper', Auth::user())){
                return response()->json(User::all());
        }
        else return "No auth";

    }

    public function create(Request $request)
    {
        if(Gate::allows('trySuper', Auth::user())){
            $newuser = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'isSuper' => False,
            'isUser' => $request['isUser'],
            'api_token' => str_random(255),
            ]);
            return "AlgumUserFoiCriado";
        }
        
        else{return "error";}
            
        
    }

    public function edit(Request $request, $id){
        if(Gate::allows('trySuper', Auth::user())){
            $user = User::find($id);
            $user->update(['isUser' => $request['isUser']]);
        }
    }
}