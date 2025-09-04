@extends('Admin.layouts.inc.app')
@section('title')
    الشروط والأحكام
@endsection
@section('css')

    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>

@endsection



@section('content')

    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1">  الشروط والأحكام </h5>


        

        </div>
        <div class="card-body">
        <form id="form" enctype="multipart/form-data" method="POST" action="{{route('settings.termsOfUse.update')}}">
                @csrf
                <div class="row my-4 g-4">



                    <div class="col-sm-12 pb-3 p-2">
                        <label for="terms_of_use" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                            <span class="required mr-1">الشروط والأحكام</span>
                        </label>
                        <textarea name="terms_of_use" id="terms_of_use" class="form-control " rows="10"
                                  placeholder="">{{$settings->terms_of_use}}</textarea>
                    </div>





                    <div class="my-4">
                        <button type="submit" id="submit" class="btn btn-success"> تحديث </button>
                    </div>


                </div>
            </form>
        </div>
    </div>

@endsection

@section('js')
    @include('Admin.CRUDS.settings.parts.script')

    <script>

        CKEDITOR.replace('terms_of_use', {
            height: 300
            , filebrowserUploadUrl: "{{Route('upload.image',['_token'=>csrf_token()])}}"
            , });
    </script>

@endsection
