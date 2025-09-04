<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $folderPath = "Admin.";

    public function helperJson($data = null, $message = '', $code = 200, $status = 200)
    {
        $json = response()->json(['data' => $data, 'msg' => $message, 'code' => $code], $status);
        throw new HttpResponseException($json);
    }

}
