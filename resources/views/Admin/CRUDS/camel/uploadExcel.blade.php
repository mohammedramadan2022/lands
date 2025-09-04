@extends('Admin.layouts.inc.app')
@section('title')
   تحميل ملف
@endsection
@section('css')

    <style>
        .select2-container {
            z-index: 10000; /* Adjust the value as needed */
        }

        .form-check-inline {
            display: inline-block;
            margin-right: 10px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
        }

        .form-check-label {
            margin-left: 5px;
            font-size: 1.2em;
        }
    </style>

@endsection

@section('content')

    <!--begin::Tables Widget 11-->
    <div class="card mb-5 mb-xl-8">
        <!--begin::Header-->
        <div class="card-header border-0 pt-5">
            <h3 class="card-title align-items-start flex-column">
                <span class="card-label fw-bolder fs-3 mb-1">   تحميل ملف
</span>
            </h3>
            <div class="card-toolbar">

            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body py-3 text-start">
            <form id="form" action="{{ route('admin.upload-excel-camels') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Add the input text field for barcode here -->
                <div class="mb-3">
                    <label for="barcode" class="form-label">نوع الملف</label>
                   <select class="form-control" name="final_vote" required>
                       <option value="">اختر نوع الملف</option>
                       <option value="1">عمانيات</option>
                       <option value="2">مهجنات</option>
                   </select>
                </div>

                <div class="mb-3">
                    <label for="file" class="form-label">Excel File</label>
                    <input type="file" class="form-control" id="file" name="sheet">
                </div>

                <button type="submit" class="btn btn-primary">حفظ</button>
            </form>
        </div>

        <br>
        <br>
        <br>
        <br>


        <!--begin::Body-->


        @endsection
        @section('js')
            <script>
                document.querySelectorAll('.member-image').forEach(function (image) {
                    image.addEventListener('click', function () {
                        var name = this.getAttribute('data-name');
                        var imageUrl = this.getAttribute('data-image');
                        var memberId = this.getAttribute('data-id'); // Assuming you have a data-id attribute for member ID
                        document.getElementById('memberName').innerText = name;
                        document.getElementById('memberImage').src = imageUrl;
                        document.getElementById('memberId').value = memberId; // Set the hidden input value
                        var voteModal = new bootstrap.Modal(document.getElementById('voteModal'));
                        voteModal.show();
                    });
                });

                document.querySelector('#voteModal button[type="submit"]').addEventListener('click', function (event) {
                    event.preventDefault();
                    var memberId = document.getElementById('memberId').value;
                    var vote = document.querySelector('input[name="vote"]:checked').value;
                    var barcode = document.getElementById('barcode').value;

                    if (!memberId || !vote || !barcode) {
                        alert('All fields are required.');
                        return;
                    }

                    var data = {
                        member_id: memberId,
                        vote: vote,
                        barcode: barcode,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    };

                    fetch('{{ route('admin.store-vote') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('تم التصويت بنجاح.');
                                var voteModal = bootstrap.Modal.getInstance(document.getElementById('voteModal'));
                                voteModal.hide();
                            } else {
                                alert('Failed to submit vote.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred.');
                        });
                });


            </script>
            <link href="{{ url('assets/dashboard/css/select2.css') }}" rel="stylesheet"/>
            <script src="{{ url('assets/dashboard/js/select2.js') }}"></script>
@endsection
