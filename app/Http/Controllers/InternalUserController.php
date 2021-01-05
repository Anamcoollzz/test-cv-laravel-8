<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InternalUserController extends Controller
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->userRepository->getDataTable(false);
        }
        $roles = $this->userRepository->allRoles();
        return view('internal-user.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users,email',
            'phone_number'          => 'required',
            'address'               => 'nullable',
            'password'              => 'required|confirmed',
            'password_confirmation' => 'required',
            'roles'                 => 'required|array'
        ]);
        $data    = $request->only([
            'name',
            'email',
            'phone_number',
            'address',
        ]);
        $data['password']          = bcrypt($request->password);
        $data['email_verified_at'] = date('Y-m-d H:i:s');
        // if ($request->hasFile('product_image'))
        //     $data['product_image'] = $request->product_image->store('public/expense');
        $user    = $this->userRepository->create($data);
        $user->assignRole($request->roles);
        activity()
            ->causedBy(Auth::user())
            ->log('Create user');
        return response()->json([
            'message' => 'User success created',
            'data'    => $user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return $this->userRepository->findWithRoles($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $this->userRepository->find($id);
        $request->validate([
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'phone_number'          => 'required',
            'address'               => 'nullable',
            'password'              => 'nullable|confirmed',
            'password_confirmation' => 'nullable',
            'roles'                 => 'required|array'
        ]);
        $data    = $request->only([
            'name',
            'email',
            'phone_number',
            'address',
        ]);
        if ($request->password)
            $data['password']          = bcrypt($request->password);
        // if ($request->hasFile('product_image'))
        //     $data['product_image'] = $request->product_image->store('public/expense');
        $user    = $this->userRepository->update($id, $data);
        $roles = $this->userRepository->allRoles();
        foreach ($roles as $role) {
            $user->removeRole($role);
        }
        $user->assignRole($request->roles);
        activity()
            ->causedBy(Auth::user())
            ->log('Update user');
        return response()->json([
            'message' => 'User success updated',
            'data'    => $user,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = $this->userRepository->find($id);
        if ($expense) {
            if (Storage::exists($expense->image)) {
                Storage::delete($expense->image);
            }
            activity()
                ->causedBy(Auth::user())
                ->log('Delete user');
            return $this->userRepository->delete($id);
        }
        return false;
    }
}
