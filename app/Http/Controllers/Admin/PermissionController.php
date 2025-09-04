<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
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
            $admins = Permission::query()->latest();
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
        return view('Admin.CRUDS.permission.index');
    }


    public function create()
    {

        return view('Admin.CRUDS.permission.parts.create');
    }

    public function store(PermissionRequest $request)
    {
        $data = $request->validationData();

        Permission::create($data);

        return $this->addResponse();

    }





    public function edit( Permission $permission )
    {


        return view('Admin.CRUDS.permission.parts.edit', ['row' => $permission]);

    }

    public function update(PermissionRequest $request,  Permission $permission)
    {
        $data=$request->validationData();

        $permission->update($data);

        return $this->updateResponse();

    }


    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->deleteResponse();
    }//end fun

}
