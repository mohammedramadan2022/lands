@extends('Admin.layouts.inc.app')
@section('title')
    الاعدادات العامة
@endsection
@section('css')

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>

@endsection



@section('content')

    <form id="form" enctype="multipart/form-data" method="POST" action="{{route('settings.store')}}">
        @csrf

        <div class="card mb-4">

            <div class="card-header ">
                <h5 class="card-title mb-0 flex-grow-1"> بيانات يراع </h5>


                


            </div>
            <div class="row my-4 g-4 card-body">

                    <div class="d-flex flex-column mb-7 fv-row col-sm-12">
                        <!--begin::Label-->
                        <label for="app_name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class=" mr-1">  اسم المنصة </span>
                        </label>
                        <!--end::Label-->
                        <input id="app_name" type="text" class="form-control form-control-solid" name="app_name"
                               value="{{$settings->app_name}}"/>
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <label for="logo_header" class="form-control-label fs-6 fw-bold "> شعار المنصة </label>
                        <input type="file" class="dropify" name="logo_header"
                               data-default-file="{{get_file($settings->logo_header)}}"
                               accept="image/*"/>
                        <span class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
                    </div>


                    <div class="d-flex flex-column mb-7 fv-row col-sm-6">
                        <label for="fave_icon" class="form-control-label fs-6 fw-bold "> الايكون </label>
                        <input type="file" id="fave_icon" class="dropify" name="fave_icon"
                               data-default-file="{{get_file($settings->fave_icon)}}"
                               accept="image/*"/>
                        <span class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
                    </div>


                    <div class="col-sm-12 pb-3 p-2">
                        <label for="platform_ownership_rights"
                               class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class=" mr-1">  حقوق ملكية المنصة</span>
                        </label>
                        <textarea name="platform_ownership_rights" id="platform_ownership_rights" class="form-control "
                                  rows="10"
                                  placeholder="">{{$settings->platform_ownership_rights}}</textarea>
                    </div>


                </div>
        </div>


        <div class="card">

            <div class="card-header ">
                <h5 class="card-title mb-0 flex-grow-1"> بيانات التواصل </h5>

              


            </div>
            <div class="row my-4 g-4 card-body">


<div class="d-flex flex-column mb-7 fv-row col-sm-6">
    <!--begin::Label-->
    <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span class=" mr-1">   رقم الجوال</span>
    </label>
    <!--end::Label-->
    <input id="phone" type="text" class="form-control form-control-solid" name="phone"
           value="{{$settings->phone}}"/>
</div>

<div class="d-flex flex-column mb-7 fv-row col-sm-6">
    <!--begin::Label-->
    <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span class=" mr-1">    البريد الالكتروني</span>
    </label>
    <!--end::Label-->
    <input id="email" type="text" class="form-control form-control-solid" name="email"
           value="{{$settings->email}}"/>
</div>

<h5>حسابات التواصل الاجتماعي</h5>

<div class="d-flex flex-column mb-7 fv-row col-sm-6">
    <!--begin::Label-->
    <label for="facebook" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span class=" mr-1">  فيسبوك</span>
    </label>
    <!--end::Label-->
    <input id="facebook" type="text" class="form-control form-control-solid" name="facebook"
           value="{{$settings->facebook}}"/>
</div>

<div class="d-flex flex-column mb-7 fv-row col-sm-6">
    <!--begin::Label-->
    <label for="twitter" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span class=" mr-1">  تويتر</span>
    </label>
    <!--end::Label-->
    <input id="twitter" type="text" class="form-control form-control-solid" name="twitter"
           value="{{$settings->twitter}}"/>
</div>


<div class="d-flex flex-column mb-7 fv-row col-sm-6">
    <!--begin::Label-->
    <label for="tiktok" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span class=" mr-1">   تيك توك</span>
    </label>
    <!--end::Label-->
    <input id="tiktok" type="text" class="form-control form-control-solid" name="tiktok"
           value="{{$settings->tiktok}}"/>
</div>


<div class="d-flex flex-column mb-7 fv-row col-sm-6">
    <!--begin::Label-->
    <label for="instagram" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
        <span class=" mr-1">  انستجرام</span>
    </label>
    <!--end::Label-->
    <input id="instagram" type="text" class="form-control form-control-solid" name="instagram"
           value="{{$settings->instagram}}"/>
</div>


<div class="my-4">
    <button id="submit" type="submit" class="btn btn-success"> تحديث</button>
</div>


</div>

        </div>

    </form>

@endsection

@section('js')

    @include('Admin.CRUDS.settings.parts.script')

@endsection
