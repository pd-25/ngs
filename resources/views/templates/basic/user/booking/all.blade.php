@extends($activeTemplate . 'layouts.master')
@section('content')
    @include($activeTemplate . 'partials.booking_history_table', $bookings)
@endsection
