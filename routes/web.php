<?php

use App\Mail\TestMail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/reply',function (){
    return view('Pdf.reply');
})->name('api.reply');

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function() {

    Route::get('/',function (){
        return redirect()->route('admin.login');
    })->name('frontend.index');

});



Route::get('/clear/route', function (){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('migrate');

    return 'Optimize Cleared Successfully By El Sdodey';
});


Route::get('/empty/route', function (){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    \Illuminate\Support\Facades\Artisan::call('migrate:refresh');

    return 'Optimize Cleared Successfully By El Sdodey';
});


Route::get('/send-email', function () {
    $data = [
        'title' => 'Welcome to Our Service',
        'message' => 'This is a test email with all necessary data.',
        'user' => [
            'name' => 'John Doe',
            'email' => 'lovegasmeen55@yahoo.com',
        ],
        'link' => 'https://example.com/verify'
    ];

    Mail::to('mahmoud.diab6067796@gmail.com')->send(new TestMail($data));
    return 'Test email sent!';
});
Route::get('/phpinfo', function () {
    return  phpinfo();
});


Route::get('/ranking', function () {
    $port = \App\Models\Portfolio::all();
    foreach ($port as $p)
    {
        $p->update([
           'ranking' =>$p->id
        ]);
    }

    $exper = \App\Models\Experience::all();
    foreach ($exper as $ex)
    {
        $p->update([
            'ranking' =>$ex->id
        ]);
    }

    $review = \App\Models\Review::all();
    foreach ($review as $rev)
    {
        $p->update([
            'ranking' =>$rev->id
        ]);
    }
    return "succes";
});

Route::get('/test', function () {
    return get_file(setting()->logo_header);
    return  env('FRONTEND_URL');
});



Route::get('/mail', function () {
    $testUser = (object) [
        'email' => 'test@example.com',
        'name' => 'Test User',
    ];

    $user = \App\Models\User::first();

    $user->notify(new ResetPasswordNotification($user));

    return 'Test email sent successfully!';
});
