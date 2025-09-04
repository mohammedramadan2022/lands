<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CamelRequest;
use App\Http\Requests\Admin\MemberRequest;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Imports\CamelImport;
use App\Models\Camel;
use App\Models\Member;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CamelController extends Controller
{

    use Upload_Files, ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $camels = Camel::with('votes')->latest()
                ->when($request->search, function ($query) use ($request) {
                    $query->where('barcode', 'like', '%'.$request->search.'%');
                    $query->orWhereDate('updated_at', 'like', $request->search);
                })
                ->when($request->without_final, function ($query) {
                    $query->whereNull('final_vote');
                })
                ->latest();
            return Datatables::of($camels)
                ->addColumn('name', function ($camel) {
                    // Ensure key exists even if null
                    return (string) ($camel->name ?? '');
                })
                ->addColumn('age', function ($camel) {
                    // Normalize possible numeric ages (from some forms) to labels; otherwise return stored value
                    $age = $camel->age;
                    $map = [
                        '0' => 'mafareed',
                        '1' => 'haqayq',
                        '2' => 'laqaya',
                        '3' => 'gezaa',
                        '4' => 'thanaya',
                        '5' => 'zamool', // or heeyal depending on usage
                    ];
                    if ($age === null) return '';
                    if (is_numeric($age)) {
                        return $map[(string)$age] ?? (string)$age;
                    }
                    return (string) $age;
                })
                ->addColumn('action', function ($camel) {
                    return '
                  <a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" href="'.route('admin.addVote', $camel).'" >
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#2f5bdd">
            <path d="M144-144v-153l498-498q11-11 24-16t27-5q14 0 27 5t24 16l51 51q11 11 16 24t5 27q0 14-5 27t-16 24L297-144H144Zm549-498 51-51-51-51-51 51 51 51Z"/>
        </svg>
    </span>
</a>

<a class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" href="'.route('admin.showVotes', $camel).'" >
    <span class="svg-icon svg-icon-3">
        <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 0 24 24" width="20px" fill="#2f5bdd">
            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 12c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
        </svg>
    </span>
</a>
                ';
                })
                ->editColumn('created_at', function ($owner) {
                    return date('Y/m/d', strtotime($owner->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }

        return view('Admin.CRUDS.camel.index');
    }

    public function voteReport(Request $request)
    {
        if ($request->ajax()) {
            $camels = Camel::with('votes')
                ->when($request->vote_date, function ($query) use ($request) {
                    $query->whereDate('updated_at', '>=', $request->vote_date);
                })
                ->when($request->type, function ($query) use ($request) {
                    $query->where('final_vote', $request->type);
                })
//                ->when($request->search, function ($query) use ($request) {
//                    $query->where('barcode', 'like', '%'.$request->search.'%');
//                })
                ->latest();

            return Datatables::of($camels)
                ->escapeColumns([])
                ->make(true);
        }

        return view('Admin.CRUDS.camel.voteReport');
    }

    public function create()
    {
        // owner comes via query string (?owner=UUID)
        return view('Admin.CRUDS.camel.parts.create');
    }

    public function store(CamelRequest $request)
    {
        // Create camel with provided data; owner_id is optional but recommended for owner-scoped creation
        Camel::create($request->validated());
        return $this->addResponse();
    }

    public function show(Camel $camel)
    {
        return view('camels.show', compact('camel'));
    }

    public function edit(Camel $camel)
    {
        return view('Admin.CRUDS.camel.parts.edit', compact('camel'));
    }

    public function update(Camel $camel, CamelRequest $request)
    {
        $camel->update($request->validated());
        return $this->addResponse();
    }

    public function destroy(Camel $camel)
    {
        $camel->delete();
        return $this->deleteResponse();
    }


    public function printCamel($camelIds)
    {
        $uuidsArray = explode(',', $camelIds);

        $camels = Camel::whereIn('id', $uuidsArray)->get();

        return view('Admin.CRUDS.camel.print', compact('camels'));

    }

    public function addVote(Request $request, Camel $camel = null)
    {
        // If no camel is provided, show the list of camels pending vote (unvoted)
        if (is_null($camel)) {
            // Reuse the same view as the Votes list (Ajax-powered)
            return view('Admin.CRUDS.camel.votes');
        }

        $members = Member::where('is_active', 1)->get();
        return view('Admin.CRUDS.camel.addVote', compact('members', 'camel'));

    }

    public function showVotes(Request $request, Camel $camel)
    {
        return view('Admin.CRUDS.camel.showVotes', compact('camel'));


    }


    public function storeVote(CamelRequest $request)
    {
        $camel = Camel::whereBarcode($request->barcode)->first();
        if (!$camel) {
            $camel = new Camel();

            $camel->barcode = $request->barcode;
            $camel->save();
        }

        $camel->votes()->create([
            'vote' => $request->vote,
            'member_id' => $request->member_id,

        ]);
        if ($camel->vote_source != 'manager') {
            $checkOmaniat = $camel->votes()->where('vote', 'omaniat')->count();
            $checkMohagnat = $camel->votes()->where('vote', 'mohagnat')->count();
            if ($checkOmaniat === $checkMohagnat) {
                $camel->update(['final_vote' => 0]);
            } else {
                $camel->update(['final_vote' => ($checkOmaniat > $checkMohagnat ? 1 : 2)]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'تم التصويت بنجاح'

        ]);

    }


    public function superVote(CamelRequest $request)
    {
        $camel = Camel::where('barcode', $request->barcode)->first();
        if (!$camel) {
            $camel = new Camel();

            $camel->barcode = $request->barcode;
            $camel->save();

        }

        $camel->votes()->delete();
        if ($request->normalVote) {
            try {
                // Start a database transaction
                DB::beginTransaction();

                foreach ($request->all() as $key => $value) {
                    if (strpos($key, 'vote_') === 0) {
                        list($voteType, $memberId) = explode('-', $value);

                        $checkVote = Vote::where('camel_id', $camel->id)->where('member_id', $memberId)->first();
                        if ($checkVote) {
                            $checkVote->update([
                                'vote' => $voteType == 1 ? 'omaniat' : 'mohagnat',

                            ]);

                        } else {


                            Vote::create([
                                'camel_id' => $camel->id,
                                'member_id' => $memberId,
                                'vote' => $voteType == 1 ? 'omaniat' : 'mohagnat',

                            ]);
                        }
                    }
                }



                $checkOmaniat = $camel->votes()->where('vote', 'omaniat')->count();
                $checkMohagnat = $camel->votes()->where('vote', 'mohagnat')->count();

                // Calculate votes for members with role 'manager'
                $managerOmaniat = $camel->votes()
                    ->where('vote', 'omaniat')
                    ->whereHas('member', function ($query) {
                        $query->where('role', 'manager');
                    })
                    ->count();

                $managerMohagnat = $camel->votes()
                    ->where('vote', 'mohagnat')
                    ->whereHas('member', function ($query) {
                        $query->where('role', 'manager');
                    })
                    ->count();

                // Add manager votes to the total counts
                $totalOmaniat = $checkOmaniat + $managerOmaniat;
                $totalMohagnat = $checkMohagnat + $managerMohagnat;

                $totalOmaniat > $totalMohagnat ? $camel->final_vote = 1 : ($totalMohagnat > $totalOmaniat ? $camel->final_vote = 2 : $camel->final_vote = 0);
                $camel->vote_source = 'normal';
                $camel->save();

                DB::commit();

                return redirect()->route('admin.votes.index');

            } catch (\Exception $e) {
                // Rollback the transaction in case of error
                DB::rollBack();

                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء حفظ التصويت',
                    'error' => $e->getMessage()
                ], 500);
            }
        }


        $members = Member::all();

        if ($request->has('omaniat_for_all')) {
            $camel->final_vote = 1;
            $camel->vote_source = 'normal';
            $camel->save();
            foreach ($members as $member) {
                $oldVote = $camel->votes()->where('member_id', $member->id)->first();
                if ($oldVote) {
                    $oldVote->update(['vote' => 'omaniat']);
                } else {
                    $camel->votes()->create([
                        'vote' => 'omaniat',
                        'member_id' => $member->id,
                    ]);
                }
            }
        }

        if ($request->has('mohagnat_for_all')) {
            $camel->final_vote = 2;
            $camel->vote_source = 'normal';
            $camel->save();
            foreach ($members as $member) {
                $oldVote = $camel->votes()->where('member_id', $member->id)->first();
                if ($oldVote) {
                    $oldVote->update(['vote' => 'mohagnat']);
                } else {
                    $camel->votes()->create([
                        'vote' => 'mohagnat',
                        'member_id' => $member->id,
                    ]);
                }
            }
        }
        if ($request->has('mohagnat_for_manager')) {
            $camel->final_vote = 2;
            $camel->vote_source = 'manager';
            $camel->save();
        }

        if ($request->has('omaniat_for_manager')) {
            $camel->final_vote = 1;
            $camel->vote_source = 'manager';
            $camel->save();
        }
        return redirect()->route('admin.votes.index');
    }


    public function UploadExcel()
    {
        return view('Admin.CRUDS.camel.uploadExcel');

    }


    public function UploadExcelCamels(Request $request)
    {
        $this->validate($request, [
            'sheet' => 'required',
        ]);

        if ($request->file('sheet')->isValid()) {
            $date = $request->date;
            $file = $request->file('sheet');
            $name_one = 'excel/upload/';
            $extension = $file->getClientOriginalExtension(); // getting file extension
            $fileName = 5 .'-'.rand(11111111, 99999999).'.'.$extension; // renameing file
            $file->move($name_one, $fileName); // uploading file to given path

            $data = $this->import($name_one.$fileName, $request);
            if ($data['status']) {
                return back()->with('success', 'نجحت العملية');
            } else {

                return back()->with(['error' => 'فشلت العملية']);

            }


        }
    }

    public function import($file, $request)
    {

        $camels = Excel::toArray(new CamelImport(), $file);

        foreach ($camels as $key => $value) {
            foreach ($value as $camel) {
                // Normalize: keep digits only, remove any spaces or non-digits
                $raw = $camel[1] ?? '';
                $barcode = preg_replace('/\D+/', '', (string)$raw);

                // Enforce exactly 15 digits for barcode
                if (strlen($barcode) !== 15) {
                    continue; // skip invalid rows
                }

                $check_old = Camel::where('barcode', $barcode)->first();
                if ($check_old) {
                    if ($check_old->vote_source == 'excel') {
                        $check_old->update([
                            'final_vote' => $request->final_vote,
                        ]);
                    }
                    continue; // already exists, handled above
                }

                Camel::create([
                    'barcode' => $barcode,
                    'final_vote' => $request->final_vote,
                    'vote_source' => 'excel',
                    'source' => 'excel',
                ]);
            }
        }

        return ['status' => true];

    }

    public function getData(Request $request)
    {
        $query = Camel::query();

        // Apply date filters
        if ($request->start_date) {
            $query->whereDate('updated_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('updated_at', '<=', $request->end_date);
        }

        // Apply type filter
        if ($request->type) {
            $query->where('final_vote', $request->type);
        }

        return DataTables::of($query)
            // ... your existing datatable modifications ...
            ->make(true);
    }

    public function votesList(Request $request)
    {
        if ($request->ajax()) {
            $camels = Camel::with(['votes','owner'])
                ->when($request->search, function ($query) use ($request) {
                    $query->where('barcode', 'like', '%'.$request->search.'%');
                })
                ->whereNull('final_vote')
                ->latest();

            return DataTables::of($camels)
                ->addColumn('camel_name', function ($camel) {
                    return $camel->name ?? '-';
                })
                ->addColumn('owner_name', function ($camel) {
                    return optional($camel->owner)->name ?? '-';
                })
                ->addColumn('action', function ($camel) {
                    return '
                  <a class="btn btn-sm btn-light-primary" href="'.route('admin.addVote', $camel).'">بدء التصويت</a>
                ';
                })
                ->editColumn('created_at', function ($owner) {
                    return date('Y/m/d', strtotime($owner->created_at));
                })
                ->escapeColumns([])
                ->make(true);
        }

        return view('Admin.CRUDS.camel.votes');
    }

}
