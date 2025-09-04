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
            <input required type="text" class="form-control form-control-solid" name="barcode" value="{{ old('barcode', $camel->barcode) }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">الاسم</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $camel->name) }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">اسم الاب</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="father_name" value="{{ old('father_name', $camel->father_name) }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">اسم الام</span>
            </label>
            <input type="text" class="form-control form-control-solid" name="mother_name" value="{{ old('mother_name', $camel->mother_name) }}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">النوع</span>
            </label>
            <select class="form-control" name="gender">
                <option value="">اختر</option>
                <option value="bekraa" {{ old('gender', $camel->gender) == 'bekraa' ? 'selected' : '' }}>بكرة</option>
                <option value="kaood" {{ old('gender', $camel->gender) == 'kaood' ? 'selected' : '' }}>قعود</option>
            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">العمر</span>
            </label>
            <select class="form-control" name="age">
                <option value="">اختر</option>
                <option value="mafareed" {{ old('age', $camel->age) == 'mafareed' ? 'selected' : '' }}>مفاريد</option>
                <option value="haqayq" {{ old('age', $camel->age) == 'haqayq' ? 'selected' : '' }}>حقايق</option>
                <option value="laqaya" {{ old('age', $camel->age) == 'laqaya' ? 'selected' : '' }}>لقايا</option>
                <option value="gezaa" {{ old('age', $camel->age) == 'gezaa' ? 'selected' : '' }}>جذاع</option>
                <option value="thanaya" {{ old('age', $camel->age) == 'thanaya' ? 'selected' : '' }}>ثنايا</option>
                <option value="zamool" {{ old('age', $camel->age) == 'zamool' ? 'selected' : '' }}>زمول</option>
                <option value="heeyal" {{ old('age', $camel->age) == 'heeyal' ? 'selected' : '' }}>حيل</option>
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

<script>
// Enforce 15-digit numeric barcode on edit form
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[name="barcode"]').forEach(function(el){
        el.setAttribute('inputmode', 'numeric');
        el.setAttribute('maxlength', '15');
        el.setAttribute('minlength', '15');
        el.setAttribute('pattern', '\\d{15}');
        el.addEventListener('input', function(){
            this.value = this.value.replace(/\\D/g,'').slice(0,15);
        });
    });
});
</script>
