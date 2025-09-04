<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('camels.store') }}">
    @csrf
    <input type="hidden" name="owner_id" value="{{ request('owner') }}" />

    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم الشريحة<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" name="barcode" value="" minlength="15" maxlength="15" pattern="\d{15}" inputmode="numeric"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">الاسم</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="name" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">اسم الاب</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="father_name" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">اسم الام</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="mother_name" value=""/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">النوع</span>
            </label>
            <select class="form-control" name="gender">
                <option value="">اختر</option>
                <option value="bekraa">بكرة</option>
                <option value="kaood">قعود</option>
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">العمر</span>
            </label>
            <select class="form-control" name="age">
                <option value="">اختر</option>
                <option value="mafareed">مفاريد</option>
                <option value="haqayq">حقايق</option>
                <option value="laqaya">لقايا</option>
                <option value="gezaa">جذاع</option>
                <option value="thanaya">ثنايا</option>
                <option value="zamool">زمول</option>
                <option value="heeyal">حيل</option>
            </select>
        </div>
    </div>
</form>
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
