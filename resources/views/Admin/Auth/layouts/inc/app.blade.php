<!DOCTYPE html>

<html lang="en">
	<head><base href="">
        @include('Admin.Auth.layouts.assets.css')

	</head>
	<body dir="rtl" id="kt_body" class="bg-dark" style="background-image: url({{asset('assets/dashboard')}}/media/yaraabg.webp);    background-size: cover;
    background-position: center;">
		<div class="d-flex flex-column flex-root">
			<div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed" style="background-image: url(assets/media/illustrations/sketchy-1/14-dark.png">
                <div class="Loginage">
                     @yield('content')
                </div>
				<div class="d-flex flex-center flex-column-auto p-0">
					<!--begin::Links-->
				{{-- 	<div class="d-flex align-items-center fw-bold fs-6">
						<a href="https://keenthemes.com" class="text-muted text-hover-primary px-2">يراع</a>
					</div>
                    --}}
					<!--end::Links-->
				</div>
				<!--end::Footer-->
			</div>
			<!--end::Authentication - Sign-in-->
		</div>
		<!--end::Main-->
        @include('Admin.Auth.layouts.assets.js')

	</body>
	<!--end::Body-->
</html>
