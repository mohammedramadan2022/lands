<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('permissions.store')}}">
    @csrf
    <div class="row g-4">

        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name" value=""/>
        </div>

        <input type="hidden" name="guard_name" value="admin">



    </div>
</form>

