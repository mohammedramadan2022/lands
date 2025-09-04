<!--begin::Form-->
<form id="form" enctype="multipart/form-data" method="POST" action="{{ route('members.update' , $member->id) }}">
    @method('PUT')

    @csrf
    <div class="row g-4">



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم<span class="red-star">*</span></span>
            </label>
            <input required type="text" class="form-control form-control-solid" placeholder="" name="name" value="{{$member->name}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الدور</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="role" name="role">

                <option value="normal" @if($member->role == 'normal')selected @endif>عضو </option>
                <option value="manager" @if($member->role == 'manager')selected @endif>مدير اللجنه</option>

            </select>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">البريد الإلكتروني</span>
            </label>
            <input type="email" class="form-control form-control-solid" placeholder="" name="email" value="{{$member->email}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="mr-1">كلمة المرور (اتركها فارغة إذا لم ترغب في تغييرها)</span>
            </label>
            <input type="password" class="form-control form-control-solid" placeholder="" name="password"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <label for="name" class="form-control-label">الصورة </label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file($member->image)}}"
                   accept="image/*"/>
            <span
                class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
        </div>


    </div>
</form>
<script>
    $('.dropify').dropify();
    $(document).ready(function () {
        $('.js-example-basic-multiple').select2();
    });
</script>
