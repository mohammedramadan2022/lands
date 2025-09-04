@extends('Admin.layouts.inc.app')
@section('title')
    تحديث الطلبات من ملف إكسل
@endsection
@section('css')
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" type="text/css"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" rel="stylesheet"/>
@endsection

@section('content')
    <div class="card">
        <div class="card-header ">
            <h5 class="card-title mb-0 flex-grow-1">تحديث بيانات طلبات الأراضي/العزب بواسطة ملف إكسل</h5>

            <div class="alert alert-info mt-4">
                سيقوم هذا الإجراء بتحديث السجلات الموجودة فقط (حسب رقم الهوية). إذا لم يوجد رقم الهوية سيتم تجاهل السطر.
                الأعمدة المتوقعة:
                <ul class="mb-0">
                    <li>رقم المشترك</li>
                    <li>إسم المالك</li>
                    <li>الجنسية</li>
                    <li>تاريخ الميلاد</li>
                    <li>حالة المشترك</li>
                    <li>البلد (اختياري، يتم تجاهله)</li>
                    <li>نوع الاثبات الشخصي (يُتجاهل)</li>
                    <li>رقم بطاقة الاثبات الشخصي (سيتم استخدامه للمطابقة)</li>
                    <li>عدد المطايا</li>
                    <li>رقم الجوال الأساسي</li>
                    <li>رقم الجوال الفرعي</li>
                    <li>عدد مرات المشاركة بالسباقات</li>
                    <li>تاريخ اخر مشاركه</li>
                    <li>RaceID (يُتجاهل)</li>
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

            <form action="{{ route('admin.land-requests.update-excel.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
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
