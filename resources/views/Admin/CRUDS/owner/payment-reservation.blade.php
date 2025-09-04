@extends('Admin.layouts.inc.app')
@section('title')
    مدفوعات لم تستخدم
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
                <span class="card-label fw-bolder fs-3 mb-1">    مدفوعات لم تستخدم
</span>
            </h3>

        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <!--begin::Table head-->
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">
                        <th>#</th>
                        <th>المالك</th>
                        <th>رقم المشاركه</th>
                        <th>الجوال</th>
                        <th>رقم الايصال</th>

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
            {data: 'owner.name', name: 'name'},
            {data: 'owner.register_number', name: 'register_number'},
            {data: 'owner.phone', name: 'phone'},
            {data: 'payment_code', name: 'payment_code'},

        ];


        $(document).on('change', '.activeBtn', function () {
                    var id = $(this).attr('data-id');

                    $.ajax({
                        type: 'GET',
                        url: "{{route('admin.active.owner')}}",
                        data: {
                            id: id,
                        },

                        success: function (res) {
                            if (res['status'] == true) {
                                toastr.success("تمت العملية بنجاح")
                            } else {
                            }
                        },
                        error: function (data) {
                        }
                    });
                })
    </script>
    @include('Admin.layouts.inc.ajax',['url'=>'owners'])

    <link href="{{url('assets/dashboard/css/select2.css')}}" rel="stylesheet"/>
    <script src="{{url('assets/dashboard/js/select2.js')}}"></script>

{{--    <script>--}}
{{--        $(document).on('change', '.activeBtn', function () {--}}
{{--            var id = $(this).attr('data-id');--}}

{{--            $.ajax({--}}
{{--                type: 'GET',--}}
{{--                url: "{{route('admin.active.owner')}}",--}}
{{--                data: {--}}
{{--                    id: id,--}}
{{--                },--}}

{{--                success: function (res) {--}}
{{--                    if (res['status'] == true) {--}}
{{--                        toastr.success("تمت العملية بنجاح")--}}
{{--                    } else {--}}
{{--                    }--}}
{{--                },--}}
{{--                error: function (data) {--}}
{{--                }--}}
{{--            });--}}
{{--        })--}}

{{--        $(document).on('click','.changePassword',function (){--}}
{{--            var id=$(this).attr('data-id');--}}

{{--            $('#operationType').text('تغير كلمة مرور ');--}}
{{--            $('#form-load').html(loader)--}}
{{--            $('#Modal').modal('show')--}}

{{--            var route = "{{ route("admin.edit.password", ':id') }}";--}}
{{--            route = route.replace(':id', id)--}}

{{--            setTimeout(function() {--}}
{{--                $('#form-load').load(route)--}}
{{--            }, 1000)--}}
{{--        })--}}
{{--    </script>--}}

@endsection
```
