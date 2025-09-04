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

    <!--begin::Filter Form-->
    <div class="card mb-5 mb-xl-8">
        <div class="card-body">
            <form id="filter-form">
                <div class="row">
                    <div class="col-md-4">
                        <label for="vote_date">تاريخ التصويت</label>
                        <input type="date" id="vote_date" name="vote_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">نوع المطية</label>
                            <select id="type" name="type" class="form-control ">
                                <option value="">جميع الأنواع</option>
                                <option value="1">عمانية</option>
                                <option value="2">مهجنة</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::Filter Form-->

    <!--begin::Tables Widget 11-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->

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
                        <th>النتيجة النهائيه</th>
                        <th>وقت اخر تصويت</th>
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
            {
                data: 'final_vote',
                name: 'final_vote',
                render: function(data) {
                    data = parseInt(data);
                    switch (data) {
                        case 1: return 'عمانيه';
                        case 2: return 'مهجنة';
                        default: return 'غير معروف';
                    }
                }
            },
            {
                data: 'updated_at',
                name: 'updated_at',
                render: function(data) {
                    return moment(data).format('YYYY-MM-DD hh:mm:ss A');
                }
            }
        ];

        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2({
                width: '100%'
            });

            var table = $('#table').DataTable({
                processing: true,
                pageLength: 100,
                paging: true,
                dom: 'Bfrltip',
                bLengthChange: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("vote-report") }}',
                    data: function(d) {
                        d.vote_date = $('#vote_date').val();
                        d.vote_date = $('#vote_date').val();
                        d.type = $('#type').val();
                        // Keep the search functionality if needed
                        // d.search = $('input[type="search"]').val();
                    }
                },
                columns: columns,
                buttons: {
                    buttons: [{
                        extend: 'collection',
                        text: ' <i class="fas fa-download"></i>  Export',
                        className: 'btn btn-primary AE_button dropdown-toggle',

                        buttons: [{
                            extend: 'copy',
                            text: 'Copy <i class="fas fa-copy"></i> '
                        },
                            {
                                extend: 'csv',
                                text: 'CSV <i class="fas fa-file-csv"></i> '
                            },
                            {
                                extend: 'excel',
                                text: 'Excel <i class="fas fa-file-excel"></i> '
                            },
                            {
                                extend: 'pdf',
                                text: 'PDF <i class="fas fa-file-pdf"></i> '
                            },
                            {
                                extend: 'print',
                                text: ' Print <i class="fas fa-print"></i> '
                            }
                        ]
                    }]
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json' // For Arabic language if needed
                }
            });

            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            // Optional: Reset filters
            $('#reset-filters').on('click', function() {
                $('#vote_date').val('');
                $('#type').val('').trigger('change');
                table.ajax.reload();
            });
        });

    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'camels'])

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>

@endsection
