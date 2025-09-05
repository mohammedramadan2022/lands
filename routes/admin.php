<?php

use App\Http\Controllers\Admin\{AuthController, HomeController,MemberController};
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {


    Route::get('login', [AuthController::class, 'loginView'])->name('admin.login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('admin.postLogin');

});


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/admin',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'admin']
    ], function () {


    Route::group(['middleware' => 'admin', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'], function () {
        Route::get('/', [HomeController::class, 'index'])->name('admin.index');
        Route::get('requests_calenders', [HomeController::class, 'requests_calenders'])->name('admin.requests_calenders');

        Route::get('calender', [HomeController::class, 'calender'])->name('admin.calender');

        Route::get('logout', [AuthController::class, 'logout'])->name('admin.logout');

        ### admins

        Route::resource('admins', \App\Http\Controllers\Admin\AdminController::class);
        Route::get('activateAdmin', [App\Http\Controllers\Admin\AdminController::class, 'activate'])->name('admin.active.admin');
        Route::get('editPassword/{id}', [App\Http\Controllers\Admin\AdminController::class, 'editPassword'])->name('admin.edit.password');
        Route::post('updatePassword/{id}', [App\Http\Controllers\Admin\AdminController::class, 'updatePassword'])->name('admin.update.password');

        // Land requests list and details
        Route::get('land-requests', [\App\Http\Controllers\Admin\LandRequestController::class, 'index'])->name('admin.land-requests.index');

        // Land requests excel upload
        Route::get('land-requests/upload-excel', [\App\Http\Controllers\Admin\LandRequestController::class, 'uploadExcelView'])->name('admin.land-requests.upload-excel');
        Route::post('land-requests/upload-excel', [\App\Http\Controllers\Admin\LandRequestController::class, 'uploadExcelStore'])->name('admin.land-requests.upload-excel.store');

        // Land requests update via excel (new route - does not affect create upload)
        Route::get('land-requests/update-from-excel', [\App\Http\Controllers\Admin\LandRequestController::class, 'uploadExcelUpdateView'])->name('admin.land-requests.update-excel');
        Route::post('land-requests/update-from-excel', [\App\Http\Controllers\Admin\LandRequestController::class, 'uploadExcelUpdateStore'])->name('admin.land-requests.update-excel.store');

        // Land requests simple status+notes update via excel (first col: national id, second & third: notes)
        Route::get('land-requests/update-status-from-excel', [\App\Http\Controllers\Admin\LandRequestController::class, 'uploadStatusFromExcelView'])->name('admin.land-requests.update-status-excel');
        Route::post('land-requests/update-status-from-excel', [\App\Http\Controllers\Admin\LandRequestController::class, 'uploadStatusFromExcelStore'])->name('admin.land-requests.update-status-excel.store');

        // Land requests actions
        Route::post('land-requests/{landRequest}/check', [\App\Http\Controllers\Admin\LandRequestController::class, 'checkStatus'])->name('admin.land-requests.check');
        Route::post('land-requests/check-all', [\App\Http\Controllers\Admin\LandRequestController::class, 'checkStatusAll'])->name('admin.land-requests.check-all');

        // Land requests show (must be after specific routes and constrained to numeric IDs)
        Route::get('land-requests/{landRequest}', [\App\Http\Controllers\Admin\LandRequestController::class, 'show'])
            ->whereNumber('landRequest')
            ->name('admin.land-requests.show');


        ### Countries


        #### Contacts

        Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class);



        ### Permissions

        Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);

        ## Roles

        Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);



        ### setting
        Route::get('settings/terms-of-use', [App\Http\Controllers\Admin\SettingController::class, 'termsOfUse'])->name('settings.termsOfUse.index');
        Route::post('settings/update-terms-of-use', [App\Http\Controllers\Admin\SettingController::class, 'updateTermsOfUse'])->name('settings.termsOfUse.update');
        Route::get('settings/privacy-policy', [App\Http\Controllers\Admin\SettingController::class, 'privacyPolicy'])->name('settings.privacyPolicy.index');
        Route::post('settings/update-privacy-policy', [App\Http\Controllers\Admin\SettingController::class, 'updatePrivacyPolicy'])->name('settings.privacyPolicy.update');
        Route::resource('settings', \App\Http\Controllers\Admin\SettingController::class);


        ### ckeditor

        Route::post('/pages/uploadImage', [\App\Http\Controllers\Ckeditor::class, 'uploadImage'])->name('upload.image');

    });

});
