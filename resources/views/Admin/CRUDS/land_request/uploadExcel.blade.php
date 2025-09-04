@extends('Admin.layouts.inc.app')
@section('title')
    رفع طلبات الأراضي/العزب - ملف إكسل
@endsection
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1">رفع طلبات الأراضي/العزب عبر ملف إكسل</h5>

            <div class="alert alert-info mt-4">
                صيغة الأعمدة المتوقعة:
                <ul class="mb-0">
                    <li>العمود الأول: رقم تسلسلي (يتم تجاهله)</li>
                    <li>العمود الثاني: اسم مقدم الطلب (سنتجاهل أي رقم في بداية الخانة)</li>
                    <li>العمود الثالث: رقم الهوية</li>
                    <li>العمود الرابع: رقم الهاتف والهاتف الإضافي، الفاصل بينهم قد يكون + أو - أو =</li>
                    <li>العمود الخامس أو الأخير: الملاحظات</li>
                </ul>
            </div>

            <form id="form" action="{{ route('admin.land-requests.upload-excel.store') }}" method="POST"
                  enctype="multipart/form-data" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="file" class="form-label">ملف Excel</label>
                    <input type="file" class="form-control" id="file" name="sheet" accept=".xlsx,.xls,.csv">
                </div>

                <button type="submit" class="btn btn-primary">رفع</button>
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
        $(document).on('submit', "form#form", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#form').attr('action');
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (data) {
                    window.setTimeout(function () {
                        if (data.code == 200) {
                            toastr.success(data.message)
                        } else {
                            toastr.error(data.message)
                        }
                    }, 500);
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
                            }
                        });
                    }
                    if (data.status == 421) {
                        try {
                            var resp = JSON.parse(data.responseText);
                            toastr.error(resp.message || 'خطأ في رفع الملف');
                        } catch (e) {
                            toastr.error('خطأ في رفع الملف');
                        }
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    </script>
@endsection
