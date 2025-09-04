<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;
use App\Http\Traits\Upload_Files;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use Upload_Files,ResponseTrait;




    public function index()
    {


        $settings = Setting::firstOrNew();
        return view('Admin.CRUDS.settings.index', [
            'settings' => $settings,
        ]);
    }

    public function termsOfUse()
    {
        $settings = Setting::firstOrNew();
        return view('Admin.CRUDS.settings.terms', [
            'settings' => $settings,
        ]);
    }

    public function updateTermsOfUse(Request $request)
    {
        $data = $request->validate([
            'terms_of_use'=>'nullable',
        ],
            [
            ]
        );


        Setting::firstOrNew()->update($data);

        return $this->updateResponse();


    }


    public function privacyPolicy()
    {
        $settings = Setting::firstOrNew();
        return view('Admin.CRUDS.settings.privacy', [
            'settings' => $settings,
        ]);
    }

    public function updatePrivacyPolicy(Request $request)
    {
        $data = $request->validate([
            'privacy_policy'=>'nullable',
        ],
            [
            ]
        );


        Setting::firstOrNew()->update($data);

        return $this->updateResponse();


    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'app_name'=>'nullable',
            'logo_header'=>'nullable|image',
            'fave_icon'=>'nullable|image',
//            'twitter'=>'nullable|string',
//            'instagram'=>'nullable|string',
//            'tiktok'=>'nullable|string',
//            'facebook'=>'nullable|string',
//            'platform_ownership_rights'=>'nullable|string',
//            'phone'=>'nullable',
//            'email'=>'nullable|email',


        ],
        [
        ]
        );

        if ($request->logo_header)
        $data['logo_header'] =  $this->uploadFiles('settings',$request->file('logo_header'),null );
        if ($request->fave_icon)
            $data['fave_icon'] =  $this->uploadFiles('settings',$request->file('fave_icon'),null );

        Setting::firstOrNew()->update($data);

        return $this->updateResponse();


    }


}
