<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>

<script>
    $('.dropify').dropify();


</script>


<script>
    $(document).on('submit', "form#form", function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        var url = $('#form').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function() {


                $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                    ' ></span> <span style="margin-left: 4px;">جاري التنفيذ</span>').attr(
                    'disabled', true);

            },

            complete: function () {
            },
            success: function (data) {

                $('#submit').html('تحديث').attr('disabled', false);

                window.setTimeout(function () {

// $('#product-model').modal('hide')
                    if (data.code == 200) {
                        toastr.success(data.message)
                    } else {
                        toastr.error(data.message)
                    }
                }, 1000);


            },
            error: function (data) {
                $('#submit').html('تحديث').attr('disabled', false);

                if (data.status === 500) {
                    toastr.error('{{helperTrans('admin.there is an error')}}')
                }

                if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);

                    $.each(errors, function (key, value) {
                        if ($.isPlainObject(value)) {
                            $.each(value, function (key, value) {
                                toastr.error(value)
                            });

                        } else {

                        }
                    });
                }
                if (data.status == 421) {
                    toastr.error(data.message)
                }

            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
</script>
