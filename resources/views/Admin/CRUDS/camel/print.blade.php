<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Camel </title>

    <link href="{{asset('assets/print-assets/libraries/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/print-assets/libraries/bootstrap/css/bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/print-assets/libraries/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/print-assets/libraries/fontawesome/css/all.min.css')}}" rel="stylesheet"
          type="text/css"/>
    <link href="{{asset('assets/print-assets/custom/css/style.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/print-assets/custom/css/style-2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('assets/print-assets/custom/css/print.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        .mobile-print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 9999;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: none; /* Hidden by default, will be shown on mobile */
        }

        /* Watermark on print body section */
        .data-section::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('{{ asset('assets/print-assets/images/enhanced_logo.png') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 50% auto; /* scale watermark - slightly smaller */
            opacity: 0.06; /* subtle watermark */
            pointer-events: none;
            z-index: 0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Ensure content stays above the watermark */
        .data-section > * {
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .mobile-print-btn {
                display: block;
            }
        }

        @media print {
            .mobile-print-btn {
                display: none !important;
            }

            /* Some browsers need this to print background images */
            body, .invoice, .data-section::before {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body dir="rtl">
<button onclick="window.print()" class="mobile-print-btn no-print">
    <i class="fas fa-print"></i>
</button>
@foreach($camels as $camel)
    <div class="container w-75 p-5 invoice" id="invoice">
        <div class="row position-relative header-banner">
            <div class="col-7 px-5 pt-3">
                <div class="d-flex flex-column px-1 header-title">
                    <h1 class="fw-bolder fs-2 main-title">
                        اللجنة المنظمة لسباق الهجن
                    </h1>
                    <div class="d-flex align-items-center gap-4 py-2 border rounded-3 sub-title">
                        <i class="fas fa-hand-point-left icon"></i>
                        <h2 class="title-text">نموذج تشبية مطية</h2>
                    </div>
                </div>
            </div>
            <div class="col-5 h-100">
                <div class="d-flex justify-content-center align-items-center position-relative h-100">
                    <img src="{{asset('assets/print-assets/images/enhanced_logo.png')}}" alt="logo"
                         class="img img-fluid logo-img">
                </div>
            </div>
        </div>
        <form action="get" method="">
            <div class="row data-section">
                <div class="col-1 px-4 h-100">
                    <div class="vertical-text-container bg-red">
                        <h5 class="vertical-text">بيانات المالك والمطية</h5>
                    </div>
                </div>

                <div class="col-11 p-3 h-100">
                    <div class="row align-items-center mb-4 ps-5">
                        <!-- Removed register type check boxes as requested -->
                    </div>

                    <div class="row align-items-center mb-4 ps-5 order">
                        <!-- Order Number Section -->
                        <div class="col-8">
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="national-id">رقم الشريحة</label>
                                </div>
                                <div class="col-9">
                                    <span class="form-control input-custom bg-light-red">

                                        {{ $camel->barcode }}
                                    </span>
                                </div>
                            </div>

                        </div>
                        <div class="col-4">
                            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($camel->barcode, 'C128',1.5,60,array(1,1,1), true) }}" alt="barcode" />

                        </div>

                        <!-- Request Date Section -->

                    </div>

                    <div class="row align-items-center mb-4 ps-5 target">
                        <!-- Left Column (Form Inputs) -->
                        <div class="col-8">
                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="national-id">رقم هوية المشارك</label>
                                </div>
                                <div class="col-9">
                                    <span class="form-control input-custom bg-light-red">

                                        {{ !$camel->modammer || optional($camel->modammer)->name == 'نفسة' ?  $camel->owner->register_symbol .$camel->owner->register_number : optional($camel->modammer)->modammer_number}}
                                    </span>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="name">اســـم المـــــــــالــك</label>
                                </div>
                                <div class="col-9">
                                    <span class="form-control input-custom bg-light-blue">
                                        {{$camel->owner->name}}
                                    </span>
                                </div>
                            </div>

                            <div class="row align-items-center mb-3">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="nationality">جنسية المــــــــالـك</label>
                                </div>
                                <div class="col-9">
                                    <span class="form-control input-custom bg-light-red">
                                         {{$camel->owner->nationality ?? 'قطري'}}
                                    </span>
                                </div>
                            </div>


                        </div>

                        <div class="col-4 payment-info bg-white"
                             style="margin-left: 0; padding: 0; margin-right: auto; width: 235px; height: 170px; overflow: hidden;">


                        </div>


                    </div>

                    <div class="row align-items-center mb-4 ps-5">
                        <div class="col-6">
                            <div class="row align-items-center">
                                <div class="col-4">
                                    <label class="fw-bold fs-5" for="mount-name">إسم المطية</label>
                                </div>
                                <div class="col-8">
                                    <span class="form-control bg-light-red input-mount-name">
                                        {{$camel->name ?? '-'}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="mount-name">الفئة</label>
                                </div>
                                <div class="col-4 d-flex category-container">
                                    <div class="category-label-input">
                                        <label class="form-check-label category-label" for="category-option-1"
                                               style="width: 50%; line-height: 2.5rem;">
                                            بكرة
                                        </label>
                                        <span class="custom-input form-check-input category-input">
                                            @if($camel->gender == 'bekraa')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4 d-flex category-container">
                                    <div class="category-label-input">
                                        <label class="form-check-label category-label" for="category-option-2"
                                               style="width: 50%; line-height: 2.5rem;">
                                            قعود
                                        </label>
                                        <span class="custom-input form-check-input category-input-alt bg-light-red">
                                            @if($camel->gender == 'kaood')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4 ps-5">
                        <div class="col-2">
                            <label class="fw-bold fs-5" for="age">السن</label>
                        </div>
                        <div class="col-10">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-2 d-flex p-0 custom-radio-container">
                                    <div class="custom-radio-wrapper">
                                        <label class="form-check-label fw-bold text-center" for="age-option-1">
                                            مفاريد
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->age == 'mafareed')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2 d-flex p-0 custom-radio-container">
                                    <div class="custom-radio-wrapper">
                                        <label class="form-check-label fw-bold text-center" for="age-option-2">
                                            حقايق
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->age == 'haqayq')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2 d-flex p-0 custom-radio-container">
                                    <div class="custom-radio-wrapper">
                                        <label class="form-check-label fw-bold text-center" for="age-option-3">
                                            لقايا
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->age == 'laqaya')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2 d-flex p-0 custom-radio-container">
                                    <div class="custom-radio-wrapper">
                                        <label class="form-check-label fw-bold text-center" for="age-option-4">
                                            جذاع
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->age == 'gezaa')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2 d-flex p-0 custom-radio-container">
                                    <div class="custom-radio-wrapper">
                                        <label class="form-check-label fw-bold text-center" for="age-option-5">
                                            ثنايا
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->age == 'thanaya')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-2 d-flex p-0 custom-radio-container">
                                    <div class="custom-radio-wrapper">
                                        <label class="form-check-label fw-bold text-center" for="age-option-6">
                                            حيل وزمول
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->age == 'zamool' || $camel->age == 'heeyal')
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row align-items-center ps-5">
                        <div class="col-6">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="father-name">إسم الأب</label>
                                </div>
                                <div class="col-9 p-0">
                                    <span class="form-control input-custom bg-light-red">
                                        {{$camel->father_name ?? '-'}}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row align-items-center">
                                <div class="col-3">
                                    <label class="fw-bold fs-5" for="mother-name">إسم الأم</label>
                                </div>
                                <div class="col-9 p-0">
                                    <span class="form-control input-custom bg-light-red">
                                        {{$camel->mother_name ?? '-'}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <div class="row align-items-center mb-4 ps-5 committee-decision">
                        <div class="col-12 text-center">
                            <h1 class="fw-bold m-0" style="white-space: nowrap;">قرار اللجنة</h1>
                        </div>

                        <div class="col-12 d-flex justify-content-center">
                            <div class="row align-items-center justify-content-center text-center w-100"
                                 style="max-width: 700px; margin: 0 auto;">
                                <div class="col-4 d-flex p-0 radio-container">
                                    <div class="radio-content w-100 justify-content-center">
                                        <label class="form-check-label fw-bold text-center" for="mount-type-option-1">
                                            عمانيات
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->camel_type == 2)
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4 d-flex p-0 radio-container">
                                    <div class="radio-content w-100 justify-content-center">
                                        <label class="form-check-label fw-bold text-center" for="mount-type-option-2">
                                            مهجنات
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->camel_type == 1)
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div class="col-4 d-flex p-0 radio-container">
                                    <div class="radio-content w-100 justify-content-center">
                                        <label class="form-check-label fw-bold text-center" for="mount-type-option-3">
                                            سودانيات
                                        </label>
                                        <span class="custom-input form-check-input">
                                            @if($camel->camel_type == 3)
                                                ✓
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>
@endforeach
<script src="{{asset('assets/print-assets/libraries/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('assets/print-assets/libraries/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/print-assets/libraries/fontawesome/js/all.js')}}"></script>
<script src="{{asset('assets/print-assets/libraries/fontawesome/js/all.min.js')}}"></script>

</body>

</html>
