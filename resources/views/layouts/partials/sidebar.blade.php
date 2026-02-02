<div id="kt_aside" class="aside aside-extended" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="auto"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <div class="aside-primary d-flex flex-column align-items-lg-center flex-row-auto">
        <div class="aside-logo d-none d-lg-flex flex-column align-items-center flex-column-auto py-10"
            id="kt_aside_logo">
            <a ng-href="#!/" target="_self">
                <img alt="Logo" src="{{ asset('assets/media/logos/logo.svg') }}" class="h-30px" />
            </a>
        </div>
        <div class="aside-nav d-flex flex-column align-items-center flex-column-fluid w-100 pt-5 pt-lg-0"
            id="kt_aside_nav">
            <div class="hover-scroll-overlay-y mb-5 px-5" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
                data-kt-scroll-wrappers="#kt_aside_nav" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
                data-kt-scroll-offset="0px">
                <ul class="nav flex-column w-100" id="kt_aside_nav_tabs">
                    @foreach ($modules as $key => $module)
                        @if (\App\Models\Outil::hasOnePermissionOf($module->permissions()))
                            <li class="nav-item mb-2" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                data-bs-placement="right" data-bs-dismiss="click"
                                title="{{ app()->getLocale() == 'en' ? $module->title_en : $module->title }}">
                                <a class="btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light"
                                    @if (count($module->all_pages()) == 1) ng-href="{{ $module->all_pages()[0]->link }}" @else data-bs-toggle="tab" href="#kt_aside_nav_tab_{{ $module->id }}" @endif
                                    target="_self">
                                    <span class="svg-icon svg-icon-2x">
                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/' . $module->icon . '.svg')) !!}
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            
        </div>
        <div class="aside-footer d-flex flex-column align-items-center flex-column-auto" id="kt_aside_footer">
            <div class="d-flex align-items-center mb-2 d-none">
                <div class="btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light"
                    data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Quick links">
                    <span class="svg-icon svg-icon-2 svg-icon-lg-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
                                fill="currentColor" />
                            <path
                                d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
                                fill="currentColor" />
                            <path opacity="0.3"
                                d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
                                fill="currentColor" />
                            <path opacity="0.3"
                                d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
                                fill="currentColor" />
                        </svg>
                    </span>
                </div>
                <div class="menu menu-sub menu-sub-dropdown menu-column w-250px w-lg-325px" data-kt-menu="true">
                    <div class="d-flex flex-column flex-center bgi-no-repeat rounded-top px-9 py-10"
                        style="background-image:url({{ asset('assets/media/misc/dropdown-header-bg.png') }})">
                        <h3 class="text-white fw-semibold mb-3">Quick Links</h3>
                        <span class="badge bg-primary py-2 px-3">25 pending tasks</span>
                    </div>
                    <div class="row g-0">
                        <div class="col-6">
                            <a href=""
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end border-bottom">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin009.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M15.8 11.4H6C5.4 11.4 5 11 5 10.4C5 9.80002 5.4 9.40002 6 9.40002H15.8C16.4 9.40002 16.8 9.80002 16.8 10.4C16.8 11 16.3 11.4 15.8 11.4ZM15.7 13.7999C15.7 13.1999 15.3 12.7999 14.7 12.7999H6C5.4 12.7999 5 13.1999 5 13.7999C5 14.3999 5.4 14.7999 6 14.7999H14.8C15.3 14.7999 15.7 14.2999 15.7 13.7999Z"
                                            fill="currentColor" />
                                        <path
                                            d="M18.8 15.5C18.9 15.7 19 15.9 19.1 16.1C19.2 16.7 18.7 17.2 18.4 17.6C17.9 18.1 17.3 18.4999 16.6 18.7999C15.9 19.0999 15 19.2999 14.1 19.2999C13.4 19.2999 12.7 19.2 12.1 19.1C11.5 19 11 18.7 10.5 18.5C10 18.2 9.60001 17.7999 9.20001 17.2999C8.80001 16.8999 8.49999 16.3999 8.29999 15.7999C8.09999 15.1999 7.80001 14.7 7.70001 14.1C7.60001 13.5 7.5 12.8 7.5 12.2C7.5 11.1 7.7 10.1 8 9.19995C8.3 8.29995 8.79999 7.60002 9.39999 6.90002C9.99999 6.30002 10.7 5.8 11.5 5.5C12.3 5.2 13.2 5 14.1 5C15.2 5 16.2 5.19995 17.1 5.69995C17.8 6.09995 18.7 6.6 18.8 7.5C18.8 7.9 18.6 8.29998 18.3 8.59998C18.2 8.69998 18.1 8.69993 18 8.79993C17.7 8.89993 17.4 8.79995 17.2 8.69995C16.7 8.49995 16.5 7.99995 16 7.69995C15.5 7.39995 14.9 7.19995 14.2 7.19995C13.1 7.19995 12.1 7.6 11.5 8.5C10.9 9.4 10.5 10.6 10.5 12.2C10.5 13.3 10.7 14.2 11 14.9C11.3 15.6 11.7 16.1 12.3 16.5C12.9 16.9 13.5 17 14.2 17C15 17 15.7 16.8 16.2 16.4C16.8 16 17.2 15.2 17.9 15.1C18 15 18.5 15.2 18.8 15.5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="fs-5 fw-semibold text-gray-800 mb-0">Accounting</span>
                                <span class="fs-7 text-gray-400">eCommerce</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href=""
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-bottom">
                                <!--begin::Svg Icon | path: icons/duotune/communication/com010.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6 8.725C6 8.125 6.4 7.725 7 7.725H14L18 11.725V12.925L22 9.725L12.6 2.225C12.2 1.925 11.7 1.925 11.4 2.225L2 9.725L6 12.925V8.725Z"
                                            fill="currentColor" />
                                        <path opacity="0.3"
                                            d="M22 9.72498V20.725C22 21.325 21.6 21.725 21 21.725H3C2.4 21.725 2 21.325 2 20.725V9.72498L11.4 17.225C11.8 17.525 12.3 17.525 12.6 17.225L22 9.72498ZM15 11.725H18L14 7.72498V10.725C14 11.325 14.4 11.725 15 11.725Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="fs-5 fw-semibold text-gray-800 mb-0">Administration</span>
                                <span class="fs-7 text-gray-400">Console</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href=""
                                class="d-flex flex-column flex-center h-100 p-6 bg-hover-light border-end">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs042.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M18 21.6C16.6 20.4 9.1 20.3 6.3 21.2C5.7 21.4 5.1 21.2 4.7 20.8L2 18C4.2 15.8 10.8 15.1 15.8 15.8C16.2 18.3 17 20.5 18 21.6ZM18.8 2.8C18.4 2.4 17.8 2.20001 17.2 2.40001C14.4 3.30001 6.9 3.2 5.5 2C6.8 3.3 7.4 5.5 7.7 7.7C9 7.9 10.3 8 11.7 8C15.8 8 19.8 7.2 21.5 5.5L18.8 2.8Z"
                                            fill="currentColor" />
                                        <path opacity="0.3"
                                            d="M21.2 17.3C21.4 17.9 21.2 18.5 20.8 18.9L18 21.6C15.8 19.4 15.1 12.8 15.8 7.8C18.3 7.4 20.4 6.70001 21.5 5.60001C20.4 7.00001 20.2 14.5 21.2 17.3ZM8 11.7C8 9 7.7 4.2 5.5 2L2.8 4.8C2.4 5.2 2.2 5.80001 2.4 6.40001C2.7 7.40001 3.00001 9.2 3.10001 11.7C3.10001 15.5 2.40001 17.6 2.10001 18C3.20001 16.9 5.3 16.2 7.8 15.8C8 14.2 8 12.7 8 11.7Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="fs-5 fw-semibold text-gray-800 mb-0">Projects</span>
                                <span class="fs-7 text-gray-400">Pending Tasks</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="" class="d-flex flex-column flex-center h-100 p-6 bg-hover-light">
                                <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                <span class="svg-icon svg-icon-3x svg-icon-primary mb-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                            d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                            fill="currentColor" />
                                        <path
                                            d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <span class="fs-5 fw-semibold text-gray-800 mb-0">Customers</span>
                                <span class="fs-7 text-gray-400">Latest cases</span>
                            </a>
                        </div>
                    </div>
                    <div class="py-2 text-center border-top">
                        <a href="" class="btn btn-color-gray-600 btn-active-color-primary">View All
                            <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                            <span class="svg-icon svg-icon-5">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1"
                                        transform="rotate(-180 18 13)" fill="currentColor" />
                                    <path
                                        d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon--></a>
                    </div>
                    <!--end::View more-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Quick links-->
            <!--begin::Activities-->
            <div class="d-flex align-items-center mb-3 d-none">
                <!--begin::Drawer toggle-->
                <div class="btn btn-icon btn-active-color-danger btn-color-gray-400 btn-active-light"
                    data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click" title="Activity Logs"
                    id="kt_activities_toggle">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                    <span class="svg-icon svg-icon-2 svg-icon-lg-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="8" y="9" width="3" height="10" rx="1.5" fill="currentColor" />
                            <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5"
                                fill="currentColor" />
                            <rect x="18" y="11" width="3" height="8" rx="1.5" fill="currentColor" />
                            <rect x="3" y="13" width="3" height="6" rx="1.5" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::drawer toggle-->
            </div>
            <!--end::Activities-->
            <!--begin::Notifications-->
            <div class="d-flex align-items-center mb-2 d-none">
                <!--begin::Menu wrapper-->
                <div class="btn btn-icon btn-active-color-primary btn-color-gray-400 btn-active-light"
                    data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click"
                    title="Notifications">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                    <span class="svg-icon svg-icon-2 svg-icon-lg-1">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="2" width="9" height="9" rx="2" fill="currentColor" />
                            <rect opacity="0.3" x="13" y="2" width="9" height="9" rx="2"
                                fill="currentColor" />
                            <rect opacity="0.3" x="13" y="13" width="9" height="9" rx="2"
                                fill="currentColor" />
                            <rect opacity="0.3" x="2" y="13" width="9" height="9" rx="2"
                                fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-375px" data-kt-menu="true">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column bgi-no-repeat rounded-top"
                        style="background-image:url('assets/media/misc/dropdown-header-bg.png')">
                        <!--begin::Title-->
                        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                            <span class="fs-8 opacity-75 ps-3">24 reports</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Tabs-->
                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                                    href="#kt_topbar_notifications_1">Alerts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                                    data-bs-toggle="tab" href="#kt_topbar_notifications_2">Updates</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4" data-bs-toggle="tab"
                                    href="#kt_topbar_notifications_3">Logs</a>
                            </li>
                        </ul>
                        <!--end::Tabs-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade" id="kt_topbar_notifications_1" role="tabpanel">
                            <!--begin::Items-->
                            <div class="scroll-y mh-325px my-5 px-8">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-primary">
                                                <!--begin::Svg Icon | path: icons/duotune/technology/teh008.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M11 6.5C11 9 9 11 6.5 11C4 11 2 9 2 6.5C2 4 4 2 6.5 2C9 2 11 4 11 6.5ZM17.5 2C15 2 13 4 13 6.5C13 9 15 11 17.5 11C20 11 22 9 22 6.5C22 4 20 2 17.5 2ZM6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13ZM17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M17.5 16C17.5 16 17.4 16 17.5 16L16.7 15.3C16.1 14.7 15.7 13.9 15.6 13.1C15.5 12.4 15.5 11.6 15.6 10.8C15.7 9.99999 16.1 9.19998 16.7 8.59998L17.4 7.90002H17.5C18.3 7.90002 19 7.20002 19 6.40002C19 5.60002 18.3 4.90002 17.5 4.90002C16.7 4.90002 16 5.60002 16 6.40002V6.5L15.3 7.20001C14.7 7.80001 13.9 8.19999 13.1 8.29999C12.4 8.39999 11.6 8.39999 10.8 8.29999C9.99999 8.19999 9.20001 7.80001 8.60001 7.20001L7.89999 6.5V6.40002C7.89999 5.60002 7.19999 4.90002 6.39999 4.90002C5.59999 4.90002 4.89999 5.60002 4.89999 6.40002C4.89999 7.20002 5.59999 7.90002 6.39999 7.90002H6.5L7.20001 8.59998C7.80001 9.19998 8.19999 9.99999 8.29999 10.8C8.39999 11.5 8.39999 12.3 8.29999 13.1C8.19999 13.9 7.80001 14.7 7.20001 15.3L6.5 16H6.39999C5.59999 16 4.89999 16.7 4.89999 17.5C4.89999 18.3 5.59999 19 6.39999 19C7.19999 19 7.89999 18.3 7.89999 17.5V17.4L8.60001 16.7C9.20001 16.1 9.99999 15.7 10.8 15.6C11.5 15.5 12.3 15.5 13.1 15.6C13.9 15.7 14.7 16.1 15.3 16.7L16 17.4V17.5C16 18.3 16.7 19 17.5 19C18.3 19 19 18.3 19 17.5C19 16.7 18.3 16 17.5 16Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Alice</a>
                                            <div class="text-gray-400 fs-7">Phase 1 development</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">1 hr</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-danger">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen044.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-danger">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.3" x="2" y="2" width="20"
                                                            height="20" rx="10" fill="currentColor" />
                                                        <rect x="11" y="14" width="7" height="2"
                                                            rx="1" transform="rotate(-90 11 14)"
                                                            fill="currentColor" />
                                                        <rect x="11" y="17" width="2" height="2"
                                                            rx="1" transform="rotate(-90 11 17)"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">HR
                                                Confidential</a>
                                            <div class="text-gray-400 fs-7">Confidential staff documents</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">2 hrs</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-warning">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Company HR</a>
                                            <div class="text-gray-400 fs-7">Corporeate staff profiles</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">5 hrs</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-success">
                                                <!--begin::Svg Icon | path: icons/duotune/files/fil023.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-success">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M5 15C3.3 15 2 13.7 2 12C2 10.3 3.3 9 5 9H5.10001C5.00001 8.7 5 8.3 5 8C5 5.2 7.2 3 10 3C11.9 3 13.5 4 14.3 5.5C14.8 5.2 15.4 5 16 5C17.7 5 19 6.3 19 8C19 8.4 18.9 8.7 18.8 9C18.9 9 18.9 9 19 9C20.7 9 22 10.3 22 12C22 13.7 20.7 15 19 15H5ZM5 12.6H13L9.7 9.29999C9.3 8.89999 8.7 8.89999 8.3 9.29999L5 12.6Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M17 17.4V12C17 11.4 16.6 11 16 11C15.4 11 15 11.4 15 12V17.4H17Z"
                                                            fill="currentColor" />
                                                        <path opacity="0.3"
                                                            d="M12 17.4H20L16.7 20.7C16.3 21.1 15.7 21.1 15.3 20.7L12 17.4Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M8 12.6V18C8 18.6 8.4 19 9 19C9.6 19 10 18.6 10 18V12.6H8Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Project Redux</a>
                                            <div class="text-gray-400 fs-7">New frontend admin theme</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">2 days</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-primary">
                                                <!--begin::Svg Icon | path: icons/duotune/maps/map001.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-primary">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M6 22H4V3C4 2.4 4.4 2 5 2C5.6 2 6 2.4 6 3V22Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M18 14H4V4H18C18.8 4 19.2 4.9 18.7 5.5L16 9L18.8 12.5C19.3 13.1 18.8 14 18 14Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Project
                                                Breafing</a>
                                            <div class="text-gray-400 fs-7">Product launch status update</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">21 Jan</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-info">
                                                <!--begin::Svg Icon | path: icons/duotune/general/gen006.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-info">
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Banner Assets</a>
                                            <div class="text-gray-400 fs-7">Collection of banner images</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">21 Jan</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-4">
                                            <span class="symbol-label bg-light-warning">
                                                <!--begin::Svg Icon | path: icons/duotune/art/art002.svg-->
                                                <span class="svg-icon svg-icon-2 svg-icon-warning">
                                                    <svg width="24" height="25" viewBox="0 0 24 25"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Title-->
                                        <div class="mb-0 me-2">
                                            <a href="#"
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Icon Assets</a>
                                            <div class="text-gray-400 fs-7">Collection of SVG icons</div>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">20 March</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Items-->
                            <!--begin::View more-->
                            <div class="py-3 text-center border-top">
                                <a href="" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-5">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></a>
                            </div>
                            <!--end::View more-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column px-9">
                                <!--begin::Section-->
                                <div class="pt-10 pb-0">
                                    <!--begin::Title-->
                                    <h3 class="text-dark text-center fw-bold">Get Pro Access</h3>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="text-center text-gray-600 fw-semibold pt-1">Outlines keep you honest.
                                        They stoping you from amazing poorly about drive</div>
                                    <!--end::Text-->
                                    <!--begin::Action-->
                                    <div class="text-center mt-5 mb-9">
                                        <a href="#" class="btn btn-sm btn-primary px-6" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_upgrade_plan">Upgrade</a>
                                    </div>
                                    <!--end::Action-->
                                </div>
                                <!--end::Section-->
                                <!--begin::Illustration-->
                                <div class="text-center px-4">
                                    <img class="mw-100 mh-200px" alt="image"
                                        src="assets/media/illustrations/sigma-1/1.png" />
                                </div>
                                <!--end::Illustration-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Tab panel-->
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade" id="kt_topbar_notifications_3" role="tabpanel">
                            <!--begin::Items-->
                            <div class="scroll-y mh-325px my-5 px-8">
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">New
                                            order</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Just now</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">New
                                            customer</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">2 hrs</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">Payment
                                            process</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">5 hrs</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">Search
                                            query</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">2 days</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">API
                                            connection</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">1 week</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-success me-4">200 OK</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary fw-semibold">Database restore</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Mar 5</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">System
                                            update</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">May 15</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">Server
                                            OS update</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Apr 3</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-warning me-4">300 WRN</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">API
                                            rollback</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Jun 30</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">Refund
                                            process</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Jul 10</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#"
                                            class="text-gray-800 text-hover-primary fw-semibold">Withdrawal process</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Sep 10</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="d-flex flex-stack py-4">
                                    <!--begin::Section-->
                                    <div class="d-flex align-items-center me-2">
                                        <!--begin::Code-->
                                        <span class="w-70px badge badge-light-danger me-4">500 ERR</span>
                                        <!--end::Code-->
                                        <!--begin::Title-->
                                        <a href="#" class="text-gray-800 text-hover-primary fw-semibold">Mail
                                            tasks</a>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Section-->
                                    <!--begin::Label-->
                                    <span class="badge badge-light fs-8">Dec 10</span>
                                    <!--end::Label-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Items-->
                            <!--begin::View more-->
                            <div class="py-3 text-center border-top">
                                <a href="" class="btn btn-color-gray-600 btn-active-color-primary">View All
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                    <span class="svg-icon svg-icon-5">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="18" y="13" width="13" height="2"
                                                rx="1" transform="rotate(-180 18 13)" fill="currentColor" />
                                            <path
                                                d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon--></a>
                            </div>
                            <!--end::View more-->
                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Notifications-->
            <!--begin::User-->
            <div class="d-flex align-items-center mb-10" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-40px border border-primary border-dashed"
                    data-kt-menu-trigger="click" data-kt-menu-overflow="true" data-kt-menu-placement="top-start"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-dismiss="click"
                    title="{{ Auth::user()->name }}">
                    <img src="{{ Auth::user()->image == null ? asset('assets/media/upload.jpg') : Auth::user()->image }}"
                        alt="{{ Auth::user()->name }}" />
                    <div
                        class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-primary rounded-circle border border-4 border-body h-20px w-20px">
                    </div>
                </div>
                <!--begin::User account menu-->
                <div class="d-none menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5 border border-primary border-dashed"
                                data-kt-menu-trigger="click" data-kt-menu-overflow="true"
                                data-kt-menu-placement="top-start" data-bs-toggle="tooltip" data-bs-placement="right"
                                data-bs-dismiss="click" title="Notifications" id="kt_quick_monprofil_toggle">
                                <img alt="{{ Auth::user()->name }}"
                                    src="{{ Auth::user()->image == null ? asset('assets/media/upload.jpg') : Auth::user()->image }}" />
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-primary rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">
                                    {{ Auth::user()->name }}
                                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2 text-uppercase">
                                        {{ Auth::user()->roles()->first()->name }}
                                    </span>
                                </div>
                                <div>
                                    <span style="width: 100px" class="fw-semibold text-muted text-hover-primary fs-7">
                                        {{ Auth::user()->email }}
                                    </span>
                                </div>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="" class="menu-link px-5"
                            ng-click="showModalUpdate('user',{{ Auth::user()->id }}, {forceChangeForm: true}, 'null')">{{ __('customlang.mon_profil') }}</a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="" class="menu-link px-5" id="kt_quick_panelnotifications_toggle"
                            data-container="body" data-boundary="window">
                            <span class="menu-text">{{ __('customlang.notifications') }}</span>
                            <span class="menu-badge">
                                <span
                                    class="badge badge-light-danger badge-circle fw-bold fs-7">@{{ dataPage['notifpermusers'].length }}</span>
                            </span>
                        </a>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                        data-kt-menu-placement="right-end">
                        <a href="#" class="menu-link px-5">
                            <span class="menu-title position-relative">{{ __('customlang.langue') }}
                                <span
                                    class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">{{ app()->getLocale() == 'en' ? 'Anglais' : 'Français' }}
                                    <img class="w-15px h-15px rounded-1 ms-2"
                                        src="{{ app()->getLocale() == 'en' ? asset('assets/media/flags/united-states.svg') : asset('assets/media/flags/france.svg') }}"
                                        alt="" />
                                </span>
                            </span>
                        </a>
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown w-175px py-4">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="lang/en" class="menu-link d-flex px-5">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1"
                                            src="{{ asset('assets/media/flags/united-states.svg') }}"
                                            alt="" />
                                    </span>Anglais</a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="lang/fr" class="menu-link d-flex px-5">
                                    <span class="symbol symbol-20px me-4">
                                        <img class="rounded-1" src="{{ asset('assets/media/flags/france.svg') }}"
                                            alt="" />
                                    </span>Français</a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <a href="{{ route('logout') }}"
                            class="menu-link px-5">{{ __('customlang.deconnexion') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Primary-->
    <!--begin::Secondary-->
    <div class="aside-secondary d-flex flex-row-fluid">
        <!--begin::Workspace-->
        <div class="aside-workspace my-5 p-5" id="kt_aside_wordspace">
            <div class="d-flex h-100 flex-column">
                <!--begin::Wrapper-->
                <div class="flex-column-fluid hover-scroll-y" data-kt-scroll="true" data-kt-scroll-activate="true"
                    data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_wordspace"
                    data-kt-scroll-dependencies="#kt_aside_secondary_footer" data-kt-scroll-offset="0px">
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        @foreach ($modules as $key => $module)
                            @if (count($module->pages) > 1 || count($module->modules) > 0)
                                <div class="tab-pane fade" id="kt_aside_nav_tab_{{ $module->id }}"
                                    role="tabpanel">
                                    <!--begin::Menu-->
                                    <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-7 px-6 my-5 my-lg-0"
                                        id="kt_aside_menu_{{ $module->id }}" data-kt-menu="true">
                                        @if ($module->mode_link->id == 1)
                                            {{-- liste-view --}}
                                            <div id="kt_aside_{{ $module->id }}_wrapper" class="menu-fit">
                                                <!--begin:Menu item-->
                                                @foreach ($module->modules as $sub_key => $sub_module)
                                                    @if (\App\Models\Outil::hasOnePermissionOf($sub_module->permissions()))
                                                        <div data-kt-menu-trigger="click"
                                                            class="menu-item menu-accordion">
                                                            <!--begin:Menu link-->
                                                            <span class="menu-link">
                                                                <span class="menu-icon">
                                                                    <span class="svg-icon svg-icon-2">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/' . $sub_module->icon . '.svg')) !!}
                                                                    </span>
                                                                </span>
                                                                <span
                                                                    class="menu-title">{{ app()->getLocale() == 'en' ? $sub_module->title_en : $sub_module->title }}</span>
                                                                <span class="menu-arrow"></span>
                                                            </span>
                                                            <!--end:Menu link-->
                                                            <!--begin:Menu sub-->
                                                            <div class="menu-sub menu-sub-accordion">
                                                                <!--begin:Menu item-->
                                                                @foreach ($sub_module->pages as $sub_page)
                                                                    <div class="menu-item">
                                                                        <!--begin:Menu link-->
                                                                        <a class="menu-link"
                                                                            href="{{ $sub_page->link }}">
                                                                            <span
                                                                                class="menu-title">{{ app()->getLocale() == 'en' ? $sub_page->title_en : $sub_page->title }}</span>
                                                                        </a>
                                                                        <!--end:Menu link-->
                                                                    </div>
                                                                @endforeach
                                                                <!--end:Menu item-->
                                                            </div>
                                                            <!--end:Menu sub-->
                                                        </div>
                                                    @endif
                                                @endforeach
                                                @foreach ($module->pages as $page)
                                                    @if (\App\Models\Outil::hasOnePermissionOf($page->permissions))
                                                        <!--end:Menu item-->
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item menu-accordion">
                                                            <!--begin:Menu link-->
                                                            <a href="{{ $page->link }}" class="menu-link">
                                                                <span class="menu-icon svg-icon svg-icon-2">
                                                                    <!--begin::Svg Icon | path: icons/duotune/communication/com005.svg-->
                                                                    {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/' . $page->icon . '.svg')) !!}
                                                                    <!--end::Svg Icon-->
                                                                </span>
                                                                <span
                                                                    class="menu-title">{{ app()->getLocale() == 'en' ? $page->title_en : $page->title }}</span>
                                                            </a>
                                                            <!--end:Menu link-->
                                                        </div>
                                                    @endif
                                                @endforeach
                                                <!--end:Menu item-->
                                            </div>
                                        @elseif($module->mode_link->id == 2)
                                            {{-- liste-card --}}
                                            <div class="list list-hover">
                                                @foreach ($module->all_pages() as $page)
                                                    @if (\App\Models\Outil::hasOnePermissionOf($page->permissions))
                                                        <div class="list-item hoverlable p-2 p-lg-3 mb-2">
                                                            <a href="{{ $page->link }}"
                                                                class="d-flex align-items-center">
                                                                <div class="symbol symbol-40px me-4">
                                                                    <span
                                                                        class="svg-icon svg-icon-2x svg-icon-hover-primary menu-icon symbol-label bg-body">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/' . $page->icon . '.svg')) !!}
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex flex-column flex-grow-1 me-2">
                                                                    <span
                                                                        class="text-dark-75 text-hover-primary fs-6 mb-0">{{ app()->getLocale() == 'en' ? $page->title_en : $page->title }}</span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @elseif($module->mode_link->id == 3)
                                            {{-- card-view --}}
                                            <div class="offcanvas-content pr-5 me-n5">
                                                <div class="row gutter-b">
                                                    @foreach ($module->all_pages() as $page)
                                                        @if (\App\Models\Outil::hasOnePermissionOf($page->permissions))
                                                            <div class="col-12 col-md-12 col-lg-6 mb-5">
                                                                <a href="{{ $page->link }}"
                                                                    class="btn btn-block btn-light btn-light-primary text-dark-50 text-center py-lg-10 px-lg-5">
                                                                    <span class="svg-icon svg-icon-3x m-0">
                                                                        {!! file_get_contents(public_path('assets/media/svg/icons/sidebar/' . $page->icon . '.svg')) !!}
                                                                    </span>
                                                                    <span
                                                                        class="d-block fw-bold font-size-h6 mt-2">{{ app()->getLocale() == 'en' ? $page->title_en : $page->title }}</span>
                                                                </a>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <!--end::Menu-->
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!--end::Tab content-->
                </div>
                <div class="flex-column-auto pt-10 px-5" id="kt_aside_secondary_footer">
                    <div class="colors text-center mb-8 d-none">
                        <h4>Menu Contextuel Switcher</h4>
                        <input type="color" name="c1" id="c1" value="#2BA3A3"/>
                        <input type="color" name="c2" id="c2" value="#70cefa"/>
                    </div>

                    <a ng-click="getElements('pages', {queries: ['autre:0']});showModalAdd('searchpage');"
                        href=""
                        class="btn btn-bg-light btn-color-gray-600 btn-flex btn-active-color-primary flex-center w-100"
                        data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" data-bs-trigger="hover"
                        data-bs-offset="0,5" data-bs-dismiss-="click" title="Afficher toutes les pages du soft">
                        <span class="btn-label">Rechercher une page @{{ shorcutIndice }}</span>
                        <!--begin::Svg Icon | path: icons/duotune/general/gen005.svg-->
                        <span class="d-none svg-icon btn-icon svg-icon-4 ms-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z"
                                    fill="currentColor" />
                                <rect x="7" y="17" width="6" height="2" rx="1"
                                    fill="currentColor" />
                                <rect x="7" y="12" width="10" height="2" rx="1"
                                    fill="currentColor" />
                                <rect x="7" y="7" width="6" height="2" rx="1"
                                    fill="currentColor" />
                                <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </a>
                </div>
            </div>
        </div>
    </div>
    <button id="kt_aside_toggle"
        class="btn btn-sm btn-icon bg-body btn-color-gray-700 btn-active-primary position-absolute translate-middle start-100 end-0 bottom-0 shadow-sm d-none d-lg-flex mb-5"
        data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
        data-kt-toggle-name="aside-minimize">
        <span class="svg-icon svg-icon-2 rotate-180">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect opacity="0.5" x="6" y="11" width="13" height="2" rx="1"
                    fill="currentColor" />
                <path
                    d="M8.56569 11.4343L12.75 7.25C13.1642 6.83579 13.1642 6.16421 12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75L5.70711 11.2929C5.31658 11.6834 5.31658 12.3166 5.70711 12.7071L11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25C13.1642 17.8358 13.1642 17.1642 12.75 16.75L8.56569 12.5657C8.25327 12.2533 8.25327 11.7467 8.56569 11.4343Z"
                    fill="currentColor" />
            </svg>
        </span>
    </button>
</div>
