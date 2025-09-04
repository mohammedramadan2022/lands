<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('camels.update', $camel->id) }}">
    @csrf
    @method('PUT')
    <input type="hidden" name="owner_id" value="{{ $camel->owner_id }}" />
    <div class="row g-4">
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">رقم الشريحة<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" name="barcode" value="{{ $camel->barcode }}" minlength="15" maxlength="15" pattern="\d{15}" inputmode="numeric"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">الاسم</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="name" value="{{ $camel->name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">اسم الاب</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="father_name" value="{{ $camel->father_name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">اسم الام</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="mother_name" value="{{ $camel->mother_name }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">النوع</span>
            </label>
            <select class="form-control" name="gender">
                <option value="">اختر</option>
                <option value="bekraa" @selected($camel->gender==='bekraa')>بكرة</option>
                <option value="kaood" @selected($camel->gender==='kaood')>قعود</option>
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">العمر</span>
            </label>
            <select class="form-control" name="age">
                <option value="">اختر</option>
                <option value="mafareed" @selected($camel->age==='mafareed')>مفاريد</option>
                <option value="haqayq" @selected($camel->age==='haqayq')>حقايق</option>
                <option value="laqaya" @selected($camel->age==='laqaya')>لقايا</option>
                <option value="gezaa" @selected($camel->age==='gezaa')>جذاع</option>
                <option value="thanaya" @selected($camel->age==='thanaya')>ثنايا</option>
                <option value="zamool" @selected($camel->age==='zamool')>زمول</option>
                <option value="heeyal" @selected($camel->age==='heeyal')>حيل</option>
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
