@php
$roomFare = $booking->booked_room_sum_fare;
$extraServiceCost = $booking->used_extra_service_sum_total_amount ?? 0;

$totalCost = $extraServiceCost + $roomFare;

$dueAmount = $totalCost - $booking->paid_amount;
$payable = $totalCost - $booking->paid_amount;
@endphp
@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-8">
            <div class="card b-radius--10">


                <div class="card-body p-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>@lang('Total Room Fare')</span>
                            <span>{{ $general->cur_sym . showAmount($roomFare) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>@lang('Total Extra Service Cost')</span>
                            <span>{{ $general->cur_sym . showAmount($extraServiceCost) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Total Receivable')</span>
                            <span class="fw-bold">{{ $general->cur_sym . showAmount($totalCost) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between">
                            <span class="fw-bold">@lang('Received')</span>
                            <span class="fw-bold @if ($dueAmount >= 0) text--success @else text--warning @endif">{{ $general->cur_sym }}{{ showAmount($booking->paid_amount) }}</span>
                        </li>



                        <li class="list-group-item d-flex justify-content-between fw-bold">
                            @if ($dueAmount < 0)
                                <span class="text--warning">@lang('Payable to Guest')</span>
                                <span class="text--danger">{{ $general->cur_sym . showAmount(abs($payable)) }}</span>
                            @else
                                <span>@lang('Receivable From Guest')</span>
                                <span class="text--success">{{ $general->cur_sym . showAmount($payable) }}</span>
                            @endif

                        </li>
                    </ul>

                </div>

                <div class="card-footer py-3">
                    @if ($dueAmount < 0)
                        <h4 class="text--danger mb-2"> @lang("Please reutrn the payble amount to the guest. Without return this amount this booking can't be checkout.")</h4>
                    @endif

                    @if ($dueAmount > 0)
                        <h4 class="text--danger mb-2"> @lang("Please receive the due amount from the guest. Without clear the due this booking can't be checkout.")</h4>
                    @endif

                    <div class="text-end">
                        <button class="btn btn--dark confirmationBtn ms-1" @if ($dueAmount != 0) disabled @endif data-action="{{ route('admin.booking.checkout', $booking->id) }}" data-question="@lang('Are you sure, you want to check out this booking?')"><i class="las la-sign-out-alt"></i>@lang('Check Out')</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection


@push('breadcrumb-plugins')
    <div class="d-flex align-items-center justify-content-end flex-wrap gap-1">
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline--primary"> <i class="las la-undo"></i>@lang('Back')</a>
        <a href="{{ route('admin.booking.invoice', $booking->id) }}" class="btn btn-sm btn-outline--info ms-1" target="_blank"><i class="las la-print"></i>@lang('Print')</a>
    </div>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var previous = @json(url()->previous());
            $('.sidebar__menu li a[href="' + previous + '"]').closest('li').addClass('active');
        })(jQuery);
    </script>
@endpush
