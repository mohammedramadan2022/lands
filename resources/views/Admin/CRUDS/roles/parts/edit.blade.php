<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('roles.update',$role->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$role->id}}">
        <input type="hidden" name="guard_name" value="admin">


        <div class="d-flex flex-column mb-7 fv-row col-sm-12">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name"
                   value="{{$role->name}}"/>
        </div>


        <div class="d-flex justify-content-center mt-3">

            <div class="col-md-12 p-1">
                    <span class="form-check form-switch  " @if( app()->getLocale()=='en') style="border:0px solid #F3F3F9;border-radius: 4px;" @else  style="border:0px solid #F3F3F9; border-radius: 4px;" @endif>
                      <input class="form-check-input  " type="checkbox" name="check_all" value=""
                             id="check_all">
                      <label class="form-check-label mx-1" for="check_all">
                       تحديد الكل
                      </label>
                    </span>
            </div>

        </div>




        <div class=" row my-4" id="permission_data">

            @foreach($permission as $row)
                <div class="col-md-3 p-1">
                    <span class="form-check form-switch   " @if( app()->getLocale()=='en') style="border:1px solid #F3F3F9;padding: 10px; padding-left: 40px;border-radius: 4px;" @else  style="border:1px solid #F3F3F9;padding: 10px; padding-right: 40px;border-radius: 4px;" @endif>
                      <input @foreach($rolePermissions as $pivot) @if($pivot->permission_id==$row->id) checked @endif @endforeach class="form-check-input  checkbox" type="checkbox" name="permission[]" value="{{$row->id}}"
                             id="flexCheckDefault{{$row->id}}">
                      <label class="form-check-label mx-1" for="flexCheckDefault{{$row->id}}">
                       {{$row->name}}
                      </label>
                    </span>
                </div>
            @endforeach
        </div>


    </div>
</form>
