<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('admins.update',$admin->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$admin->id}}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <label for="name" class="form-control-label">الصورة </label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file($admin->image)}}"
                   accept="image/*"/>
            <span
                class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="text" required class="form-control form-control-solid" placeholder=" " name="name"
                   value="{{$admin->name}}"/>
        </div>

        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> البريد الالكتروني</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="email" required class="form-control form-control-solid"
                   placeholder="  {{helperTrans('admin.email')}}"
                   name="email" value="{{$admin->email}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> الهاتف</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input id="phone" type="text" class="form-control form-control-solid" placeholder=" " name="phone"
                   value="{{$admin->phone}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1"> كلمة المرور</span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <input type="password" class="form-control form-control-solid" placeholder="  " name="password"
                   value=""/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="is_active" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">حالة التفعيل </span>
                <span class="red-star">*</span>
            </label>
            <!--end::Label-->
            <select class="form-control" id="is_active" name="is_active">

                <option @if($admin->is_active==1) selected @endif value="1">مفعل</option>
                <option @if($admin->is_active==0) selected @endif value="0">غير مفعل </option>

            </select>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="roles" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الدور</span>
                <span class="red-star">*</span>
            </label>
            <select id="roles" class="js-example-basic-multiple" name="roles[]" multiple="multiple">
                @foreach($roles as $role)
                    <option @foreach($admin_roles_ides as $role_id) @if($role_id==$role->id) selected @endif @endforeach value="{{$role->id}}">{{$role->name??''}}</option>
                @endforeach
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
