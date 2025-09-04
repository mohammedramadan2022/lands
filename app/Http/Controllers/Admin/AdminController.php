<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\UpdatePasswordRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {


        if ($request->ajax()) {
            $admins = Admin::query()->latest();
            return Datatables::of($admins)
                ->addColumn('action', function ($admin) {

                    $edit = '';
                    $delete = '';


                    return '
                            <button ' . $edit . '  class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                                    data-id="' . $admin->id . '"
                          	<span class="svg-icon svg-icon-3">
								<svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd"><path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/></svg>
							</span>
                            </button>
                            <button ' . $delete . '  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete"
                                    data-id="' . $admin->id . '">
                            <span class="svg-icon svg-icon-3">
							   <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/></svg>
							</span>
                            </button>
                       ';


                })
                ->editColumn('image', function ($admin) {
                    return '
                              <a data-fancybox="" href="' . get_file($admin->image) . '">
                                <img height="60px" src="' . get_file($admin->image) . '">
                            </a>
                             ';
                })

                ->addColumn('roles', function ($admin) {

                    return $admin->getRoleNames()->implode('-'); // الحصول على الأدوار وعرضها
                })


                ->editColumn('password', function ($row) {

                    return "<button data-id='$row->id' class='badge badge-danger changePassword'>تغير كلمة المرور</button>";
                })

                ->editColumn('is_active', function ($row) {
                    $active = '';
                    $operation = '';

                    $operation = '';


                    if ($row->is_active == 1)
                        $active = 'checked';

                    return '<div class="form-check form-switch">
                               <input ' . $operation . '  class="form-check-input activeBtn" data-id="' . $row->id . ' " type="checkbox" role="switch" id="flexSwitchCheckChecked" ' . $active . '  >
                            </div>';
                })
                ->editColumn('created_at', function ($admin) {
                    return date('Y/m/d', strtotime($admin->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.admin.index');
    }


    public function create()
    {

        $roles = Role::where('guard_name','admin')->get();


        return view('Admin.CRUDS.admin.parts.create',compact('roles'));
    }

    public function store(AdminRequest $request)
    {
        $data = $request->validationData();
        if ($request->image)
            $data["image"] = $this->uploadFiles('admins', $request->file('image'), null);

        $data['password'] = bcrypt($request->password);

        unset($data['roles']);



        $admin = Admin::create($data);


        $admin->roles()->sync($request->input('roles'));


        return $this->addResponse();

    }


    public function show(Admin $admin)
    {

        $html = view('Admin.CRUDS.admin.parts.show', compact('admin'))->render();
        return response()->json([
            'code' => 200,
            'html' => $html,
        ]);

        //
    }


    public function edit(Admin $admin)
    {

        $admin_roles_ides = DB::table("model_has_roles")->where("model_has_roles.model_id", $admin->id)
            ->where('model_type','App\Models\Admin')  ->pluck('role_id');


        $roles = Role::where('guard_name','admin')->get();


        return view('Admin.CRUDS.admin.parts.edit', compact('admin','roles','admin_roles_ides'));

    }

    public function update(AdminRequest $request, $id )
    {

        $admin=Admin::findOrFail($id);
        $data = $request->validationData();
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $admin->password;
        }
        if ($request->image) {
            $data["image"] = $this->uploadFiles('admins', $request->file('image'), 'yes');

        }

        unset($data['roles']);

        $admin->update($data);

        $admin=Admin::findOrFail($id);



        $admin->roles()->sync($request->input('roles'));


        $html = view('Admin.CRUDS.admin.parts.header')->render();

        return response()->json(
            [
                'code' => 200,
                'message' => 'تمت العملية بنجاح!',
                'html' => $html,
                'name' => $admin->name,
                'logo' => get_file($admin->image),
            ]);
    }


    public function destroy($id)
    {
        $row = Admin::findOrFail($id);

        if (file_exists($row->image)) {
            unlink($row->image);
        }

        $row->delete();

        return $this->deleteResponse();
    }//end fun


    public function activate(Request $request)
    {

        $admin = Admin::findOrFail($request->id);
        if ($admin->is_active == true) {
            $admin->is_active = 0;
            $admin->save();
        } else {
            $admin->is_active = 1;
            $admin->save();
        }

        return $this->successResponse();
    }//end fun

    public function editPassword($id)
    {
       $row= Admin::findOrFail($id);
        return view('Admin.CRUDS.admin.parts.password', compact('row'));

    }


    public function updatePassword(UpdatePasswordRequest $request,$id )
    {
        $admin=Admin::findOrFail($id);

        $admin->update([
            'password'=>bcrypt($request->password),
        ]);

        return $this->updateResponse();
    }



}//end class
