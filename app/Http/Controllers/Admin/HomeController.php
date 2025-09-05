<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\NotificationFirebaseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Portfolio;
use App\Models\PortfolioView;
use App\Models\User;
use App\Models\LandRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use Upload_Files, NotificationFirebaseTrait;

    public function index(Request $request)
    {
        $landHtml = '';

        // Land requests statistics
        $totalRequests = LandRequest::count();
        $passedRequests = LandRequest::where('check_status', 'passed')->count();
        $failedRequests = LandRequest::where('check_status', 'failed')->count();


        // New land request search by national ID
        $nationalId = trim((string) $request->get('national_id', ''));
        if ($nationalId !== '') {
            $landRequest = LandRequest::where('national_id', $nationalId)->first();
            $landHtml = view('Admin.home.land-request-dev', compact('landRequest', 'nationalId'))->render();
        }

        return view('Admin.home.index', compact(
            'landHtml',
            'totalRequests',
            'passedRequests',
            'failedRequests'
        ));
    }//end fun


    public function calender(Request $request)
    {
        $arrResult = [];
        $orders = Booking::get();
        //get count of orders by days
        foreach ($orders as $row) {
            $date = date('Y-m-d', strtotime($row->created_at));
            if (isset($arrResult[$date])) {
                $arrResult[$date]["counter"] += 1;
                $arrResult[$date]["id"][] = $row->id;
            } else {
                $arrResult[$date]["counter"] = 1;
                $arrResult[$date]["id"][] = $row->id;

            }
        }
        //  dd($arrResult);
        //make format of calender
        $Events = [];
        if (count($arrResult) > 0) {
            $i = 0;
            foreach ($arrResult as $item => $value) {
                $title = $value['counter'];
                $Events[$i] = array(
                    'id' => $i,
                    'title' => $title,
                    'start' => $item,
                    'ids' => $value['id'],
                );
                $i++;
            }
        }
        //return to calender
        return $Events;
    }//end fun


    public function requests_calenders()
    {
        return view('Admin.requests.calenders.index');
    }


}//end clas
