@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4 booking-wrapper">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between booking-info-title mb-0">
                        <h5>@lang('Booking Information')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pb-3">
                        <span class="fas fa-circle text--danger" disabled></span>
                        <span class="mr-5">@lang('Booked')</span>
                        <span class="fas fa-circle text--success"></span>
                        <span class="mr-5">@lang('Selected')</span>
                        <span class="fas fa-circle text--primary"></span>
                        <span>@lang('Available')</span>
                    </div>
                    <div class="alert alert-info room-assign-alert p-3" role="alert">
                    </div>
                    <div class="bookingInfo">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">
                        <h5>@lang('Book Room')</h5>
                    </div>
                </div>
                <div class="card-body">

                    <input type="hidden" name="booking_request_id" form="confirmation-form" value="{{ $bookingRequest->id }}">

                    <div class="form-group">
                        <label>@lang('Room Type')</label>
                        <input type="text" class="form-control bg--white" value="{{ $bookingRequest->roomType->name }}" disabled>
                    </div>

                    <div class="form-group">
                        <label>@lang('Name')</label>
                        <input type="text" class="form-control bg--white forGuest" form="confirmation-form" value="{{ $bookingRequest->user->fullname }}" disabled>
                    </div>

                    <div class="orderList d-none">
                        <ul class="list-group list-group-flush orderItem">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <h6>@lang('Room')</h6>
                                <h6>@lang('Days')</h6>
                                <h6>@lang('Fare')</h6>
                                <h6>@lang('Total')</h6>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-between align-items-center border-top p-3">
                            <span>@lang('Grand Total')</span>
                            <span class="totalFare" data-amount="0"></span>
                        </div>
                    </div>


                    <button type="button" class="btn btn--primary w-100 h-45 btn-book confirmationBtn" data-question="@lang('Are you sure to book this rooms?')" data-action="{{ route('admin.assign.room') }}">@lang('Book Now')</button>

                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline--primary"> <i class="las la-undo"></i>@lang('Back')</a>
@endpush

@push('style')
    <style>
        .booking-table td {
            white-space: unset;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            let roomListHtml = @json($view);
            $('.bookingInfo').html(roomListHtml);
        })(jQuery);
    </script>
@endpush
