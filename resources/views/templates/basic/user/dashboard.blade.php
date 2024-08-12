@extends($activeTemplate . 'layouts.master')
@section('content')
    <h5 class="text--secondary mb-3">@lang('Booking Overview')</h5>
    <div class="row gy-4 pb-3 dashboards">
        <div class="col-xxl-4 col-sm-6 col-lg-4">
            <div class="widget widget--base">
                <div class="widget__header">
                    <div class="widget__icon">
                        <i class="las la-clipboard-list"></i>
                    </div>
                </div>
                <div class="widget__body">
                    <h6 class="widget__title"> @lang('Total')</h6>
                    <h3 class="widget__amount">{{ $booking['total'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-sm-6 col-lg-4">
            <div class="widget widget--primary">
                <div class="widget__header">
                    <div class="widget__icon">
                        <i class="las la-book"></i>
                    </div>
                </div>
                <div class="widget__body">
                    <h6 class="widget__title"> @lang('Requested')</h6>
                    <h3 class="widget__amount">{{ $booking['request'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xxl-4 col-sm-6 col-lg-4">
            <div class="widget widget--success">
                <div class="widget__header">
                    <div class="widget__icon">
                        <i class="las la-check"></i>
                    </div>
                </div>
                <div class="widget__body">
                    <h6 class="widget__title"> @lang('Active')</h6>
                    <h3 class="widget__amount">{{ $booking['successful'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6 col-lg-4">
            <div class="widget widget--danger">
                <div class="widget__header">
                    <div class="widget__icon">
                        <i class="las la-times"></i>
                    </div>
                </div>
                <div class="widget__body">
                    <h6 class="widget__title"> @lang('Cancelled')</h6>
                    <h3 class="widget__amount">{{ $booking['cancelled'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6 col-lg-4">
            <div class="widget widget--dark">
                <div class="widget__header">
                    <div class="widget__icon">
                        <i class="las la-list-alt"></i>
                    </div>
                </div>
                <div class="widget__body">
                    <h6 class="widget__title"> @lang('Checked Out')</h6>
                    <h3 class="widget__amount">{{ $booking['checkedOut'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-sm-6 col-lg-4">
            <div class="widget widget--dark">
                <div class="widget__header">
                    <div class="widget__icon">
                        <i class="la la-money"></i>
                    </div>
                </div>
                <div class="widget__body">
                    <h6 class="widget__title"> @lang('Payment')</h6>
                    <h3 class="widget__amount">{{ $general->cur_sym . showAmount($booking['total_payment']) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h5 class="text--secondary my-3">@lang('Recent Bookings')</h5>
    @include($activeTemplate . 'partials.booking_history_table', $bookings)
@endsection

@push('style')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500&display=swap');

        .widget__amount {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 500;
        }
        .dashboards{
            margin-top: 60px;
        }
    </style>
@endpush