<!DOCTYPE html>
<html style="overflow-x: hidden;" lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(\Illuminate\Support\Facades\Auth::check()) ng-cloak="" ng-app="BackEnd" ng-csp @endif>

@include('layouts.partials.header')

@yield('content')

@include('layouts.partials.footer')

</html>


