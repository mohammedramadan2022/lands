<!--begin::Form-->

<form id="form" enctype="multipart/form-data" method="POST" action="{{route('contacts.update',$row->id)}}">
    @csrf
    @method('PUT')
    <div class="row g-4">


        <input type="hidden" name="id" value="{{$row->id}}">

        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="name" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class=" mr-1">الاسم</span>
            </label>
            <!--end::Label-->
            <input readonly id="name" required type="text" class="form-control form-control-solid" placeholder="" name="name"
                   value="{{$row->name}}"/>
        </div>

        <div  class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="email" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">البريد الالكتروني</span>
            </label>
            <!--end::Label-->
            <input readonly id="email" required type="text" class="form-control form-control-solid" placeholder="" name="email"
                   value="{{$row->email}}"/>
        </div>
        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="phone" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class=" mr-1"> الهاتف</span>
            </label>
            <!--end::Label-->
            <input readonly id="phone" required type="text" class="form-control form-control-solid" placeholder="" name="phone"
                   value="{{$row->phone}}"/>
        </div>


        <div class="d-flex flex-column mb-7 fv-row col-sm-6">
            <!--begin::Label-->
            <label for="title" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class=" mr-1"> عنوان الرسالة</span>
            </label>
            <!--end::Label-->
            <input readonly id="title" required type="text" class="form-control form-control-solid" placeholder="" name="title"
                   value="{{$row->title}}"/>
        </div>



        <div class="col-sm-12 pb-3 p-2">
            <label for="message" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class=" mr-1">المحتوي</span>
            </label>
            <textarea readonly name="message" id="message" class="form-control " rows="5"
                      placeholder="">{{$row->message}}</textarea>
        </div>



        <div class="col-sm-12 pb-3 p-2">
            <label for="replay_message" class="d-flex align-items-center fs-6 fw-bold form-label mb-2">
                <span class="required mr-1">الرد</span>
            </label>
            <textarea  name="replay_message" id="replay_message" class="form-control " rows="5"
                      placeholder=""></textarea>
        </div>

    </div>
</form>
