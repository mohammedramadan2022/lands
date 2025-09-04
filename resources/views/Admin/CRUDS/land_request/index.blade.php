@extends('Admin.layouts.inc.app')

@section('title', 'طلبات الأراضي/العزب')

@section('content')
<div class="card mb-5 mb-xl-8">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">طلبات الأراضي/العزب</h3>
        <div>
            <a href="{{ route('admin.land-requests.upload-excel') }}" class="btn btn-sm btn-primary">رفع من ملف Excel</a>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr class="fw-bolder text-muted bg-light">
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الهوية</th>
                    <th>الجوال</th>
                    <th>جوال بديل</th>
                    <th>ملاحظات</th>
                    <th>تاريخ الإضافة</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var columns = [
        {data: 'id', name: 'id', visible:false},
        {data: 'applicant_name', name: 'applicant_name'},
        {data: 'national_id', name: 'national_id'},
        {data: 'phone', name: 'phone'},
        {data: 'phone_alt', name: 'phone_alt'},
        {data: 'notes', name: 'notes'},
        {data: 'created_at', name: 'created_at'},
    ];
</script>
@include('Admin.layouts.inc.ajax',['url'=>'land-requests','createRoute'=>'admin.land-requests.upload-excel'])
@endsection
