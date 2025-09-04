@extends('Admin.layouts.inc.app')

@section('title', 'طلبات الأراضي/العزب')

@section('content')
<div class="card mb-5 mb-xl-8">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">طلبات الأراضي/العزب</h3>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.land-requests.upload-excel') }}" class="btn btn-sm btn-primary">رفع من ملف Excel</a>
            <button type="button" class="btn btn-sm btn-success" onclick="checkAll()">فحص الكل</button>
        </div>
    </div>
    <div class="card-body py-3">
        <div class="table-responsive">
            <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                <thead>
                <tr class="fw-bolder text-muted bg-light">
                    <th>#</th>
                    <th>تحقق</th>
                    <th>الاسم</th>
                    <th>الهوية</th>
                    <th>الجنسية</th>
                    <th>تاريخ الميلاد</th>
                    <th>رقم المشترك</th>
                    <th>عدد مرات المشاركة</th>
                    <th>عدد المطايا</th>
                    <th>الجوال</th>
                    <th>جوال بديل</th>
                    <th>تاريخ آخر مشاركة</th>
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
        {data: 'actions', name: 'actions', orderable: false, searchable: false, defaultContent: '', className: 'text-center'},
        {data: 'applicant_name', name: 'applicant_name'},
        {data: 'national_id', name: 'national_id'},
        {data: 'nationality', name: 'nationality'},
        {data: 'birth_date', name: 'birth_date'},
        {data: 'subscriber_number', name: 'subscriber_number'},
        {data: 'race_participation_count', name: 'race_participation_count'},
        {data: 'camels_count', name: 'camels_count'},
        {data: 'phone', name: 'phone'},
        {data: 'phone_alt', name: 'phone_alt'},
        {data: 'last_participation_date', name: 'last_participation_date'},
        {data: 'notes', name: 'notes'},
    ];
function checkOne(id){
    $.post({
        url: '{{ route('admin.land-requests.check', ':id') }}'.replace(':id', id),
        data: {_token: '{{ csrf_token() }}'},
        success: function(res){
            if(res && res.ok){
                toastr.success('تم الفحص: ' + (res.check_status || ''));
                $('#table').DataTable().ajax.reload(null, false);
            } else {
                toastr.error('فشل الفحص');
            }
        },
        error: function(){ toastr.error('حدث خطأ أثناء الفحص'); }
    });
}
function checkAll(){
    $.post({
        url: '{{ route('admin.land-requests.check-all') }}',
        data: {_token: '{{ csrf_token() }}'},
        success: function(){
            toastr.success('تم تنفيذ الفحص على جميع السجلات');
            $('#table').DataTable().ajax.reload(null, false);
        },
        error: function(){ toastr.error('حدث خطأ أثناء فحص الكل'); }
    });
}
</script>
@include('Admin.layouts.inc.ajax',["url"=>'land-requests','createRoute'=>'admin.land-requests.upload-excel'])
@endsection
