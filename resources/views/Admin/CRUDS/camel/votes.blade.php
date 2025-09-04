@extends('Admin.layouts.inc.app')
@section('title')
    قائمة التصويتات
@endsection
@section('css')
    <style>
        .select2-container { z-index: 10000; }
    </style>
@endsection

@section('content')
    <div class="card mb-5 mb-xl-8">
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">قائمة التصويتات</span>
                <span class="text-muted mt-1 fw-bold fs-7">المطايا المضافة بدون نتيجة نهائية</span>
            </h3>
            <div class="card-toolbar">
                <a href="{{ route('admin.addVote') }}" class="btn btn-sm btn-light-primary">
                    بدء التصويت
                </a>
            </div>
        </div>

        <div class="card-body py-3">
            <div class="table-responsive">
                <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>رقم الشريحة</th>
                        <th>اسم المطية</th>
                        <th>اسم المالك</th>
                        <th>وقت الإضافة</th>
                        <th>بدء التصويت</th>
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
        {
            data: null,
            render: function(data, type, row, meta) { return meta.row + 1; },
            orderable: false,
            searchable: false
        },
        { data: 'barcode', name: 'barcode' },
        { data: 'camel_name', name: 'camel_name' },
        { data: 'owner_name', name: 'owner_name' },
        {
            data: 'created_at', name: 'created_at',
            render: function(data) { return moment(data).format('YYYY-MM-DD hh:mm:ss A'); }
        },
        { data: 'action', name: 'action', orderable: false, searchable: false },
    ];
</script>
@include('Admin.layouts.inc.ajax',['url'=>'votes','createRoute'=>'admin.addVote','listRoute'=>'admin.votes.index'])
@endsection
