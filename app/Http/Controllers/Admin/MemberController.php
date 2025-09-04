<?php
// app/Http/Controllers/OwnerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\MemberRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Camel;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $members = Member::query()->latest();
            return Datatables::of($members)
                ->addColumn('action', function ($member) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $member->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
                    <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $member->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>



                ';
                })
                ->editColumn('image', function ($admin) {
                    return '
                              <a data-fancybox="" href="'.get_file($admin->image).'">
                                <img height="60px" src="'.get_file($admin->image).'">
                            </a>
                             ';
                })


                ->editColumn('is_active', function ($row) {
                    $active = $row->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="' . $row->id . '" type="checkbox" role="switch" id="flexSwitchCheckChecked" ' . $active . '>
                        </div>';
                })
                ->editColumn('created_at', function ($member) {
                    return date('Y/m/d', strtotime($member->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.member.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.member.parts.create');
    }

    public function store(MemberRequest $request)
    {
        // Get validated data
        $data = $request->validated();

        // Hash the password
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        // Create the member
        $member = Member::create($data);

        // Upload the image
        $file  = $request->file('image');
        $image = $this->uploadFiles('members/' . $member->id, $file, null);

        $member->update([
            'image' => $image,
        ]);

        return $this->addResponse();
    }

    public function show(Member $owner)
    {
        return view('owners.show', compact('owner'));
    }

    public function edit(Member $member)
    {

        return view('Admin.CRUDS.member.parts.edit', compact('member'));
    }

    public function update(MemberRequest $request, Member $member)
    {
        // Get validated data
        $data = $request->validated();

        // Handle password - only update if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            // Remove password from data if it's empty to avoid updating with empty string
            unset($data['password']);
        }

        // Update the member
        $member->update($data);

        // Handle image upload if provided
        if ($request->image) {
            $file = $request->file('image');
            $image = $this->uploadFiles('members/' . $member->id, $file, null);
            $member->update([
                'image' => $image,
            ]);
        }

        return $this->addResponse();
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('member.index')->with('success', 'Member deleted successfully.');
    }


    public function activate(Request $request)
    {

        $member = Member::findOrFail($request->id);
        $member->is_active == 1 ?  $member->is_active =0 :  $member->is_active = 1;
        $member->save();
        return $this->successResponse();
    }//end fun



    public function showCamels (Request $request , $owner)
    {

        if ($request->ajax()) {
            $camels = Camel::where('owner_id' , $owner)->with('owner')->latest();
            return Datatables::of($camels)
                ->addColumn('action', function ($camel) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $camel->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>
  <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete" data-id="' . $camel->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336">
                                <path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/>
                            </svg>
                        </span>
                    </button>
                ';
                })


                ->editColumn('created_at', function ($owner) {
                    return date('Y/m/d', strtotime($owner->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }

        return view('Admin.CRUDS.camel.index' ,compact('owner'));
    }

}
