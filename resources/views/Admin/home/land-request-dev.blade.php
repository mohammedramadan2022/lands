<div class="card d-flex justify-content-center mt-6">
    @php
        $statusText = null;
        if(isset($landRequest) && $landRequest){
            $val = trim((string)($landRequest->check_status ?? ''));
            if ($val !== '') {
                $lower = mb_strtolower($val);
                if (in_array($lower, ['1','yes','true','success','passed','ناجح','اجتاز'])) {
                    $statusText = 'اجتاز';
                } elseif (in_array($lower, ['0','no','false','failed','فاشل','لم يجتاز'])) {
                    $statusText = 'لم يجتاز';
                } else {
                    $statusText = $landRequest->check_status;
                }
            } else {
                $statusText = 'لم يتم التحقق';
            }
        }
    @endphp

    @if($landRequest)
        <div class="text-center border rounded p-4">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="fw-bold fs-5">الاسم</div>
                    <div class="fs-6">{{ $landRequest->applicant_name }}</div>
                </div>
                <div class="col-md-3">
                    <div class="fw-bold fs-5">رقم الهوية</div>
                    <div class="fs-6">{{ $landRequest->national_id }}</div>
                </div>
                <div class="col-md-3">
                    <div class="fw-bold fs-5">الجوال</div>
                    <div class="fs-6">{{ $landRequest->phone ?? '-' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="fw-bold fs-5">الحالة</div>
                    <div class="fs-6">{{ $statusText }}</div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center border rounded p-4">
            <div class="fs-6">لا يوجد طلب أرض برقم الهوية: <span class="fw-bold">{{ $nationalId }}</span></div>
        </div>
    @endif
</div>
