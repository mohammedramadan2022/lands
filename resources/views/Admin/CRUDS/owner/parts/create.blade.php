<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('owners.store') }}">
    @csrf
    <div class="row g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم المشاركة<span class="red-star">*</span></span>
            </label>

            <div class="d-flex align-items-center gap-3">
                <input type="text" class="form-control form-control-solid "  style="margin-left: -6.5rem !important; " placeholder="" name="register_number" value="" />

                <select class="form-select me-2" style="max-width: 80px; color: #000; background-color: #fff; padding-top: 2px;" name="register_symbol" id="register-symbol">
                    <option value="QAR">QAR</option>
                    <option value="KSA">KSA</option>
                    <option value="UAE">UAE</option>
                    <option value="OMN">OMN</option>
                    <option value="KWT">KWT</option>
                    <option value="BHR">BHR</option>
                </select>
            </div>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> نوع العضوية </span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="is_member" name="is_member">
                @foreach (ownerTypes() as $key => $name)
                    <option  value="{{ $key }}"> {{ $name }} </option>
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
                <option value="قطري">قطري</option>
                <option value="سعودي">سعودي</option>
                <option value="اماراتي">اماراتي</option>
                <option value="عماني">عماني</option>
                <option value="بحريني">بحريني</option>
                <option value="كويتي">كويتي</option>

            </select>
        </div>

{{--        <div class="d-flex flex-column mb-7 fv-row col-sm-6">--}}
{{--            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">--}}
{{--                <span class="required mr-1">المضمر<span class="red-star">*</span></span>--}}
{{--            </label>--}}
{{--            <input  type="text" class="form-control form-control-solid" placeholder="" name="modammer_name" value="نفسه"/>--}}
{{--        </div>--}}

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الهاتف<span class="red-star">*</span></span>
            </label>
            <input required type="tel" class="form-control form-control-solid" placeholder="" name="phone" value=""/>

        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم الهويه<span class="red-star">*</span></span>
            </label>
            <input  type="text" class="form-control form-control-solid" placeholder="" name="national_id" value=""/>
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
