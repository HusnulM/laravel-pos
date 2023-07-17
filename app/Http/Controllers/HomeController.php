<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use DB;
use Validator,Redirect,Response;

class HomeController extends Controller
{
    public function index(){
        if(Auth::check()){
            return redirect()->intended('dashboard');
        }
        return view('login');
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function login(Request $request){
        // return $request;
        $input = $request->all();
        $request->validate([
            'username' => 'required',
            'password' => 'required|string'
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'user_id';

        $options = [
            'cost' => 12,
        ];
        // $password = password_hash($request['password'], PASSWORD_BCRYPT, $options);
        $password = md5($request['password']);
        // return $password;
        // $credentials = $request->only('email', 'password');

        // $dataAttempt = array(
        //     'email'    => strtolower($request['email']),
        //     'password' => $request['password']
        // );
        $checkUser = DB::table('users')
                    ->where('user_id', $request->username)
                    ->where('password', $password)
                    ->first();
        if($checkUser){
            $user = User::where('user_id', $request->username)->first();
            // return $user;
            Auth::login($user);
            return redirect()->intended('dashboard');
        }else{
            return Redirect::back()
                ->withErrors(
                    [
                        'error' => 'Opps! You have entered invalid credentials',
                    ]
                );
        }

        // if ($request->password == 'hahahaha') {
        //     $user = User::where('user_id', $request->username)->first();
        //     if ($user === null) {
        //         return Redirect::back()
        //         ->withErrors(
        //             [
        //                 'error' => 'Opps! You have entered invalid credentials',
        //             ]
        //         );
        //     }
        //     Auth::login($user);
        //     return redirect()->intended('dashboard');
        // }

        // if (Auth::attempt(array($fieldType => $input['username'], 'password' => $password))) {
        //     if(Auth::user()->inactive === "0"){
        //         Auth::logout();
        //         return Redirect::back()
        //         ->withErrors(
        //             [
        //                 'error' => 'Opps! Your account is deleted, please contact System Administrator',
        //             ]
        //         );
        //     }else{
        //         return redirect()->intended('dashboard');
        //     }
        // }else{
        //     return Redirect::back()
        //         ->withErrors(
        //             [
        //                 'error' => 'Opps! You have entered invalid credentials',
        //             ]
        //         );
        // }
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function home(){
        if(Auth::check()){
            $nama = $nama = Auth::user()->name;
            return view('home.index',['nama' => $nama]);
        }
        return Redirect::to("login")->withErrors('Opps! You do not have access');
    }
}
