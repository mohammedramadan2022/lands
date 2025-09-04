<div class="card d-flex justify-content-center">

    @if($camel)
        <div class="text-center border rounded">
            <label for="" class="fw-bold fs-4">رقم الشريحه : {{$camel->barcode}}</label>
            <br>
            <label for = "" class = "fw-bold fs-4">نتيجه التصويت : {{$camel->final_vote == 1 ? 'عمانية' :($camel->final_vote == 2 ?  'مهجنة' : 'بانتظار امر الرئيس')}}</label>
            <br>
            <label for="" class="fw-bold fs-4">مصدر التصويت : {{$camel->vote_source == 'normal' ? 'تصويت' : ($camel->vote_source == 'excel' ? 'اكسيل' : 'امر رئيس اللجنه') }}</label>
            <br>
            <label for="" class="fw-bold fs-4">مصدر المطية : {{$camel->source == 'normal' ? 'اضافه عادية' : 'اكسيل'}}</label>
            <br>
            @if($camel->final_vote == 2)
                <a class="btn btn-primary" href="{{route('admin.addVote', $camel)}}">اعادة نظر</a>
            @elseif($camel->final_vote == 0)
                <form action="{{route('admin.super-vote')}}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="mohagnat_for_manager" value="1">
                    <input type="hidden" name="barcode" value="{{$camel->barcode}}">
                    <button type="submit" class="btn btn-success">مهجنة</button>
                </form>
                <form action="{{route('admin.super-vote')}}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="omaniat_for_manager" value="1">
                    <input type="hidden" name="barcode" value="{{$camel->barcode}}">
                    <button type="submit" class="btn btn-warning">عمانية</button>
                </form>
            @endif
        </div>
    @else
        <div class="text-center border rounded">
            <a  class="btn btn-primary" href="{{route('admin.addVote' , ['barcode'=>$barcode])}}">تصويت</a>
        </div>
    @endif

</div>
