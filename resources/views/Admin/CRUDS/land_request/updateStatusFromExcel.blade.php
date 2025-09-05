@extends('Admin.layouts.inc.app')
@section('title')
    تحديث الحالة السابقة وملاحظاتها من ملف إكسل
@endsection
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1">تحديث الحالة السابقة وملاحظاتها لطلبات الأراضي/العزب بواسطة ملف إكسل</h5>

            <div class="alert alert-info mt-4">
                سيقوم هذا الإجراء بتحديث السجلات الموجودة فقط بناءً على رقم الهوية الوطني في العمود الأول.
                الإجراء:
                <ul class="mb-0">
                    <li>العمود الأول: رقم الهوية (يتم المطابقة به). إذا لم يوجد أو لم يُعثر على السجل سيتم تجاهل السطر.</li>
                    <li>عند وجود السجل: سيتم تعيين الحالة السابقة إلى 1.</li>
                    <li>سيتم تحديث الملاحظات من العمودين الثاني والثالث (إن وُجدا) مدموجين معًا.</li>
                </ul>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.land-requests.update-status-excel.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf

                <div class="mb-3">
                    <label for="file" class="form-label">ملف Excel</label>
                    <input type="file" class="form-control" id="file" name="sheet" accept=".xlsx,.xls,.csv" required>
                </div>

                <button type="submit" class="btn btn-primary">رفع للتحديث</button>
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
@endsection
