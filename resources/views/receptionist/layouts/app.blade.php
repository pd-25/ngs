@extends('receptionist.layouts.master')

@section('content')
    <!-- page-wrapper start -->
    <div class="page-wrapper default-version">
        @include('receptionist.partials.sidenav')
        @include('receptionist.partials.topnav')

        <div class="body-wrapper">
            <div class="bodywrapper__inner">

                @include('receptionist.partials.breadcrumb')

                @yield('panel')


            </div><!-- bodywrapper__inner end -->
        </div><!-- body-wrapper end -->
    </div>



@endsection
