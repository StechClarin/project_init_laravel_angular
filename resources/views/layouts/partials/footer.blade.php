<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#1BC5BD", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#6993FF", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#1BC5BD", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#E1E9FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->

<!--lightbox zoom image-->
<script src="{{asset('assets/js/pages/lightbox-plus.js')}}"></script>

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{asset('assets/js/theme/plugins.bundle.js?v=').(Carbon\Carbon::now()->format('h:i:s__d.m.Y'))}}"></script>
<script src="{{asset('assets/js/theme/scripts.bundle.js?v=').(Carbon\Carbon::now()->format('h:i:s__d.m.Y'))}}"></script>
<script src="{{asset('assets/js/theme/widgets.bundle.js?v=').(Carbon\Carbon::now()->format('h:i:s__d.m.Y'))}}"></script>
<script src="{{asset('assets/js/main.js?v=').(Carbon\Carbon::now()->format('h:i:s__d.m.Y'))}}"></script>

<!--AngularJS-->
<script src="{{asset("assets/js/angular-dependancies.js?=").(Carbon\Carbon::now()->format('h:i:s__d.m.Y'))}}" type="text/javascript"></script>

<!--map-->
<script src="https://maps.google.com/maps/api/js?key=AIzaSyAhv1P5d-KDs30Iz1iMgn91XYsxRfjFmd4"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
<script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script>

<script src="{{ asset("js/app-laravel.js") }}" type="text/javascript"></script>
{{-- <script src="{{ asset("js/moment.js") }}" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/locale/fr.js"></script> --}}

<script src="{{asset("assets/js/BACKOFFICE.js?v=").(Carbon\Carbon::now()->format('h:i:s__d.m.Y'))}}"></script>
