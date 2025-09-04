<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Mail\ContactReplayMail;
use App\Models\Contact;
use App\Models\ContactReplay;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    //
    use  ResponseTrait;

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $rows = Contact::query()->latest();
            return DataTables::of($rows)
                ->addColumn('action', function ($row) {

                    $edit = '';
                    $delete = '';


                    return '

                            <button ' . $delete . '  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete"
                                    data-id="' . $row->id . '">
                            <span class="svg-icon svg-icon-3">
							   <svg xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="#f44336"><path d="M312-144q-29.7 0-50.85-21.15Q240-186.3 240-216v-480h-48v-72h192v-48h192v48h192v72h-48v479.57Q720-186 698.85-165T648-144H312Zm72-144h72v-336h-72v336Zm120 0h72v-336h-72v336Z"/></svg>
							</span>
                            </button>

                                <button ' . $delete . '  class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm showBtn"
                                    data-id="' . $row->id . '">
                                        <i class="fa fa-eye"></i>
                            </button>
                       ';


                })
                ->editColumn('created_at', function ($row) {
                    return date('Y/m/d', strtotime($row->created_at));
                })
                ->escapeColumns([])
                ->make(true);


        }
        return view('Admin.CRUDS.contact.index');
    }

    public function show($id)
    {
        $row=Contact::findOrFail($id);
        return view('Admin.CRUDS.contact.parts.show',compact('row'));

    }


    public function update(Request $request, $id)
    {
        if ($request->replay_message){

         $row=   ContactReplay::create([
                'contact_id'=>$id,
                'message'=>$request->replay_message,
            ]);

            $data = [
                'name' => $row->contact->name??'',  // Replace with actual user data
                'message' => $row->message??'',
            ];

            // Send the email
            Mail::to($row->contact->email??'')->send(new ContactReplayMail($data));


        }

        return $this->updateResponse();
    }



    public function destroy(Contact $contact)
    {

        $contact->delete();

        return $this->deleteResponse();
    }//end fun
}
