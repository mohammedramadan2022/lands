<!--begin::Aside-->
<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside"
     data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
     data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start"
     data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Brand-->
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        <!--begin::Logo-->
        <a href="">
            <img alt="Logo" src="{{get_file(setting()->logo_header)}}" width="" height="45px" class=" logo"/>
        </a>
        <!--end::Logo-->
        <!--begin::Aside toggler-->
        <div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-primary aside-toggle"
             data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
             data-kt-toggle-name="aside-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-1 rotate-180">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.5"
                              d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                              fill="black"/>
                        <path
                            d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                            fill="black"/>
                    </svg>
                </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Aside toggler-->
    </div>
    <!--end::Brand-->
    <!--begin::Aside menu-->
    <div class="aside-menu flex-column-fluid">
        <!--begin::Aside Menu-->
        <div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
             data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
             data-kt-scroll-offset="0">
            <!--begin::Menu-->
            <div
                class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
                id="#kt_aside_menu" data-kt-menu="true">

                <div class="menu-item">
                    <a class="menu-link menu-link-active" href="{{route('admin.index')}}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px" fill="#fff"><path
                                        d="M820-310.38 526.69-539.54q-24.31-19.07-54.54-14.96-30.23 4.12-48.3 29.42l-93.31 128.39q-9.23 12.85-24.19 14.96-14.96 2.12-27.43-7.73L140-498.84v-68.85q0-22.69 19.89-32.54 19.88-9.84 37.96 3.62l86.77 65.07 154.84-217.15q18.08-25.31 49-29.73 30.92-4.42 55.23 15.27L673.08-660h74.61q29.92 0 51.12 21.19Q820-617.61 820-587.69v277.31ZM140-180v-244.23L261.15-327q24.31 19.69 54.73 15.27 30.43-4.42 48.5-29.73l93.93-128.62q9.23-12.84 24-14.96 14.77-2.11 27.23 7.73L820-234.77V-180H140Z"/></svg>

                                </span>
                                <!--end::Svg Icon-->
                            </span>
                        <span class="menu-title">الرئيسية</span>
                    </a>
                </div>


                <div data-kt-menu-trigger="click"
                     class="menu-item menu-accordion {{ request()->routeIs('settings.index') ? 'hover show' : '' }} ">
                    <!--begin:Menu link-->
                    <span
                        class="menu-link py-2">
                        <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px" fill="#fff"><path
                                        d="M714.23-206.54q34.15 0 58.62-24.46 24.46-24.46 24.46-58.62 0-34.15-24.46-58.61-24.47-24.46-58.62-24.46t-58.62 24.46q-24.46 24.46-24.46 58.61 0 34.16 24.46 58.62 24.47 24.46 58.62 24.46Zm-5.31 94.61q-10.54 0-18.73-7.07-8.19-7.08-10.04-17.62l-4.07-23q-17.39-5-30-11.84-12.62-6.85-24.77-18.31l-24 8.23q-9.92 3.23-19.16-.23-9.23-3.46-14.69-11.77l-5.69-9.77q-5.46-9.31-4.23-19.65 1.23-10.35 9.92-17.43l18.16-15.53q-4.31-16.62-4.31-33.7 0-17.07 4.31-33.69l-18.16-15.54q-8.3-6.69-9.92-16.73-1.62-10.04 3.85-19.34l6.69-10.77q5.46-8.31 14.38-11.77 8.93-3.46 18.85-.23l24 8.23q12.15-11.85 24.77-18.5 12.61-6.66 30-11.66l4.07-23.61q1.85-10.54 10.04-17.31t18.73-6.77h10.62q10.54 0 18.73 7.08 8.19 7.08 10.04 17.62l4.07 22.99q17.39 5 30 11.66 12.62 6.65 24.77 18.5l24-8.23q9.93-3.23 19.16.23T865-385.69l5.69 9.77q5.46 9.3 4.23 19.65-1.23 10.35-9.92 17.42l-18.16 15.54q4.31 16.62 4.31 33.69 0 17.08-4.31 33.7L865-240.39q8.31 6.7 9.92 16.74 1.62 10.03-3.85 19.34l-6.69 10.77q-5.46 8.31-14.38 11.77-8.92 3.46-18.85.23l-24-8.23q-12.15 11.46-24.77 18.31-12.61 6.84-30 11.84L748.31-136q-1.85 10.54-10.04 17.31-8.19 6.76-18.73 6.76h-10.62ZM172.31-180Q142-180 121-201q-21-21-21-51.31v-455.38Q100-738 121-759q21-21 51.31-21H362q14.46 0 27.81 5.62 13.34 5.61 23.19 15.46L471.92-700h315.77Q818-700 839-679q21 21 21 51.31v62.54q0 16.46-13.77 24.69T817-539.08q-24.08-10.46-50.77-15.69-26.69-5.23-53.38-5.23-114.93 0-192.16 80.19-77.23 80.19-77.23 189.58 0 17.46 2.12 34.42 2.11 16.96 6.73 33.42 4.23 16.47-4.81 29.43T423-180H172.31Z"/></svg>
                            </span>                                </span>
                        <!--end::Svg Icon-->

                        <span class="menu-title"> إعدادات المنصة</span>
                        <span
                            class="menu-arrow"></span></span>
                    <!--end:Menu link--><!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link menu-link-active" href="{{route('settings.index')}}"><span
                                    class="menu-bullet"><span class="bullet bullet-dot"></span></span><span
                                    class="menu-title"> الإعدادات العامة </span></a>


                            <!--end:Menu link-->
                        </div>

                    </div>

                </div>


                <div class="menu-item">
                    <a class="menu-link menu-link-active" href="{{route('admins.index')}}">
                            <span class="menu-icon">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                     width="24px" fill="#fff"><path
                                        d="M677.69-387.69q-37.38 0-63.69-26.31-26.31-26.31-26.31-63.69 0-37.39 26.31-63.7 26.31-26.3 63.69-26.3 37.39 0 63.69 26.3 26.31 26.31 26.31 63.7 0 37.38-26.31 63.69-26.3 26.31-63.69 26.31Zm-153.84 200q-15.37 0-25.76-10.4-10.4-10.39-10.4-25.76v-9.84q0-21.31 10.9-39.13 10.9-17.82 30.95-25.64 35.23-14.62 72.58-21.93 37.34-7.3 75.57-7.3 38.23 0 75.58 7.3 37.34 7.31 72.58 21.93 20.05 7.82 30.94 25.64 10.9 17.82 10.9 39.13v9.84q0 15.37-10.39 25.76-10.4 10.4-25.76 10.4H523.85ZM392.31-492.31q-57.75 0-98.88-41.12-41.12-41.13-41.12-98.88 0-57.75 41.12-98.87 41.13-41.13 98.88-41.13 57.75 0 98.87 41.13 41.13 41.12 41.13 98.87 0 57.75-41.13 98.88-41.12 41.12-98.87 41.12Zm-300 215.65q0-29.96 15.65-55.07 15.66-25.12 42.96-37.81 56.54-28.46 117.37-43.31 60.83-14.84 124.02-14.84 28.46 0 56.92 4.15 28.46 4.16 56.92 9.69L453.92-362q-23.46 24.61-42.54 52.35-19.07 27.73-19.07 61.57v24q0 10.65 3.68 19.97 3.68 9.32 11.86 16.42H153.08q-25.31 0-43.04-17.73-17.73-17.74-17.73-43.04v-28.2Z"/></svg>
                            </span>
                            </span>
                        <!--end::Svg Icon-->
                        <span class="menu-title">المشرفين</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link menu-link-active" href="{{ route('admin.land-requests.index') }}">
                        <span class="menu-icon">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                    <path d="M160-160v-80h640v80H160Zm0-240v-80h640v80H160Zm0-240v-80h640v80H160Z"/>
                                </svg>
                            </span>
                        </span>
                        <span class="menu-title">طلبات الأراضي/العزب</span>
                    </a>
                </div>
                <div  class = "menu-item">
                    <a class = "menu-link menu-link-active" href = "{{route('admin.land-requests.upload-excel')}}">
                        <span class = "menu-icon">
                            <span class = "svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff">
                                    <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h200v80H200v560h560v-200h80v200q0 33-23.5 56.5T760-120H200Zm200-240-56-56 160-160-160-160 56-56 216 216-216 216Z"/>
                                </svg>
                            </span>
                        </span>
                        <span class = "menu-title">رفع طلبات الأراضي/العزب</span>
                    </a>
                </div>


                {{--

                                <div class="menu-item">
                                    <a class="menu-link menu-link-active" href="{{route('contacts.index')}}">
                                            <span class="menu-icon">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#fff"><path d="m517.15-874.46 314.08 187.38q13.38 8.7 21.08 22.89Q860-650 860-634v421.69Q860-182 839-161q-21 21-51.31 21H172.31Q142-140 121-161q-21-21-21-51.31V-634q0-16 7.69-30.19 7.7-14.19 21.08-22.89l314.08-187.38q17.07-9.85 37.15-9.85t37.15 9.85Zm-31 416.61L792-640 486.15-822.15q-3.07-1.93-6.15-1.93-3.08 0-6.15 1.93L168-640l305.85 182.15q3.07 1.93 6.15 1.93 3.08 0 6.15-1.93Z"/></svg>
                                                             </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        <span class="menu-title"> الرسائل</span>
                                    </a>
                                </div>
                --}}


            </div>
            <!--end::Menu-->
        </div>
        <!--end::Aside Menu-->
    </div>
    <!--end::Aside menu-->

</div>
<!--end::Aside-->


