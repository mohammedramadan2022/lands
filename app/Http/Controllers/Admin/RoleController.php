<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    //
    use ResponseTrait;


    public function __construct()
    {
//        $this->middleware('check.permission:roles')->only(['index','create','store','edit','update','destroy']);

    }


    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admins = Role::query()->latest();
            return DataTables::of($admins)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';


                    return '
                            <button ' . $edit . '  class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                    data-id="' . $row->id . '"
                          	<span class="svg-icon svg-icon-3">
								<svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd"><path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/></svg>
							</span>
                            </button>
                            <button ' . $delete . '  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
							   <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/></svg>
							</span>
                            </button>
                       ';


                })

                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.roles.index');
    }


    public function create()
    {
        $permission=Permission::get();

        return view('Admin.CRUDS.roles.parts.create',compact('permission'));
    }

    public function store(RoleRequest $request)
    {
        $data = $request->validationData();

        unset($data['permission']);

        $row = Role::create($data);

        $role=Role::findOrFail($row->id);

        $permissionIds = $request->input('permission');

        if ($permissionIds === null) {
            // If $permissionIds is null, remove all permissions from the role
            $role->syncPermissions([]);
        } else {
            $permissions = Permission::whereIn('id', $permissionIds)->get();

            if ($permissions->count() === count($permissionIds)) {
                // Handle the case where some permissions are not found
                $role->syncPermissions($permissions);
            } else {

//                return $this->addErrorResponse('Some permissions not found');
            }
        }


        return $this->addResponse();
    }



    public function show($id)
    {


        //
    }


    public function edit($id)
    {

        $role=Role::findOrFail($id);
        $permission=Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->get();

        return view('Admin.CRUDS.roles.parts.edit', compact('role','permission','rolePermissions'));

    }

    public function update(RoleRequest $request, $id)
    {

        $data = $request->validationData();

        unset($data['permission']);
        $role=Role::findOrFail($id);



        $role->update($data);


        $role=Role::findOrFail($id);

        $permissionIds = $request->input('permission');

        if (empty($permissionIds)) {
            // If $permissionIds is empty, remove all permissions from the role
            $role->syncPermissions([]);
        } else {
            // If $permissionIds is not empty, proceed with updating permissions
            $permissions = Permission::whereIn('id', $permissionIds)->get();

            if ($permissions !== null && count($permissions) == count($permissionIds)) {
                // Handle the case where some permissions are not found
                $role->syncPermissions($permissions);
            }
        }



        return $this->updateResponse();


    }


    public function destroy($id)
    {
        Role::findOrFail($id)->delete();

        return $this->deleteResponse();
    }//end fun




}
