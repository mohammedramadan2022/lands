<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم العضو</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-header {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .camel-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            overflow: hidden;
        }
        .camel-details {
            padding: 20px;
        }
        .vote-section {
            padding: 15px;
            background-color: #f8f9fa;
            border-top: 1px solid #eee;
        }
        .btn-vote {
            width: 100%;
            margin-top: 10px;
        }
        .btn-logout {
            margin-right: 10px;
        }
        /* RTL specific styles */
        .form-check {
            padding-right: 1.5em;
            padding-left: 0;
        }
        .form-check .form-check-input {
            float: right;
            margin-right: -1.5em;
            margin-left: 0;
        }
        .barcode-container {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
@php
    $genderLabels = [
        'bekraa' => 'بكرة',
        'kaood' => 'قعود',
    ];
    $ageLabels = [
        'mafareed' => 'مفاريد',
        'haqayq' => 'حقايق',
        'laqaya' => 'لقايا',
        'gezaa' => 'جذاع',
        'thanaya' => 'ثنايا',
        'zamool' => 'زمول',
        'heeyal' => 'حيل',
    ];
@endphp
    <div class="container">
        <div class="dashboard-header d-flex justify-content-between align-items-center">
            <div>
                <h2>مرحباً، {{ $member->name }}</h2>
                <p class="text-muted mb-0">لوحة تحكم العضو</p>
            </div>
            <form action="{{ route('member.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-logout">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </button>
            </form>
        </div>

        <div class="row">
            @foreach($camels as $camel)
            <div class="col-md-4">
                <div class="camel-card">
                    <div class="camel-details">
                        <h4>{{ 'مطية رقم ' . $camel->id }}</h4>

                        @if($camel->barcode)
                        <div class="barcode-container text-center my-3">
                            <p class="mb-1 fw-bold">رقم الشريحة:</p>
                            <p class="mt-1 fs-5">{{ $camel->barcode }}</p>
                        </div>
                        @endif

                        <div class="mt-3">
                            <h6 class="fw-bold">بيانات المطية:</h6>
                            <ul class="mb-2">
                                <li>اسم الأب: {{ $camel->father_name ?? '-' }}</li>
                                <li>اسم الأم: {{ $camel->mother_name ?? '-' }}</li>
                                <li>الجنس: {{ $genderLabels[$camel->gender] ?? '-' }}</li>
                                <li>العمر: {{ $ageLabels[$camel->age] ?? '-' }}</li>
                            </ul>
                            <h6 class="fw-bold">بيانات المالك:</h6>
                            @if($camel->owner)
                                <ul class="mb-0">
                                    <li>الاسم: {{ $camel->owner->name }}</li>
                                    <li>الهاتف: {{ $camel->owner->phone }}</li>
                                    <li>رقم المشاركة: {{ $camel->owner->register_symbol.$camel->owner->register_number  }}</li>
                                </ul>
                            @else
                                <p class="text-muted mb-0">لا توجد بيانات مالك.</p>
                            @endif
                        </div>
                    </div>

                    <div class="vote-section">
                        <form action="{{ route('member.store-vote') }}" method="POST">
                            @csrf
                            <input type="hidden" name="camel_id" value="{{ $camel->id }}">

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="vote" id="vote_omaniat_{{ $camel->id }}" value="omaniat" required>
                                <label class="form-check-label" for="vote_omaniat_{{ $camel->id }}">
                                    عمانيات
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="vote" id="vote_mohagnat_{{ $camel->id }}" value="mohagnat">
                                <label class="form-check-label" for="vote_mohagnat_{{ $camel->id }}">
                                    مهجنات
                                </label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-vote">
                                <i class="fas fa-vote-yea"></i> إرسال التصويت
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
