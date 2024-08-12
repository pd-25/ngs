@extends($activeTemplate.'layouts.app')

@section('layout')
    @include($activeTemplate . 'partials.header')
    @if (!request()->routeIs('user.login') && !request()->routeIs('user.register'))        
        @include($activeTemplate . 'partials.breadcrumb')
    @endif
    <main class="main-wrapper">
        @yield('content')
    </main>
    @include($activeTemplate . 'partials.footer')
@endsection
