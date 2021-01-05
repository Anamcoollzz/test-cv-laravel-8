<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|exists:users',
            'password' => 'required',
        ]);
        $user = $this->userRepository->findByEmail($request->email);
        if ($user->hasRole(['administrator', 'editor', 'finance', 'supervisor'])) {
            $isSame = Hash::check($request->password, $user->password);
            if (!$isSame) {
                $validator = Validator::make($request->all(), []);
                $validator->errors()->add('password', 'Password is not match');
                return back()->withErrors($validator)->withInput();
            }
            Auth::login($user, $request->filled('remember'));
            return redirect('/dashboard');
        }
        $validator = Validator::make($request->all(), []);
        $validator->errors()->add('email', 'Email is not registered');
        return back()->withErrors($validator)->withInput();
    }

    public function formLogin()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    // public function register(Request $request)
    // {
    //     $request->validate([
    //         'name'                  => 'required',
    //         'email'                 => 'required|email|unique:users',
    //         'password'              => 'required|min:5',
    //         'password_confirmation' => 'required|min:5|same:password',
    //         'address'               => 'required',
    //         'phone_number'          => 'required',
    //     ]);
    //     $data = $request->only([
    //         'name',
    //         'email',
    //         'address',
    //         'phone_number',
    //     ]);
    //     $data['password'] = bcrypt($request->password);
    //     $this->userRepository->create($data);
    //     return redirect('login');
    // }
}
