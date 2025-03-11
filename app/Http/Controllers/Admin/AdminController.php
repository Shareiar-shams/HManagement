<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // Add this line!
use App\Models\Admin\Admin;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends Controller // Extend the base Controller class
{
    use ValidatesRequests;

    // public function __construct()
    // {
    //     $this->middleware('permission:view admin user|create admin user|update admin user|delete admin user', ['only' => ['index', 'store']]);
    //     $this->middleware('permission:create admin user', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:update admin user', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:delete admin user', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $data = Admin::where('id', '!=', 1)->orderBy('id', 'DESC')->get();
        return view('admin.user.users.index', compact('data'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.user.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'phone' => 'required',
            'position' => 'nullable',
            'password' => 'required|same:c_password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['status'] = 1;

        $user = Admin::create($input);
        $user->syncRoles($request->roles);
        $user->assignRole($request->roles);
        $notification = array(
            'message' => 'User created successfully',
            'alert-type' => 'success',
        );
        return redirect(route('admins.index'))->with($notification);
    }

    public function show($id): View
    {
        $user = Admin::find($id);
        return view('admin.user.users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = Admin::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        return view('admin.user.users.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,' . $id,
            'phone' => 'required',
            'position' => 'nullable',
            'password' => 'same:c_password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = Admin::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->syncRoles($request->roles);
        $user->assignRole($request->roles);
        $notification = array(
            'message' => 'User updated successfully',
            'alert-type' => 'success',
        );
        return redirect(route('admins.index'))->with($notification);
    }

    public function destroy(string $id)
    {
        Admin::find($id)->delete();
        $notification = array(
            'message' => 'User deleted successfully',
            'alert-type' => 'success',
        );
        return redirect(route('admins.index'))->with($notification);
    }
}