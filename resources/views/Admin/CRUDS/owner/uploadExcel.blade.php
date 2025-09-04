@extends('Admin.layouts.inc.app')
@section('title')
    تحميل ملف اكسيل
@endsection
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>
@endsection

{{-- @section('page-title') --}}
{{--    General Settings --}}
{{-- @endsection --}}



@section('content')
    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1">تحميل ملف ا </h5>


            <form id="form" action="{{ route('admin.upload-excel-camels') }}" method="POST"
                  enctype="multipart/form-data">
                @csrf


                <div class="mb-3">
                    <label for="file" class="form-label">Excel File</label>
                    <input type="file" class="form-control" id="file" name="sheet">
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>


    <script>
        $('.dropify').dropify();
    </script>


    <script>
        // CKEDITOR.replace('privacy');
    </script>
    <script>
        $(document).on('submit', "form#form", function (e) {
            e.preventDefault();

            var formData = new FormData(this);

            var url = $('#form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,

                complete: function () {
                },
                success: function (data) {

                    window.setTimeout(function () {

                        // $('#product-model').modal('hide')
                        if (data.code == 200) {
                            toastr.success(data.message)
                        } else {
                            toastr.error(data.message)
                        }
                    }, 1000);


                },
                error: function (data) {
                    if (data.status === 500) {
                        toastr.error('برجاء التوجه الي الدعم الفني')
                    }

                    if (data.status === 422) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                    if (data.status == 421) {
                        toastr.error(data.message)
                    }

                }, //end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
