@extends('Admin.Auth.layouts.inc.app')
@section('title')
    تسجيل الدخول
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mt-sm-5 mb-4 text-white-50">
                    <div>
                        <a href="{{route('admin.index')}}" class="d-inline-block auth-logo">
                            <img src="{{get_file(setting()->logo_header)}}" alt="" height="80">
                        </a>
                    </div>
{{--                    <p class="mt-3 fs-15 fw-medium">مدير مميز وقالب لوحة القيادة</p>--}}
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-6">
                <div class="card mt-4 LoginBoxCard">

                    <div class="card-body p-4">
                        <div class="text-center mt-2">
                            <h5 class="text-primary">مرحبا بعودتك !</h5>
                            <p class="text-primary">سجل للماتبعة الي لوحة تحكم يراع
                                {{setting()->app_name}}.</p>
                        </div>
                        <div class="p-2 mt-4">
                            <form action="{{route('admin.postLogin')}}" method="post" enctype="multipart/form" id="Form" class="">
                                @csrf
                                <div class="mb-7 ">
                                    <label for="email" class="form-label text-primary">البريد الالكتروني</label>
                                    <input  type="email" class="form-control text-primary" id="email" name="email" placeholder="ادخل البريد الالكتروني">
                                </div>

                                <div class="mb-7">
{{--                                    <div class="float-end">--}}
{{--                                        <a href="auth-pass-reset-basic.html" class="text-muted">نسيت كلمة المرور?</a>--}}
{{--                                    </div>--}}
                                    <label class="form-label text-primary" for="password-input"> كلمة المرور</label>
                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                        <input type="password" class="form-control pe-5" name="password" placeholder="Enter password" id="password-input">
                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                    </div>
                                </div>

                                <div class="mb-7">
                                <input style="border-radius: 50%;margin: 0 5px;" class="form-check-input" dir="rtl" type="checkbox" value="" id="auth-remember-check">

                                    <label  class="form-check-label text-primary" for="auth-remember-check">تذكرنى</label>

                                </div>
                                <div class="mt-7">
                                    <button style="    background: #2f5bdd;
    color: #fff;" class="btn w-100" id="loginButton" type="submit">تسجيل الدخول</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->

{{--                <div class="mt-4 text-center">--}}
{{--                    <p class="mb-0">ليس لديك حساب ? <a href="auth-signup-basic.html" class="fw-semibold text-primary text-decoration-underline"> اشتراك </a> </p>--}}
{{--                </div>--}}

            </div>
        </div>
        <!-- end row -->
    </div>
@endsection
@section('js')
    <script>

        $("form#Form").submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#Form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    $('.loader-ajax').show()

                    $('#loginButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">جاري العمل</span>').attr('disabled', true);
                },
                complete: function () {
                    $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> تسجيل الدخول`).attr('disabled', false);

                },
                success: function (data) {

                    if (data == 200) {

                        window.setTimeout(function () {
                            $('.loader-ajax').hide()
                        }, 500);
                        window.setTimeout(function () {
                            toastr.success('مرحبا بعودتك')
                        }, 750);
                        window.setTimeout(function () {
                            window.location = "{{route('admin.index')}}"
                        }, 1000);

                    } else {
                        window.setTimeout(function () {
                            $('.loader-ajax').hide()
                        }, 500);
                        window.setTimeout(function () {
                            toastr.error('هناك خطأ في كلمة المرور أو تم تعليق حسابك')
                        }, 750);
                    }


                },
                error: function (data) {

                    window.setTimeout(function () {
                        $('.loader-ajax').hide()
                        if (data.status === 500) {
                            $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> تسجيل الدخول`).attr('disabled', false);
                            toastr.error('برجاء التوجة الي الدعم الفني');
                        }
                        else if (data.status === 422) {
                            $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> تسجيل الدخول`).attr('disabled', false);
                            var errors = $.parseJSON(data.responseText);
                            $.each(errors, function (key, value) {
                                if ($.isPlainObject(value)) {
                                    $.each(value, function (key, value) {
                                        toastr.error(value,key);
                                    });

                                } else {
                                }
                            });
                        }else {
                            $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> تسجيل الدخول`).attr('disabled', false);

                            toastr.error('برجاء التوجة الي الدعم الفني');
                        }
                    }, 500);


                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

        $('#password-addon').on('click', function()
        {
            var type = $('#password-input').attr('type');
            if (type == 'text')
                $('#password-input').attr('type','password')
            else
                $('#password-input').attr('type','text  ')
        })
    </script>
@endsection
