<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="{{ url('assets') }}/dashboard/js/sweet.js"></script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        new DataTable("#example");
    })
</script>

<script>
    var loader = ` <div class="linear-background">
                            <div class="inter-crop"></div>
                            <div class="inter-right--top"></div>
                            <div class="inter-right--bottom"></div>
                   </div>
        `;
    var newUrl = location.href;


    $(function () {
        console.log(window.location.href)
        // AE empty massage
        let SvgIcon = `
                <svg width="492" height="353" viewBox="0 0 492 353" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.3327 96.666H405.999V181.999H11.3327C8.50371 181.999 5.7906 180.876 3.79021 178.875C1.78982 176.875 0.666016 174.162 0.666016 171.333V107.333C0.666016 104.504 1.78982 101.791 3.79021 99.7902C5.7906 97.7898 8.50371 96.666 11.3327 96.666Z" fill="url(#paint0_linear_4097_9075)"/>
<path d="M406 330.159C405.983 334.626 404.644 338.987 402.151 342.693C399.658 346.399 396.124 349.284 391.994 350.984C387.864 352.684 383.323 353.123 378.943 352.245C374.564 351.368 370.543 349.213 367.387 346.053L294 272.666L326 240.666L399.387 314.053C401.513 316.156 403.195 318.667 404.331 321.434C405.467 324.201 406.035 327.168 406 330.159Z" fill="url(#paint1_linear_4097_9075)"/>
<path d="M299.333 192.666L334.427 227.759C335.426 228.751 336.22 229.931 336.762 231.231C337.303 232.53 337.582 233.925 337.582 235.333C337.582 236.741 337.303 238.135 336.762 239.435C336.22 240.735 335.426 241.914 334.427 242.906L296.24 281.093C295.248 282.092 294.069 282.886 292.769 283.428C291.469 283.969 290.075 284.248 288.667 284.248C287.259 284.248 285.864 283.969 284.565 283.428C283.265 282.886 282.085 282.092 281.093 281.093L246 245.999L299.333 192.666Z" fill="url(#paint2_linear_4097_9075)"/>
<path d="M192.667 277.999C269.25 277.999 331.333 215.916 331.333 139.333C331.333 62.7492 269.25 0.666016 192.667 0.666016C116.083 0.666016 54 62.7492 54 139.333C54 215.916 116.083 277.999 192.667 277.999Z" fill="url(#paint3_linear_4097_9075)"/>
<path d="M192.667 245.999C251.577 245.999 299.333 198.243 299.333 139.333C299.333 80.4223 251.577 32.666 192.667 32.666C133.756 32.666 86 80.4223 86 139.333C86 198.243 133.756 245.999 192.667 245.999Z" fill="url(#paint4_linear_4097_9075)"/>
<path d="M406 96.666H480.667C483.496 96.666 486.209 97.7898 488.209 99.7902C490.21 101.791 491.333 104.504 491.333 107.333V171.333C491.333 174.162 490.21 176.875 488.209 178.875C486.209 180.876 483.496 181.999 480.667 181.999H406V96.666Z" fill="#DD2222"/>
<path d="M184.858 154.22C184.96 149.067 186.472 144.041 189.228 139.686C191.984 135.331 195.88 131.814 200.494 129.516C203.375 127.928 205.682 125.471 207.085 122.495C208.489 119.519 208.918 116.176 208.312 112.943C207.928 108.796 205.913 104.971 202.71 102.31C199.506 99.6493 195.377 98.3699 191.23 98.7535C187.083 99.137 183.259 101.152 180.598 104.356C177.937 107.559 176.657 111.688 177.041 115.835C177.041 117.909 176.217 119.897 174.751 121.363C173.285 122.829 171.296 123.653 169.223 123.653C167.15 123.653 165.161 122.829 163.695 121.363C162.229 119.897 161.405 117.909 161.405 115.835C161.345 107.99 164.237 100.408 169.506 94.5954C174.776 88.7824 182.038 85.1626 189.851 84.454C197.665 83.7455 205.459 86 211.688 90.7703C217.917 95.5407 222.126 102.478 223.478 110.206C224.673 116.662 223.806 123.33 221 129.266C218.194 135.201 213.59 140.103 207.843 143.276C205.756 144.274 203.979 145.819 202.699 147.746C201.419 149.673 200.684 151.91 200.572 154.22C200.572 156.304 199.744 158.303 198.271 159.776C196.797 161.249 194.799 162.077 192.715 162.077C190.632 162.077 188.633 161.249 187.16 159.776C185.686 158.303 184.858 156.304 184.858 154.22Z" fill="#DD2222"/>
<path d="M192.677 194.014C191.131 194.014 189.619 193.556 188.334 192.697C187.048 191.838 186.046 190.617 185.454 189.188C184.863 187.76 184.708 186.188 185.01 184.671C185.311 183.155 186.056 181.762 187.149 180.669C188.242 179.575 189.635 178.831 191.152 178.529C192.668 178.227 194.24 178.382 195.669 178.974C197.097 179.566 198.318 180.568 199.177 181.853C200.036 183.139 200.495 184.65 200.495 186.197C200.495 188.27 199.671 190.259 198.205 191.725C196.739 193.191 194.751 194.014 192.677 194.014Z" fill="#DD2222"/>
<path d="M463.706 139.332L466.906 136.239C468.915 134.23 470.043 131.506 470.043 128.665C470.043 125.825 468.915 123.101 466.906 121.092C464.897 119.083 462.173 117.955 459.333 117.955C456.492 117.955 453.768 119.083 451.759 121.092L448.666 124.292L445.573 121.092C443.564 119.083 440.84 117.955 437.999 117.955C435.159 117.955 432.435 119.083 430.426 121.092C428.417 123.101 427.289 125.825 427.289 128.665C427.289 131.506 428.417 134.23 430.426 136.239L433.626 139.332L430.426 142.425C428.417 144.434 427.289 147.158 427.289 149.999C427.289 152.839 428.417 155.563 430.426 157.572C432.435 159.581 435.159 160.709 437.999 160.709C440.84 160.709 443.564 159.581 445.573 157.572L448.666 154.372L451.759 157.572C453.768 159.581 456.492 160.709 459.333 160.709C462.173 160.709 464.897 159.581 466.906 157.572C468.915 155.563 470.043 152.839 470.043 149.999C470.043 147.158 468.915 144.434 466.906 142.425L463.706 139.332Z" fill="#F0F7FC"/>
<path d="M128.665 309.999H85.9987C83.1697 309.999 80.4566 308.876 78.4562 306.875C76.4558 304.875 75.332 302.162 75.332 299.333C75.332 296.504 76.4558 293.791 78.4562 291.79C80.4566 289.79 83.1697 288.666 85.9987 288.666H128.665C131.494 288.666 134.207 289.79 136.208 291.79C138.208 293.791 139.332 296.504 139.332 299.333C139.332 302.162 138.208 304.875 136.208 306.875C134.207 308.876 131.494 309.999 128.665 309.999Z" fill="#D7E9F7"/>
<path d="M128.665 352.665H85.9987C83.1697 352.665 80.4566 351.542 78.4562 349.541C76.4558 347.541 75.332 344.828 75.332 341.999C75.332 339.17 76.4558 336.457 78.4562 334.456C80.4566 332.456 83.1697 331.332 85.9987 331.332H128.665C131.494 331.332 134.207 332.456 136.208 334.456C138.208 336.457 139.332 339.17 139.332 341.999C139.332 344.828 138.208 347.541 136.208 349.541C134.207 351.542 131.494 352.665 128.665 352.665Z" fill="#D7E9F7"/>
<defs>
<linearGradient id="paint0_linear_4097_9075" x1="203.333" y1="181.999" x2="203.333" y2="96.666" gradientUnits="userSpaceOnUse">
<stop stop-color="#D3E6F5"/>
<stop offset="1" stop-color="#F0F7FC"/>
</linearGradient>
<linearGradient id="paint1_linear_4097_9075" x1="294" y1="296.676" x2="406.001" y2="296.676" gradientUnits="userSpaceOnUse">
<stop stop-color="#305CDE"/>
<stop offset="1" stop-color="#3563EE"/>
</linearGradient>
<linearGradient id="paint2_linear_4097_9075" x1="246" y1="238.457" x2="337.582" y2="238.457" gradientUnits="userSpaceOnUse">
<stop stop-color="#305CDE"/>
<stop offset="1" stop-color="#3563EE"/>
</linearGradient>
<linearGradient id="paint3_linear_4097_9075" x1="54" y1="139.333" x2="331.333" y2="139.333" gradientUnits="userSpaceOnUse">
<stop stop-color="#305CDE"/>
<stop offset="1" stop-color="#3563EE"/>
</linearGradient>
<linearGradient id="paint4_linear_4097_9075" x1="192.667" y1="245.999" x2="192.667" y2="32.666" gradientUnits="userSpaceOnUse">
<stop stop-color="#D3E6F5"/>
<stop offset="1" stop-color="#F0F7FC"/>
</linearGradient>
</defs>
</svg>

            `

        let bodyDir = $('body').attr('dir') === 'rtl' ? 'برجاء اضافة بيانات' : 'Please add information';

        let emptyTableMessage = `
                <div class="AE_emptyTableMessage ">
                    <div class='AE_Svg'>${SvgIcon}</div>
                    <p class='AE_innerText'>
                        ${bodyDir}
                    </p>
                </div>
            `
        //
        var table = $("#table").DataTable({
            processing: true,
            pageLength: 100,
            paging: true,
            dom: 'Bfrltip',
            bLengthChange: true,
            serverSide: true,
            ajax: {
                url: '{{ isset($listRoute) ? route($listRoute, $id ?? "") : url()->current() }}',
                data: function (d) {

                    var form = document.getElementById('filter_form');

                    // تحقق إذا كان هناك عناصر في النموذج
                    if (form && form.elements.length > 0) {
                        // استخدام FormData للحصول على جميع بيانات النموذج
                        var formData = new FormData(form);

                        console.log(formData)
                        // تحويل FormData إلى كائن JavaScript ليتم إضافته إلى `d`
                        formData.forEach(function (value, key) {
                            // إذا كانت القيم تحتوي على مصفوفة (مثل select متعدد)
                            if (d[key]) {
                                // إذا كانت المفتاح موجود بالفعل في d، أضف القيمة الجديدة
                                // لجمع كل القيم لنفس المفتاح
                                d[key] = Array.isArray(d[key]) ? d[key].concat(value) : [d[key], value];
                            } else {
                                d[key] = value; // إضافة القيمة إذا لم تكن موجودة مسبقًا
                            }
                        });


                    }

                    // إضافة قيمة البحث إلى البيانات
                    d.search = document.querySelector('input[type="search"]').value;
                }
            },
            columns: columns,
            "ordering": false,
            // order: [
            //     [0, "ASEC"]
            // ],

            buttons: {
                buttons: [{
                    extend: 'collection',
                    text: ' <i class="fas fa-download"></i>  Export',
                    className: 'btn btn-primary AE_button dropdown-toggle',

                    buttons: [{
                        extend: 'copy',
                        text: 'Copy <i class="fas fa-copy"></i> '
                    },
                        {
                            extend: 'csv',
                            text: 'CSV <i class="fas fa-file-csv"></i> '
                        },
                        {
                            extend: 'excel',
                            text: 'Excel <i class="fas fa-file-excel"></i> '
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF <i class="fas fa-file-pdf"></i> '
                        },
                        {
                            extend: 'print',
                            text: ' Print <i class="fas fa-print"></i> '
                        }
                    ]
                }]
            },
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, 'All'],
            ],
            language: {
                lengthMenu: "_MENU_", // Customize this text
                search: "", // No label text for search
                searchPlaceholder: "ابحث بالاسم والهوية (مثال: محمد 12345)", // Placeholder text for search input
                emptyTable: emptyTableMessage,

            },
            searching: true,
            destroy: true,
            info: false,
            // sDom: '<"row view-filter"<"col-sm-12"<"float-left"l><"float-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',

            drawCallback: function () {
                $($(".dataTables_wrapper .pagination li:first-of-type"))
                    .find("a")
                    .addClass("prev");
                $($(".dataTables_wrapper .pagination li:last-of-type"))
                    .find("a")
                    .addClass("next");

                $(".dataTables_wrapper .pagination").addClass("pagination-sm");
            }
        });
        var tableContainer = $('<div class="AE_TableContainer"></div>').insertBefore('#table');
        var controlsContainer = $('<div class="custom-controls AE_custom_default"></div>').insertBefore(
            '#table');
        var searchContainer = $('<div class="search-container"></div>').insertBefore('#table');
        let BtnSearch = $(
            '<button type="button" class="btn btn-primary AE_button " id="searchBtn">ابحث</button>')
        //
        var table_length = $('#table_length') // length of table
        var table_filter = $('#table_filter') // search table filter
        //
        tableContainer.append(controlsContainer).append(searchContainer)
        table.buttons().container().appendTo('.custom-controls')
        controlsContainer.append(table_length)
        searchContainer.append(table_filter)
        table_filter.append(BtnSearch)

    });

    $(document).on('click', '#addBtn', function () {
        $('#form-load').html(loader)
        $('#operationType').text('اضافة');
        $('#Modal').modal('show')

        setTimeout(function () {
            // Get the current URL query parameters
            var urlParams = new URLSearchParams(window.location.search);
            var queryParams = {};

            // Convert URLSearchParams to a regular object
            for (const [key, value] of urlParams.entries()) {
                queryParams[key] = value;
            }

            // Create the base URL
            var createUrl = "{{ isset($createRoute) ? route($createRoute, $id ?? '') : route("$url.create", $id ?? '') }}";

            // Add query parameters to the URL if they exist
            if (Object.keys(queryParams).length > 0) {
                // Check if the URL already has parameters
                var separator = createUrl.includes('?') ? '&' : '?';

                // Add each parameter to the URL
                for (var key in queryParams) {
                    createUrl += separator + key + '=' + queryParams[key];
                    separator = '&';
                }
            }

            $('#form-load').load(createUrl);
        }, 1000)
    });

    $(document).on('submit', "form#form", function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        var url = $('#form').attr('action');
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            beforeSend: function () {


                $('#submit').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                    ' ></span> <span style="margin-left: 4px;">جاري التنفيذ</span>').attr(
                    'disabled', true);
                $('#form-load').append(loader)
                $('#form').hide()
            },
            complete: function () {
            },
            success: function (data) {

                window.setTimeout(function () {
                    $('#submit').html('تاكيد').attr('disabled', false);

                    // $('#product-model').modal('hide')
                    if (data.code == 200) {
                        toastr.success(data.message)
                        $('#Modal').modal('hide')
                        $('#table').DataTable().ajax.reload(null, false);
                    } else {
                        $('#form-load > .linear-background').hide(loader)
                        $('#form').show()
                        toastr.error(data.message)
                    }
                }, 1000);


            },
            error: function (data) {
                $('#form-load > .linear-background').hide(loader)
                $('#submit').html('تاكيد').attr('disabled', false);
                $('#form').show()
                if (data.status === 500) {
                    toastr.error('there is an error')
                }

                if (data.status === 422) {
                    var errors = $.parseJSON(data.responseText);

                    // Check if errors.errors exists (Laravel validation format)
                    if (errors.errors) {
                        $.each(errors.errors, function (key, value) {
                            // value is typically an array of messages for each field
                            if (Array.isArray(value)) {
                                value.forEach(function(message) {
                                    toastr.error( message);
                                });
                            } else {
                                toastr.error( value);
                            }
                        });
                    } else {
                        // Fallback for other error formats
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (innerKey, message) {
                                    toastr.error(innerKey + ': ' + message);
                                });
                            } else {
                                toastr.error(key + ': ' + value);
                            }
                        });
                    }
                }
                if (data.status == 421) {
                    try {
                        var response = $.parseJSON(data.responseText);
                        toastr.error(response.message || 'An error occurred');
                    } catch (e) {
                        toastr.error('An error occurred');
                    }
                }

            }, //end error method

            cache: false,
            contentType: false,
            processData: false
        });
    });
    $(document).on('click', '.delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: "هل انت متاكد من الحذف؟",
            text: "لا تستطيع الرجوع فى ذلك",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "حذف",
            cancelButtonText: "الغاء",
            closeOnConfirm: false
        }).then((result) => {
            if (!result.isConfirmed) {
                return true;
            }

            // Use dynamic destroy route name when provided; otherwise fallback only if it exists
            var url = '{{ isset($destroyRoute)
                ? route($destroyRoute, isset($id) ? [$id, ":id"] : [":id"])
                : (\Illuminate\Support\Facades\Route::has("$url.destroy")
                    ? route("$url.destroy", isset($id) ? [$id, ":id"] : [":id"])
                    : "") }}';
            url = url.replace(':id', id);

            if (!url) {
                toastr.error('لا يوجد مسار حذف مُعرّف لهذا العنصر');
                return;
            }

            $.ajax({
                url: url,
                type: 'POST', // Use POST method
                data: {
                    _method: 'DELETE', // Laravel will treat this as DELETE
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function () {
                    $('.loader-ajax').show()
                },
                success: function (data) {
                    window.setTimeout(function () {
                        $('.loader-ajax').hide()
                        if (data.code == 200) {
                            toastr.success(data.message)
                            $('#table').DataTable().ajax.reload(null, false);
                        } else {
                            toastr.error('there is an error')
                        }
                    }, 1000);
                },
                error: function (xhr) {
                    $('.loader-ajax').hide();
                    if (xhr.status === 500) {
                        toastr.error('There is an error');
                    } else if (xhr.status === 422) {
                        var errors = xhr.responseJSON;
                        $.each(errors.errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    }
                }
            });
        });
    });
    $(document).on('click', '.editBtn', function () {
        var id = $(this).data('id');
        $('#operationType').text('تعديل ');
        $('#form-load').html(loader)
        $('#Modal').modal('show')

        var url = '{{ isset($editRoute)
            ? route($editRoute, isset($id) ? [$id, ":id"] : [":id"])
            : (\Illuminate\Support\Facades\Route::has("$url.edit")
                ? route("$url.edit", isset($id) ? [$id, ":id"] : [":id"])
                : "") }}';
        url = url.replace(':id', id)

        if (!url) {
            toastr.error('لا يوجد مسار تعديل مُعرّف لهذا العنصر');
            return;
        }

        setTimeout(function () {
            $('#form-load').load(url)
        }, 1000)


    });



    $(document).on('change', '.changeFilter', function () {
        $('#table').DataTable().ajax.reload(null, false);

    })
</script>
