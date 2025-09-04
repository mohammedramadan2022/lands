<form action="{{route('admins.update',$admin->id)}}" method="post" id="EditForm">
    @csrf
    @method("PUT")

    <div class="row g-4">

        <input type="hidden" name="id" value="{{$admin->id}}">

        <div class="form-group">
            <label for="name" class="form-control-label">الصورة</label>
            <input type="file" class="dropify" name="image" data-default-file="{{get_file($admin->image)}}" accept="image/*"/>
            <span class="form-text text-muted text-center">يُسمح فقط بالتنسيقات التالية: jpeg، jpg، png، gif، svg، webp، avif.</span>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input type="text" required class="form-control form-control-solid" placeholder="الاسم"  name="name" value="{{$admin->name}}"/>
        </div>

        <!--end::Input group-->
        <!--begin::Input group-->
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">البريد الالكتروني</span>
            </label>
            <!--end::Label-->
            <input type="email" required class="form-control form-control-solid"  placeholder=" {{helperTrans('admin.email')}}" name="email" value="{{$admin->email}}"/>
        </div>

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الهاتف</span>
            </label>
            <!--end::Label-->
            <input  id="phone" type="text" class="form-control form-control-solid" placeholder=" " name="phone" value="{{$admin->phone}}"/>
        </div>



        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">  كلمة المرور</span>
            </label>
            <!--end::Label-->
            <input type="password" class="form-control form-control-solid" placeholder="  {{helperTrans('admin.password')}} " name="password" value=""/>
        </div>





    </div>
</form>
<script>
    $('.dropify').dropify();

</script>
