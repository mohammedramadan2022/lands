<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('admin.update.password',$row->id)}}">
    @csrf
    <div class="row g-4">


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="password" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">كلمة المرور</span>

            </label>
            <!--end::Label-->
            <input id="password" type="password" class="form-control form-control-solid" placeholder=" " name="password"
                   value=""/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="password_confirmation" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">تاكيد كلمة المرور</span>

            </label>
            <!--end::Label-->
            <input id="password_confirmation" type="password" class="form-control form-control-solid" placeholder=" "
                   name="password_confirmation" value=""/>
        </div>


    </div>
</form>

