<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/dashboard')}}/plugins/global/plugins.bundle.js"></script>
<script src="{{asset('assets/dashboard')}}/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('assets/dashboard')}}/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('assets/dashboard')}}/js/custom/widgets.js"></script>
<script src="{{asset('assets/dashboard')}}/js/custom/apps/chat/chat.js"></script>
<script src="{{asset('assets/dashboard')}}/js/custom/modals/create-app.js"></script>
<script src="{{asset('assets/dashboard')}}/js/custom/modals/upgrade-plan.js"></script>


<script src="{{url('assets')}}/dashboard/js/jquery.fancybox.min.js"></script>

<script src="{{url('assets')}}/dashboard/backEndFiles/alertify/alertify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- <script src="{{url('assets')}}/dashboard/js/dropify/dropify.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
<script src="{{url('assets')}}/dashboard/AE_style/AE_script.js"></script>



@yield('js')

<script>
    $('.select2').select2({
        dropdownParent: $('.modal') // المودال الأب
    });
</script>
<script>
    $(document).ready(function () {
        $('.dropify').dropify();
    });
</script>


<script>
    // Ensure the hourglass loader hides on initial ready and DOM load
    function hideHourglass(reason) {
        try {
            // Use stop(true, true) to clear queued animations that might keep it visible
            $('.lds-hourglass').stop(true, true).fadeOut(200);
        } catch (e) { /* no-op */ }
    }

    // Hide on both DOMContentLoaded and jQuery ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function(){ hideHourglass('dom'); });
    } else {
        hideHourglass('dom-immediate');
    }
    $(function(){ hideHourglass('jquery-ready'); });

    // Global AJAX hooks: hide when all AJAX requests have completed
    if ($ && $.ajaxSetup) {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $(document).ajaxStop(function(){ hideHourglass('ajaxStop'); });
    }

    $(document).on('keyup','.numbersOnly',function () {
        this.value = this.value.replace(/[^0-9\.]/g,'');
    });

    // Show global page loader when submitting any form that contains a file input
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (form && form.tagName === 'FORM') {
            var hasFileInput = form.querySelector('input[type="file"]');
            if (hasFileInput) {
                try { $('.lds-hourglass').stop(true, true).fadeIn(200); } catch(err) { /* no-op */ }
            }
        }
    }, true);

    // Also show the loader on navigation/unload (useful for slow redirects after upload)
    window.addEventListener('beforeunload', function () {
        try { $('.lds-hourglass').stop(true, true).show(); } catch(err) { /* no-op */ }
    });

    // If a success message "تم الاستيراد بنجاح" appears in the DOM (toast, alert, etc.), hide loader
    const successPhrases = ['تم الاستيراد بنجاح'];
    const observer = new MutationObserver(function(mutations){
        for (const m of mutations) {
            if (m.addedNodes && m.addedNodes.length) {
                for (const node of m.addedNodes) {
                    try {
                        const text = (node.innerText || node.textContent || '').trim();
                        if (text) {
                            if (successPhrases.some(p => text.includes(p))) {
                                hideHourglass('success-text');
                                return;
                            }
                        }
                        // Also scan inside new containers
                        if (node.querySelectorAll) {
                            const all = node.querySelectorAll('*');
                            for (const el of all) {
                                const t = (el.innerText || el.textContent || '').trim();
                                if (t && successPhrases.some(p => t.includes(p))) {
                                    hideHourglass('success-text-deep');
                                    return;
                                }
                            }
                        }
                    } catch(_) {}
                }
            }
        }
    });
    try { observer.observe(document.body, { childList: true, subtree: true }); } catch(_) {}

    // Safety: auto-hide after max 30 seconds from page load
    setTimeout(function(){ hideHourglass('safety-timeout'); }, 30000);
</script>


<script>
    window.addEventListener('online', () =>{
        alertify.success('{{helperTrans('admin.Internet service is back!')}}');
    });
    window.addEventListener('offline', () =>{
        alertify.error('{{helperTrans('admin.There is no internet service!')}}');
    });

    $(document).ready(function() {
        // Get the current URL path
        var path = window.location.href;

        // Select all <a> tags within elements with class "menu-link"
        $('.menu-link-active').each(function() {
            // Get the href attribute value
            var href = $(this).attr('href');


            // Check if the href attribute matches the current path
            if (path === href) {
                // Add the 'active' class to the parent element with class 'menu-item'
                $(this).addClass('active');
            } else {
                // Remove the 'active' class if it's not the current page
                $(this).removeClass('active');
            }
        });
    });


</script>


<script>
    @isset(admin()->user()->id)

    $(document).on('click', '.editProfile', function (e) {
        e.preventDefault()
        var id = $(this).attr('id');

        var url = '{{route('admins.show',admin()->user()->id)}}';

        $.ajax({
            url: url,
            type: 'GET',
            beforeSend: function () {
                $('.loader-ajax').show()
            },
            success: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit-addOrDelete').html(data.html);
                $('#profileEdit').modal('show')
                $('#logoOfAdmin').dropify();


            },
            error: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit-addOrDelete').html('<h3 class="text-center">{{helperTrans('admin.You do not have the authority')}}</h3>')
            }
        });

    });


    $(document).on('submit', 'form#EditForm', function (e) {
        e.preventDefault();
        var myForm = $("#EditForm")[0]
        var formData = new FormData(myForm)
        var url = $('#EditForm').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function () {
                $('.loader-ajax').show()
            },
            complete: function () {


            },
            success: function (data) {
                $('.loader-ajax').hide()
                $('#profileEdit').modal('hide')
                $(".header-profile-user").attr("src", data.logo);
                $(".user-name-text").html(data.name);
                $(".user-name-sub-text").html(data.business_name);

                // $('#page-header-user-dropdown').html(data[html]);
                toastr.success("{{helperTrans('admin.Your file has been successfully modified')}}")

            },
            error: function (data) {
                $('.loader-ajax').hide()
                if (data.status === 500) {
                    $('#profileEdit').modal("hide");

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
            },//end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });

    @endisset

    $(document).on('click','.deleteAllNotifications',function (){
        swal.fire({
            title: "هل انت متاكد من الحذف؟",
            text: "لا تستطيع الرجوع فى ذلك",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "حذف",
            cancelButtonText: "الغاء",
            okButtonText: "نعم",
            closeOnConfirm: false
        }).then((result) => {
            if (!result.isConfirmed) {
                return true;
            }


            var deleteRoute = '';
            $.ajax({
                url: deleteRoute,
                type: 'POST',
                beforeSend: function() {
                    $('.loader-ajax').show()

                },
                success: function(data) {

                    window.setTimeout(function() {
                        $('.loader-ajax').hide()
                        if (data.code == 200) {
                            toastr.success(data.message)
                            $('#table').DataTable().ajax.reload(null, false);
                            $('#notification_header_container').html('');
                        } else {
                            toastr.error('there is an error')
                        }

                    }, 1000);
                },
                error: function(data) {

                    if (data.code === 500) {
                        toastr.error('there is an error')
                    }


                    if (data.code === 422) {
                        var errors = $.parseJSON(data.responseText);

                        $.each(errors, function(key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function(key, value) {
                                    toastr.error(value)
                                });

                            } else {

                            }
                        });
                    }
                }

            });
        });
    })
</script>
