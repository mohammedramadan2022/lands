@extends('Admin.layouts.inc.app')

@section('title', 'عرض طلب أرض/عزبة')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">بيانات الطلب</h3>
        <div class="card-toolbar">
            <a href="{{ route('admin.land-requests.index') }}" class="btn btn-sm btn-light">رجوع</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">الاسم</label>
                <div class="form-control">{{ $landRequest->applicant_name }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">الهوية</label>
                <div class="form-control">{{ $landRequest->national_id }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">الجوال</label>
                <div class="form-control">{{ $landRequest->phone }}</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">جوال بديل</label>
                <div class="form-control">{{ $landRequest->phone_alt }}</div>
            </div>
            <div class="col-12">
                <label class="form-label">ملاحظات</label>
                <div class="form-control">{{ $landRequest->notes }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
