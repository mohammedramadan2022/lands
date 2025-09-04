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

        <div class="card-body py-3">
           <p>رقم الشريحة:{{$camel->barcode}}</p>
           <p>التصويت النهائى:{{$camel->final_vote == 1 ? 'عمانيات' : 'مهجنات'}}</p>
           <p> مصدر التصويت:{{$camel->vote_source == 'normal' ? 'تصويت' : 'أمر رئيس اللجنه'}}</p>
           <p> عمانيات:{{$camel->votes()->where('vote' , 'omaniat')->count ()}}</p>
           <p> مهجنات:{{$camel->votes()->where('vote' , 'mohagnat')->count ()}}</p>

            <div class="table-responsive">
                <!--begin::Table-->
                <table id="table" class="table align-middle gs-0 gy-4 table table-bordered dt-responsive nowrap table-striped align-middle">
                    <!--begin::Table head-->
                    <thead>
                    <tr class="fw-bolder text-muted bg-light">


                        <th>#</th>
                        <th>اسم العضو </th>
                        <th>صوره العضو </th>
                        <th>التصويت</th>

                    </tr>
                    </thead>

                    <tbody>
                    @forelse($camel->votes as $vote)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vote->member->name }}</td>
                            <td><img src="{{ get_file($vote->member->image) }}" alt=""></td>
                            <td>{{ $vote->vote == 'mohagnat' ? 'مهجنات' : 'عمانيات' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No votes found</td>
                        </tr>
                    @endforelse
                    </tbody>
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
{{--    <script>--}}
{{--        var columns = [--}}


{{--            {--}}
{{--                data: null,--}}
{{--                render: function(data, type, row, meta) {--}}
{{--                    return meta.row + 1;--}}
{{--                },--}}
{{--                orderable: false,--}}
{{--                searchable: false--}}
{{--            },--}}
{{--            { data: 'barcode', name: 'barcode' },--}}

{{--            {--}}
{{--                data: 'final_vote',--}}
{{--                name: 'final_vote',--}}
{{--                render: function(data) {--}}
{{--                    data = parseInt(data); // Ensure it's an integer--}}
{{--                    switch (data) {--}}
{{--                        case 1: return 'عمانيه';--}}
{{--                        case 2: return 'مهجنة';--}}

{{--                        default: return 'غير معروف'; // Fallback for unexpected values--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            {--}}
{{--                data: 'vote_source',--}}
{{--                name: 'vote_source',--}}
{{--                render: function(data) {--}}
{{--                    switch (data) {--}}
{{--                        case 'normal': return 'تصويت';--}}
{{--                        case 'manager': return 'رئيس اللجنه';--}}

{{--                        default: return 'غير معروف';--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}
{{--            {--}}
{{--                data: 'source',--}}
{{--                name: 'source',--}}
{{--                render: function(data) {--}}
{{--                    switch (data) {--}}
{{--                        case 'normal': return 'تصويت';--}}
{{--                        case 'excel': return 'اكسيل';--}}
{{--                        default: return 'غير معروف';--}}
{{--                    }--}}
{{--                }--}}
{{--            },--}}


{{--            { data: 'action', name: 'action', orderable: false, searchable: false },--}}
{{--        ];--}}


{{--        document.getElementById('print-checked').addEventListener('click', function() {--}}
{{--            var selectedIds = [];--}}
{{--            document.querySelectorAll('.camel-checkbox:checked').forEach(function(checkbox) {--}}
{{--                selectedIds.push(checkbox.value);--}}
{{--            });--}}

{{--            if (selectedIds.length > 0) {--}}
{{--                var url = "{{ route('print-camel', ':ids') }}";--}}
{{--                url = url.replace(':ids', selectedIds.join(','));--}}
{{--                window.location.href = url;--}}
{{--            } else {--}}
{{--                alert('يرجى تحديد عنصر واحد على الأقل للطباعة.');--}}
{{--            }--}}
{{--        });--}}

{{--    </script>--}}
    @include('Admin.layouts.inc.ajax',['url'=>'camels'])

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
