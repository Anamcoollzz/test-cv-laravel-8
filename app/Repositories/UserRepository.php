<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserRepository
{

    /**
     * create user data
     *
     * @param array $data
     * @return User
     */
    public function create(array $data)
    {
        return User::create($data);
    }

    /**
     * get data as datatable object
     *
     * @param bool $isPublicUser
     * @return JsonResponse
     */
    public function getDataTable($isPublicUser = true)
    {
        $profile_picture = '{{Storage::url($profile_picture)}}';
        if ($isPublicUser) {
            $query = User::role(['user'])->with('roles');
        } else {
            $query = User::role([
                'administrator',
                'finance',
                'editor',
                'supervisor',
            ])->with('roles');
        }
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('profile_picture', $profile_picture)
            ->editColumn('email_verified_at', '{{Carbon\Carbon::parse($email_verified_at)->format("Y-m-d H:i:s")}}')
            ->make(true);
    }

    /**
     * find user data by id with roles
     *
     * @param mixed $id
     * @return User
     */
    public function findWithRoles($id)
    {
        $user = User::with(['roles'])->where('id', $id)->first();
        return $user;
    }

    /**
     * find user data by id
     *
     * @param mixed $id
     * @return User
     */
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * find user data by email
     *
     * @param string $email
     * @return User
     */
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * update user data by id
     *
     * @param mixed $id
     * @param array $data
     * @return User
     */
    public function update($id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    /**
     * delete user data by id
     *
     * @param mixed $id
     * @return boolean
     */
    public function delete($id)
    {
        $user = $this->find($id);
        if ($user) {
            return $user->delete();
        }
        return false;
    }

    /**
     * get all roles from db
     *
     * @return Collection
     */
    public function allRoles()
    {
        return Role::all()->pluck('name');
    }

    /**
     * user count
     *
     * @return int
     */
    public function count()
    {
        return User::count();
    }
}
