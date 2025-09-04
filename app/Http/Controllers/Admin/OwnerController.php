<?php
// app/Http/Controllers/OwnerController.php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\OwnerRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Imports\ModammerImport;
use App\Models\Camel;
use App\Models\Owner;
use App\Models\ReservePayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\OwnerImport;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $admin = Auth::guard('admin')->user();
            $owners = Owner::query()
                ->when($request->type, function ($query) use ($request) {
                    $query->where('is_member', 1);

                })->when($request->search, function ($query) use ($request) {
                    $query->where('register_number', $request->search);
                    $query->orWhere('name', 'like', '%' . $request->search . '%');
                    $query->orWhere('phone', $request->search);
                    $query->orWhere('national_id', $request->search);
                })
                ->when($admin && $admin->id == 9, function ($query) {
                    $query->where('type', 'special');
                })
                ->latest();
            return Datatables::of($owners)
                ->addColumn('action', function ($owner) {
                    return '
                    <button class="editBtn btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-id="' . $owner->id . '">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
                                <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
                            </svg>
                        </span>
                    </button>




                ';
                })

                ->editColumn('camels', function ($owner) {
                    return '<a class="owner-link" href="' . route('owners.camels.index',
                            $owner->id) . '"><span class="fa fa-eye"></span></a>';
                })
                ->editColumn('is_active', function ($row) {
                    $active = $row->is_active == 1 ? 'checked' : '';
                    return '<div class="form-check form-switch">
                           <input class="form-check-input activeBtn" data-id="' . $row->id . '" type="checkbox" role="switch" id="flexSwitchCheckChecked" ' . $active . '>
                        </div>';
                })
                ->editColumn('is_member', function ($row) {
                    return ownerTypes($row->is_member);
                })
                ->editColumn('type', function ($row) {
                    return $row->type;
                })
                ->editColumn('created_at', function ($owner) {
                    return date('Y/m/d', strtotime($owner->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.owner.index');
    }

    public function create()
    {
        return view('Admin.CRUDS.owner.parts.create');
    }

    public function store(OwnerRequest $request)
    {
        $data = $request->validated();

        // Ensure modammer_name is set since the DB column is non-nullable but hidden from CRUD
        $data['modammer_name'] = 'نفسة';

        $data['password'] = $request->filled('password') ? bcrypt($request->password) : null;

        $owner = Owner::create($data);
        if (auth()->guard('admin')->user()->id == 9) {
            $owner->type = 'special';
            $owner->save();
        }
        return $this->addResponse();
    }

    public function show(Owner $owner)
    {
        return view('owners.show', compact('owner'));
    }

    public function edit(Owner $owner)
    {

        return view('Admin.CRUDS.owner.parts.edit', compact('owner'));
    }

    public function update(OwnerRequest $request, Owner $owner)
    {
        $owner->update($request->validated());
        if ($request->filled('password')) {
            $owner->update(['password' => bcrypt($request->password)]);
        }
        return $this->addResponse();
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index')->with('success', 'Owner deleted successfully.');
    }


    public function activate(Request $request)
    {

        $owner = Owner::findOrFail($request->id);
        $owner->is_active == 1 ? $owner->is_active = 0 : $owner->is_active = 1;
        $owner->save();
        return $this->successResponse();
    }//end fun


    public function showCamels(Request $request, $owner)
    {

        if ($request->ajax()) {
            $camels = Camel::where('owner_id', $owner)->with('owner')->latest();
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
                    <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" href="' . route('print-camel', $camel->id) . '" target="_blank">
                        <span class="svg-icon svg-icon-3">
                            <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#4caf50">
                                <path d="M19 8H5c-1.66 0-3 1.34-3 3v4h4v4h12v-4h4v-4c0-1.66-1.34-3-3-3zm-3 9H8v-5h8v5zm3-13H5V1h14v3z"/>
                            </svg>
                        </span>
                    </a>
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

        return view('Admin.CRUDS.camel.index', compact('owner'));
    }


    public function ownerReservations(Request $request)
    {

//        dd($request->all());
        if ($request->ajax()) {
            $owners = ReservePayment::query()->with('owner')
                ->when($request->search, function ($query) use ($request) {
                    $query->whereHas('owner', function ($query) use ($request) {

                        $query->where('owners.register_number', $request->search);
                        $query->orWhere('owners.name', 'like', '%' . $request->search . '%');
                        $query->orWhere('owners.phone', 'like', '%' . $request->search . '%');
                    });
                })
                ->latest();
            return Datatables::of($owners)
                ->escapeColumns([])
                ->make(true);
        }
        return view('Admin.CRUDS.owner.payment-reservation');
    }


    public function UploadExcel()
    {
        return view('Admin.CRUDS.owner.uploadExcel');

    }

    public function UploadExcelModammer()
    {
        return view('Admin.CRUDS.owner.uploadExcelModammer');

    }


    public function UploadExcelCamels(Request $request)
    {

        ini_set('memory_limit', '512M');
        $this->validate($request, [
            'sheet' => 'required',
        ]);

        if ($request->file('sheet')->isValid()) {
            $file = $request->file('sheet');
            $name_one = 'excel/upload/';
            $extension = $file->getClientOriginalExtension();                   // getting file extension
            $fileName = 5 . '-' . rand(11111111, 99999999) . '.' . $extension; // renameing file
            $file->move($name_one, $fileName);                                  // uploading file to given path


            $data = $this->import($name_one . $fileName, $request, $file->getClientOriginalName());
            if ($data['status']) {
                return $this->addResponse();
            } else {

                return $this->errorResponse();

            }

        }
    }

    public function UploadExcelTrainer(Request $request)
    {
        ini_set('memory_limit', '512M');
        $this->validate($request, [
            'sheet' => 'required',
        ]);

        if ($request->file('sheet')->isValid()) {
            $file = $request->file('sheet');
            $name_one = 'excel/upload/';
            $extension = $file->getClientOriginalExtension();                   // getting file extension
            $fileName = 5 . '-' . rand(11111111, 99999999) . '.' . $extension; // renameing file
            $file->move($name_one, $fileName);                                  // uploading file to given path


            $data = $this->importModammer($name_one . $fileName, $request, $file->getClientOriginalName());
            if ($data['status']) {
                return $this->addResponse();
            } else {

                return $this->errorResponse();

            }

        }
    }

    public function import($file, $request, $originalFileName)
    {
        $owners = Excel::toArray(new OwnerImport(), $file);

        // Process first page - Owners
        if (isset($owners[0])) {
            $firstPage = $owners[0];
            $chunks = array_chunk($firstPage, 200);

            foreach ($chunks as $chunk) {
                foreach ($chunk as $owner) {
                    // Skip if any required column is empty
                    if (empty($owner[0]) || empty($owner[1]) || empty($owner[2]) ||
                        empty($owner[3]) || empty($owner[4]) || empty($owner[5])) {
                        continue;
                    }

                    $ownerNumber = $owner[0];

                    preg_match('/^([A-Z]+)(\d+)$/', $ownerNumber, $matches);
                    $register_symbol = $matches[1] ?? '';
                    $register_number = $matches[2] ?? '';

                    $checkOwner = Owner::updateOrCreate(
                        [
                            'register_number' => $register_number,
                            'register_symbol' => $register_symbol
                        ], [
                            'name' => $owner[1] ?? '',
                            'phone' => $owner[3] ?? '',
                            'national_id' => $owner[2] ?? '',
                            'nationality' => $owner[4] ?? '',
                            'modammer_name' => 'نفسة',
                            'is_active' => $owner[5] == 'فعال' ? 1 : 0,
                            'is_member' => 0,
                        ]
                    );
                }
            }
        }

        return ['status' => true];
    }

    public function importModammer($file, $request, $originalFileName)
    {
        $trainers = Excel::toArray(new ModammerImport(), $file);
        if (isset($trainers[0])) {
            $firstPage = $trainers[0];
            $chunks = array_chunk($firstPage, 200);

            foreach ($chunks as $chunk) {
                foreach ($chunk as $trainer) {

                    // Skip if required columns are empty

                    $parts = explode("-", $trainer[0]);
                    if (!isset($parts[0])) {
                        continue;
                    }
                    preg_match('/^([A-Z]+)(\d+)$/', $parts[0], $matches);
                    $register_symbol = $matches[1] ?? '';
                    $register_number = $matches[2] ?? '';

                    $owner = Owner::where('register_symbol', $register_symbol)
                        ->where('register_number', $register_number)
                        ->first();

                    if ($owner) {
                        $checkModammer = $owner->modammers()->updateOrCreate([
                            'modammer_number' => $trainer[0],
                        ], [
                            'phone' => $trainer[3] ?? null,
                            'name' => $trainer[1],
                            'is_active' => 1, // Default to active
                        ]);
                    }
                }
            }

            return ['status' => true];
        }

        return ['status' => false];

    }
}
