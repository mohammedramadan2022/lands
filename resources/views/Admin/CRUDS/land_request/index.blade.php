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
                    <th>الجنسية</th>
                    <th>تاريخ الميلاد</th>
                    <th>رقم المشترك</th>
                    <th>حالة المشترك</th>
                    <th>عدد مرات المشاركة</th>
                    <th>عدد المطايا</th>
                    <th>الجوال</th>
                    <th>جوال بديل</th>
                    <th>تاريخ اخر مشاركة</th>
                    <th>ملاحظات</th>
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
        {data: 'nationality', name: 'nationality'},
        {data: 'birth_date', name: 'birth_date'},
        {data: 'subscriber_number', name: 'subscriber_number'},
        {data: 'subscriber_status', name: 'subscriber_status'},
        {data: 'race_participation_count', name: 'race_participation_count'},
        {data: 'camels_count', name: 'camels_count'},
        {data: 'phone', name: 'phone'},
        {data: 'phone_alt', name: 'phone_alt'},
        {data: 'last_participation_date', name: 'last_participation_date'},
        {data: 'notes', name: 'notes'},
    ];
</script>
@include('Admin.layouts.inc.ajax',['url'=>'land-requests','createRoute'=>'admin.land-requests.upload-excel'])
@endsection
