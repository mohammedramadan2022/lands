<?php

use SimpleSoftwareIO\QrCode\Facades\QrCode;

define("OTP_EXPIRE_TIME", 5);


if (!function_exists('admin')) {
    function admin(): \Illuminate\Auth\SessionGuard
    {
        return auth()->guard('admin');
    }
}

if (!function_exists('owner')) {
    function owner(): \Illuminate\Auth\SessionGuard
    {
        return auth()->guard('owner');
    }
}

function patient()
{
    return auth()->guard('patient');
}
function doctor()
{
    return auth()->guard('doctor');
}



function remove_invalid_characters($str): array|string
{
    return str_ireplace(['\'', '"', ',', ';', '<', '>'], ' ', $str);
}

function setting()
{
    return \App\Models\Setting::firstorCreate([]);
}
function languages()
{
    return \App\Models\Language::where('status',1)->get();
}
if (!function_exists('helperTrans')) {
    function helperTrans($str): array|string|\Illuminate\Contracts\Translation\Translator|\Illuminate\Contracts\Foundation\Application|null
    {

        $arrayOfKeys = explode('.', $str);
        $file = $arrayOfKeys[0] ?? 'file';
        $key = $arrayOfKeys[1] ?? '';

        $local = 'en';

        \Illuminate\Support\Facades\App::setLocale(session_lang());


        try {
            $lang_array = include(resource_path("lang/$local/$file.php"));

            $processed_key = ucfirst(str_replace('_', ' ', remove_invalid_characters($key)));

            if (!array_key_exists($key, $lang_array)) {
                $lang_array[$key] = $processed_key;
                $str = "<?php return " . var_export($lang_array, true) . ";";
                file_put_contents(resource_path("lang/$local/$file.php"), $str);
                $result = $processed_key;
            } else {
                $result = __("$file.$key");
            }
        } catch (\Exception $exception) {
            $result = __("$file.$key");
        }

        return $result;
    }
}


if (!function_exists('saas')) {
    function saas()
    {
        return auth()->guard('saas');
    }
}

if (!function_exists('teacher')) {
    function teacher()
    {
        return auth()->guard('teacher');
    }
}

if (!function_exists('moderator')) {
    function moderator()
    {
        return auth()->guard('moderator');
    }
}



if (!function_exists('setting')) {
    function setting()
    {
        return \App\Models\Setting::firstorFail();
    }
}


if (!function_exists('get_file')) {
    function get_file($file=null)
    {
        // Storage::exists( $file )
        if (filter_var($file, FILTER_VALIDATE_URL)) {
            $file_path = $file;
        } elseif ($file) {
            $file_path = asset('storage/uploads') . '/' . $file;
        } else {
            $file_path = asset('assets/default/imgs/default-img.png');
        }
        return $file_path;
    }//end
}



if (!function_exists('get_lang')) {
    function get_lang()
    {
        return \LaravelLocalization::setLocale() ?? 'en';
    }
}


if (!function_exists('session_lang')) {
    function session_lang()
    {
        $lang = 'ar';
        /*if (session()->get('lang') && in_array(session()->get('lang'), ['ar', 'en'])) {
            $lang = session()->get('lang') ? session()->get('lang') : 'default';
        }*/

        if (get_lang() && in_array(get_lang(), ['ar', 'en'])) {
            $lang = get_lang();
        }

        if (request()->get('lang') && in_array(request()->get('lang'), ['ar', 'en'])) {
            $lang = request()->get('lang');
        }

        if (request()->post('lang') && in_array(request()->post('lang'), ['ar', 'en'])) {
            $lang = request()->post('lang');
        }

        if (request()->header('lang') && in_array(request()->header('lang'), ['ar', 'en'])) {
            $lang = request()->header('lang');
        }
        return $lang;
    }


    if (!function_exists('profile_link')) {
        function profile_link($user)
        {
            return "https://yaraa-platform.vercel.app/authors/".$user->username??null."";
        }

    }

    if (!function_exists('latest_messages')) {
        function latest_messages()
        {
            return \App\Models\Contact::latest()->take(5)->get();
        }

    }

    function responseSuccess($data, ?string $message = "data loaded successfully", int $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    function responseError(mixed $message, ?int $code)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }

    function getMaxFreeCamels()
    {
        return session()->has('max_free_camels') ? session()->get('max_free_camels') : setting()->max_free_camels;
    }

    function ownerTypes(int|null $type = null)
    {
        $types = [
            '0' => 'مشارك',
            '1' => 'عضو لجنة معفى من الرسوم',
        ];
        return is_null($type) ? $types : ($types[$type] ?? 'مشارك');
    }

}
