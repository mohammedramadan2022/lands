@extends('Admin.layouts.inc.app')
@section('title')
    المطايا
@endsection
@section('css')

    <style>
        .select2-container {
            z-index: 10000; /* Adjust the value as needed */
        }
    </style>

@endsection

@section('content')

    <!--begin::Tables Widget 11-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">المطايا</span>
            </h3>
            <div class="card-toolbar">
                <button id="addBtn" class="btn btn-sm btn-light-primary">
                    <span class="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="black" />
                        </svg>
                    </span>
                    اضافة مطية
                </button>
            </div>
        </div>

        <div class="card-body py-3">
            <!--begin::Table container-->

            <div class="table-responsive">
                <!--begin::Table-->
                <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <!--begin::Table head-->
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>رقم الشريحة</th>
                        <th>اسم المطية</th>
                        <th>النوع</th>
                        <th>العمر</th>
                        <th>النتيجة النهائيه</th>
                        <th>مصدر التصويت</th>
                        <th>مصدر الاضافة</th>
                        <th>وقت اخر تصويت</th>
                        <th>اعادة النظر</th>
                    </tr>
                    </thead>
                    <!--end::Table head-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table container-->
        </div>
        <!--begin::Body-->
    </div>


@endsection
@section('js')
    <script>
        var columns = [


            {
                data: null,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                },
                orderable: false,
                searchable: false
            },
            { data: 'barcode', name: 'barcode' },
            { data: 'name', name: 'name' },
            {
                data: 'gender',
                name: 'gender',
                render: function(data) {
                    switch (data) {
                        case 'bekraa': return 'بكرة';
                        case 'kaood': return 'قعود';
                        default: return '';
                    }
                }
            },
            { data: 'age', name: 'age' },

            {
                data: 'final_vote',
                name: 'final_vote',
                render: function(data) {
                    data = parseInt(data); // Ensure it's an integer
                    switch (data) {
                        case 1: return 'عمانيه';
                        case 2: return 'مهجنة';

                        default: return 'غير معروف'; // Fallback for unexpected values
                    }
                }
            },
            {
                data: 'vote_source',
                name: 'vote_source',
                render: function(data) {
                    switch (data) {
                        case 'normal': return 'تصويت';
                        case 'manager': return 'رئيس اللجنه';
                        case 'excel': return 'اكسيل';

                        default: return 'غير معروف';
                    }
                }
            },
            {
                data: 'source',
                name: 'source',
                render: function(data) {
                    switch (data) {
                        case 'normal': return 'تصويت';
                        case 'excel': return 'اكسيل';
                        default: return 'غير معروف';
                    }
                }
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data) {
                    return moment(data).format('YYYY-MM-DD hh:mm:ss A');
                }
            },


            { data: 'action', name: 'action', orderable: false, searchable: false },
        ];


    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'camels'])

    <script>
        @if(isset($owner))
        $(document).off('click', '#addBtn').on('click', '#addBtn', function () {
            $('#form-load').html(loader)
            $('#operationType').text('اضافة');
            $('#Modal').modal('show')
            setTimeout(function () {
                $('#form-load').load("{{ route('camels.create') }}?owner={{ $owner }}")
            }, 500)
        });
        @endif
    </script>

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>

    <div class="modal fade" data-bs-backdrop="static" id="Modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg mw-650px">
            <div class="modal-content" id="modalContent">
                <div class="modal-header">
                    <h2><span id="operationType"></span> مطية</h2>
                    <div class="btn btn-sm btn-icon btn-active-color-primary" style="cursor: pointer" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7" id="form-load"></div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" data-bs-dismiss="modal" aria-label="Close" class="btn btn-light me-3">الغاء</button>
                        <button form="form" type="submit" id="submit" class="btn btn-primary">
                            <span class="indicator-label">تاكيد</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
