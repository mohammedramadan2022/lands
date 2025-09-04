<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('owners.update', $owner->id) }}">
    @csrf
    @method('PUT')

    <div class="row g-4">
        @php
            $registerSymbol = substr($owner->register_number, 0, 3); // أول 3 حروف هم الكود
        @endphp
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم المشاركة<span class="red-star">*</span></span>
            </label>

            <div class="d-flex align-items-center gap-3">
                <input type="text" class="form-control form-control-solid " style="margin-left: -6.5rem !important; "
                       placeholder="" name="register_number" value="{{$owner->register_number}}"/>

                <select class="form-select me-2"
                        style="max-width: 80px; color: #000; background-color: #fff; padding-top: 2px;"
                        name="register_symbol" id="register-symbol">
                    <option value="QAR" @if($registerSymbol == 'QAR') selected @endif>QAR</option>
                    <option value="KSA" @if($registerSymbol == 'KSA') selected @endif>KSA</option>
                    <option value="UAE" @if($registerSymbol == 'UAE') selected @endif>UAE</option>
                    <option value="OMN" @if($registerSymbol == 'OMN') selected @endif>OMN</option>
                    <option value="KWT" @if($registerSymbol == 'KWT') selected @endif>KWT</option>
                    <option value="BHR" @if($registerSymbol == 'BHR') selected @endif>BHR</option>
                </select>
            </div>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name"
                   value="{{$owner->name}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> نوع العضوية </span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="is_member" name="is_member">
                @foreach (ownerTypes() as $key => $name)
                    <option value="{{ $key }}" @selected($owner->is_member == $key)> {{ $name }} </option>
                @endforeach
            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الجنسيه		</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="nationality" name="nationality">
                <option value="قطري" @if($owner->nationality == 'قطري') selected @endif>قطرى</option>
                <option value="سعودي" @if($owner->nationality == 'سعودي') selected @endif>سعودى</option>
                <option value="اماراتي" @if($owner->nationality == 'اماراتي') selected @endif>اماراتى</option>
                <option value="عماني" @if($owner->nationality == 'عماني') selected @endif>عماني</option>
                <option value="بحريني" @if($owner->nationality == 'بحريني') selected @endif>بحرينى</option>
                <option value="كويتي" @if($owner->nationality == 'كويتي') selected @endif>كويتي</option>

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">المضمر</span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" name="modammer_name"
                   value="{{$owner->modammer_name ?? 'نفسه'}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الهاتف<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="phone"
                   value="{{$owner->phone}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم الهويه<span class="red-star">*</span></span>
            </label>
            <input type="text" class="form-control form-control-solid" placeholder="" name="national_id"
                   value="{{$owner->national_id}}"/>
        </div>

        {{--        <div class="d-flex flex-column mb-7 fv-row col-sm-6">--}}
        {{--            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">--}}
        {{--                <span class="required mr-1">الباسورد<span class="red-star">*</span></span>--}}
        {{--            </label>--}}
        {{--            <input  type="text" class="form-control form-control-solid" placeholder="" name="password" value=""/>--}}
        {{--        </div>--}}


    </div>

</form>
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
