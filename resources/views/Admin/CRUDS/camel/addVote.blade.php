@extends('Admin.layouts.inc.app')
@section('title')
    تصويت جديد
@endsection
@section('css')

    <style>
        .select2-container {
            z-index: 10000; /* Adjust the value as needed */
        }

        .form-check-inline {
            display: inline-block;
            margin-right: 10px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
        }

        .form-check-label {
            margin-left: 5px;
            font-size: 1.2em;
        }

        .form-check-label .fa-check {
            color: green;
        }

        .form-check-label .fa-times {
            color: red;
        }
    </style>

@endsection

@section('content')

    <!--begin::Tables Widget 11-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">تصويت جديد</span>
            </h3>
            <div class="card-toolbar">
                <div class="mb-3">
                    <h3>

                        <span> العمانية: <span id="omaniatCount">0</span></span>
                    </h3>
                    <h3>

                    <span
                        class="ms-3"> المهجنة: <span id="mohgnatCount">0</span></span>
                    </h3>
                </div>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-start">
            <form id="form" action="{{ route('admin.super-vote') }}" method="POST">
                @csrf
                <!-- Camel Info -->
                @if(isset($camel))
                    <div class="mb-3">
                        <div class="row g-3">
                            <div class="col-md-4"><strong>رقم الشريحة:</strong> {{ $camel->barcode }}</div>
                            <div class="col-md-4"><strong>اسم المطية:</strong> {{ $camel->name ?? '-' }}</div>
                            <div class="col-md-4"><strong>اسم المالك:</strong> {{ optional($camel->owner)->name ?? '-' }}</div>
                        </div>
                    </div>
                @endif
                <!-- Hidden barcode field (removed visible input as requested) -->
                <input type="hidden" id="barcode" name="barcode" value="{{$camel->barcode ?? request()->barcode}}">

                <button id="omaniatAllBtn" class="btn btn-sm btn-light-success" name="omaniat_for_all" value="1">عمانية
                    بالاجماع
                </button>
                <button id="mohgnatAllBtn" class="btn btn-sm btn-light-warning" name="mohagnat_for_all" value="1">مهجنة
                    بالاجماع
                </button>

                <button id="omaniatforManagerBtn" style="float: left" class="btn btn-sm btn-light-success" name="omaniat_for_manager" value="1">عمانية بأمر الرئيس
                </button>
                <button id="mohgnatForManagerBtn" style="float: left" class="btn btn-sm btn-light-warning" name="mohagnat_for_manager" value="1">مهجنات بأمر الرئيس
                </button>



                <br>
                <br>
                <br>
                <br>
                <div class="row">
                    @foreach($members as $member)
                        @php
                            $existing = isset($camel) ? optional($camel->votes->firstWhere('member_id', $member->id)) : null;
                            $existingVote = $existing ? $existing->vote : null; // 'omaniat' or 'mohagnat'
                        @endphp
                        <div class="col-md-4 text-center mb-4">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{ get_file($member->image) }}" alt="{{ $member->name }}"
                                     class="img-fluid rounded-circle mb-2 member-image" style="width: 100px; height: 100px;"
                                     data-name="{{ $member->name }}" data-image="{{ get_file($member->image) }}"
                                     data-id="{{ $member->id }}">
                                <h6 style="font-size: 1.5em;">{{ $member->name }}</h6>
                                <div class="d-flex justify-content-center">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input omaniat" type="radio" name="vote_{{ $member->id }}" id="omaniat_{{$member->id}}" value="1-{{$member->id}}" data-role="{{ $member->role }}" {{ $existingVote === 'omaniat' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="omaniat_{{$member->id}}">
                                            <i class="fa fa-check"></i> عمانية
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input mohgnat" type="radio" name="vote_{{ $member->id }}" id="mohgnat_{{$member->id}}" value="2-{{$member->id}}" data-role="{{ $member->role }}" {{ $existingVote === 'mohagnat' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mohgnat_{{$member->id}}">
                                            <i class="fa fa-times"></i> مهجنة
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">

                    <button type = "submit" id = "saveVotesBtn" class = "btn btn-primary" name = "normalVote" value = "1">Save Votes</button>
                </div>
            </form>
        </div>
        @endsection
        @section('js')
            <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet"/>
            <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>

            <script>
                $(document).ready(function() {
                    // Function to count checked radio buttons
                    function countCheckedRadios() {
                        let omaniatCount = 0;
                        let mohgnatCount = 0;

                        $('input.omaniat:checked').each(function() {
                            const role = $(this).data('role');
                            omaniatCount += (role === 'manager') ? 2 : 1;
                        });

                        $('input.mohgnat:checked').each(function() {
                            const role = $(this).data('role');
                            mohgnatCount += (role === 'manager') ? 2 : 1;
                        });

                        // Update the counts in the UI
                        $('#omaniatCount').text(omaniatCount);
                        $('#mohgnatCount').text(mohgnatCount);
                    }

                    // Add event listener to all radio buttons
                    $('input[type="radio"]').on('change', function() {
                        countCheckedRadios();
                    });

                    // Initialize counts on page load to reflect any preselected votes
                    countCheckedRadios();
                });
            </script>
@endsection
