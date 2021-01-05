<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    /**
     * showing profile page
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePicture = $user->profile_picture;
        if (is_null($profilePicture)) {
            $profilePicture = false;
        } elseif (!Storage::exists($profilePicture)) {
            $profilePicture = false;
        } else {
            $profilePicture = Storage::url($profilePicture);
        }
        if (Auth::user()->hasRole('user')) {
            $view = 'profile.public-user';
        } else {
            $view = 'profile.index';
        }
        return view($view, compact('user', 'profilePicture'));
    }

    /**
     * update user login profile
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $request->validate(
            [
                'name'            => 'required',
                'email'           => 'required|email',
                // 'password'        => 'required|min:5',
                'profile_picture' => 'nullable|file|image',
                'address'         => 'nullable',
                'phone_number'    => 'nullable',
            ]
        );
        $data = $request->only([
            'name',
            'email',
            'password',
            'address',
            'phone_number',
        ]);
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $request->profile_picture->store('public/users');
        }
        $this->userRepository->update(Auth::id(), $data);
        activity()
            ->causedBy(Auth::user())
            ->log('Update profile');
        return back()->with('success_message', 'Success update profile');
    }

    /**
     * update user login password
     *
     * @param Request $request
     * @return Response
     */
    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'password'              => 'required|min:5',
                'password_confirmation' => 'required|min:5|same:password',
            ]
        );
        $data = [
            'password' => bcrypt($request->password)
        ];
        $this->userRepository->update(Auth::id(), $data);
        return back()->with('success_message', 'Success update password');
    }
}
