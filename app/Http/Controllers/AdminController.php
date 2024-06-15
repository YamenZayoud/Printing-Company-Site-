<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Repositories\PublicRepository;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\AdminIdRequest;
use App\Http\Requests\Admin\AdminLoginRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Admin\AdminCreateRequest;
use App\Http\Resources\Admin\AdminLoginResource;
use App\Http\Resources\Admin\ShowAdminsResource;
use App\Http\Requests\Admin\ShowAllAdminsRequest;
use App\Http\Resources\Admin\ShowOneAdminResource;
use App\Http\Requests\Admin\UpdateAdminInfoRequest;
use App\Http\Requests\Admin\UpdateAdminPermissionsRequest;

class AdminController extends Controller
{

    public function __construct(public PublicRepository $repository)
    {
        $this->middleware('permission:Admin Management',
            ['only' => ['Create','Update', 'DeleteById', 'ActiveOrNot', 'ShowById', 'ShowAdminPermissions', 'UpdateAdminPermissions', 'ShowAll']]);
    }

    public function Login(AdminLoginRequest $request)
    {
        $arr = Arr::only($request->validated(), ['email', 'password']);
        $where = ['email' => $arr['email']];
        $admin = $this->repository->ShowAll(Admin::class, $where)->first();
        if (!Hash::check($arr['password'], $admin->password)) {
            throw ValidationException::withMessages([__('auth.password')]);
        }
        $admin['token'] = $admin->createToken('authToken', ['Admin'])->accessToken;
        $admin['permissions'] = $admin->permissions()->pluck('name');
        return \SuccessData(__('auth.Login'), new AdminLoginResource($admin));
    }

    public function Logout()
    {

        $admin = \auth('Admin')->user();
        $admin->tokens()->where('scopes', '["Admin"]')->delete();
        return \Success(__('auth.Logout'));
    }


    public function Create(AdminCreateRequest $request)
    {
        $arr = Arr::only($request->validated(), ['name', 'email', 'password','permissions']);
        $arr['created_by'] = \auth()->user()->id;
        $admin = $this->repository->Create(Admin::class, $arr);
        $permissionNames = Permission::whereIn('uuid', $arr['permissions'])->pluck('name')->toArray();
        $admin->givePermissionTo($permissionNames);
        return \Success(__('auth.register'));
    }

    public function DeleteById(AdminIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['adminId']);
        $this->repository->DeleteById(Admin::class, $arr['adminId']);
        return \Success(__('admin.deleted'));
    }

    public function ShowAll(ShowAllAdminsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['search', 'active']);
        $perPage = \returnPerPage();
        $where = [];
        if (\array_key_exists('search', $arr)) {
            $where = \array_merge($where, [['name', 'like', '%' . $arr['search'] . '%']]);
        }
        if (\array_key_exists('active', $arr)) {
            $where = \array_merge($where, ['is_active' => $arr['active']]);
        }

        $admins = $this->repository->ShowAll(Admin::class, $where)->paginate($perPage);
        ShowAdminsResource::collection($admins);
        return \Pagination($admins);
    }


    public function ActiveOrNot(AdminIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['adminId']);
        $this->repository->ActiveOrNot(Admin::class, $arr['adminId']);
        return \Success(__('admin.admin_status'));
    }


    public function ShowById(AdminIdRequest $request)
    {

        $arr = Arr::only($request->validated(), ['adminId']);
        $admin = $this->repository->ShowById(Admin::class, $arr['adminId']);

        $admin['permissions'] = $admin->permissions()->get(['uuid', 'name']);

        foreach ($admin['permissions'] as $permission) {
            unset($permission->pivot);
        }
        $admin = new ShowOneAdminResource($admin);
        return \SuccessData(__('admin.admin_found'), $admin);
    }


    public function ShowAdminPermissions(AdminIdRequest $request)
    {
        $arr = Arr::only($request->validated(), ['adminId']);
        $admin = $this->repository->ShowById(Admin::class, $arr['adminId']);
        $permissions = $admin->permissions()->get(['uuid', 'name']);
        foreach ($permissions as $permission) {
            unset($permission->pivot);
        }
        return \SuccessData(__('admin.admin_permissions'), $permissions);
    }


    public function UpdateAdminPermissions(UpdateAdminPermissionsRequest $request)
    {
        $arr = Arr::only($request->validated(), ['adminId', 'permissions']);
        $admin = $this->repository->ShowById(Admin::class, $arr['adminId']);
        $permissionsName = Permission::whereIn('uuid', $arr['permissions'])->get();
        $admin->syncPermissions($permissionsName);
        return \Success(__('admin.update_permissions'));
    }

    public function Update(UpdateAdminInfoRequest $request)
    {
        $arr = Arr::only($request->validated(), ['adminId', 'name', 'email']);
        $this->repository->update(Admin::class, $arr['adminId'], $arr);
        return \Success(__('admin.admin_update'));
    }

    public function ShowAllPermission()
    {
        $permissions = $this->repository->ShowAll(Permission::class, [])->get(['uuid', 'name']);
        return \SuccessData(__('public.permission_found'), $permissions);
    }

}
