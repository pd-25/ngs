@extends($activeTemplate . 'layouts.master')
@section('content')

    @php
    $totalRoomCharge = $booking->bookedRoom->sum('fare');
    $totalServiceCharge = $booking->usedExtraService->sum('total_amount');
    $totalCharge = $totalRoomCharge + $totalServiceCharge;
    $due = $totalCharge - $booking->paid_amount;
    @endphp
    <h5 class="text--secondary mb-3 text-center">@lang('Booked Rooms')</h5>
    <div class="table-responsive--md">
        <table class="custom--table table">
            <thead>
                <tr>
                    <th>@lang('Booked For')</th>
                    <th>@lang('Room Type')</th>
                    <th>@lang('Room No.')</th>
                    <th>@lang('Fare') / @lang('Night')</th>
                </tr>
            </thead>
            <tbody>


                @foreach ($booking->bookedRoom->groupBy('booked_for') as $bookedRoom)
                    @foreach ($bookedRoom as $booked)
                        <tr>
                            @if ($loop->first)
                                <td data-label="@lang('Booked For')" rowspan="{{ count($bookedRoom) }}" class="bg--date text-center">
                                    {{ showDateTime($booked->booked_for, 'd M, Y') }}
                                </td>
                            @endif
                            <td data-label="@lang('Room Type')" class="text-center">
                                {{ __($booked->room->roomType->name) }}
                            </td>
                            <td data-label="@lang('Room No.')">
                                {{ __($booked->room->room_number) }}
                            </td>
                            <td data-label="@lang('Fare') / @lang('Night')">
                                {{ $general->cur_sym }}{{ showAmount($booked->fare) }}
                            </td>

                        </tr>
                    @endforeach
                @endforeach

                <tr>
                    <td colspan="3" class="text-end">
                        <span class="fw-bold">@lang('Total')</span>
                    </td>
                    <td class="fw-bold">
                        {{ $general->cur_sym }}{{ showAmount($totalRoomCharge) }}
                    </td>
                </tr>


            </tbody>
        </table>
    </div>
    @if ($booking->usedExtraService->count())
        <h5 class="text--secondary mt-4 mb-3 text-center">@lang('Services')</h5>
        <div class="table-responsive--md">
            <table class="custom--table head--base table">
                <thead>
                    <tr>
                        <th>@lang('Date')</th>
                        <th>@lang('Room No.')</th>
                        <th>@lang('Service')</th>
                        <th>@lang('Cost') | @lang('Total')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->usedExtraService->groupBy('service_date') as $services)
                        @foreach ($services as $service)
                            <tr>
                                @if ($loop->first)
                                    <td data-label="@lang('Date')" rowspan="{{ count($services) }}" class="bg--date text-center">
                                        {{ showDateTime($service->service_date, 'd M, Y') }}
                                    </td>
                                @endif

                                <td data-label="@lang('Room No.')">
                                    <span class="fw-bold">{{ __($service->room->room_number) }}</span>
                                </td>
                                <td data-label="@lang('Service')">
                                    <span class="fw-bold">
                                        {{ __($service->extraService->name) }}
                                    </span>
                                    <br>

                                    {{ $general->cur_sym }}{{ showAmount($service->unit_price) }} x {{ $service->qty }}
                                </td>
                                <td data-label="@lang('Cost') | @lang('Total')">
                                    <span class="fw-bold">
                                        {{ $general->cur_sym }}{{ showAmount($service->total_amount) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    <tr>
                        <td colspan="3" class="text-end">
                            <span class="fw-bold">@lang('Total')</span>
                        </td>
                        <td class="fw-bold">
                            {{ $general->cur_sym }}{{ showAmount($totalServiceCharge) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    @php
    $receivedPyaments = $booking->payments->where('type', 'RECEIVED');
    $returnedPyaments = $booking->payments->where('type', 'RETURNED');
    @endphp

    @if ($receivedPyaments->count())
        <h5 class="text--secondary mt-4 mb-3 text-center">@lang('Payments Recevied')</h5>
        <div class="table-responsive--md">
            <table class="custom--table head--base table">
                <thead>
                    <tr>
                        <th>@lang('Time')</th>
                        <th>@lang('Payment Type')</th>
                        <th>@lang('Amount')</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($receivedPyaments as $payment)
                        <tr>
                            <td class="text-start">{{ __(showDateTime($payment->created_at, 'd M, Y')) }}</td>
                            <td>
                                @if ($payment->admin_id == 0 && $payment->receptionist_id)
                                    @lang('Online Payment')
                                @else
                                    @lang('Cash Payment')
                                @endif

                            </td>
                            <td>{{ showAmount($payment->amount) }} {{ __($general->cur_text) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="text-end fw-bold" colspan="2">
                            @lang('Total')
                        </td>
                        <td class="fw-bold">
                            {{ showAmount($receivedPyaments->sum('amount')) }}{{ __($general->cur_text) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif

    @if ($returnedPyaments->count())
        <h5 class="text--secondary mt-4 mb-3 text-center">@lang('Payments Returned')</h5>
        <div class="table-responsive--md">
        <table class="custom--table head--base table">
            <thead>
                <tr>
                    <th>@lang('Time')</th>
                    <th>@lang('Payment Type')</th>
                    <th>@lang('Amount')</th>
                </tr>
            </thead>

                <tbody>
                    @foreach ($returnedPyaments as $payment)
                        <tr>
                            <td class="text-start">{{ __(showDateTime($payment->created_at, 'd M, Y')) }}</td>
                            <td>
                                @lang('Cash Payment')
                            </td>
                            <td>{{ showAmount($payment->amount) }} {{ __($general->cur_text) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td class="text-end" colspan="2">
                            <span class="fw-bold">@lang('Total')</span>
                        </td>
                        <td class="fw-bold">
                            {{ showAmount($returnedPyaments->sum('amount')) }}{{ __($general->cur_text) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif




    <div class="card custom--card mt-5 border-0 shadow">
        <div class="card-body">
            <ul class="list-group list-group-flush">

                <li class="d-flex justify-content-between list-group-item align-items-start">
                    <span>@lang('Total Room Charge')</span>
                    <span>{{ $general->cur_sym }}{{ showAmount($totalRoomCharge) }}</span>
                </li>

                <li class="d-flex justify-content-between list-group-item align-items-start">
                    <span>@lang('Total Service Charge')</span>
                    <span>{{ $general->cur_sym }}{{ showAmount($totalServiceCharge) }}</span>
                </li>

                <li class="d-flex justify-content-between list-group-item align-items-start text--danger">
                    <span class="fw-bold">@lang('Total Payable')</span>
                    <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($totalCharge) }}</span>
                </li>

                <li class="d-flex justify-content-between list-group-item align-items-start">
                    <span class="fw-bold">@lang('Total Received Payments')</span>
                    <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($receivedPyaments->sum('amount')) }}</span>
                </li>

                <li class="d-flex justify-content-between list-group-item align-items-start">
                    <span class="fw-bold">@lang('Total Returned Payments')</span>
                    <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($returnedPyaments->sum('amount')) }}</span>
                </li>

                <li class="d-flex justify-content-between list-group-item align-items-start text--success">
                    <span class="fw-bold">@lang('Total Paid')</span>
                    <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($booking->paid_amount) }}</span>
                </li>

                <li class="d-flex justify-content-between list-group-item align-items-start">
                    <span class="fw-bold">@lang('Due')</span>
                    <span>{{ $general->cur_sym }}{{ showAmount($due) }}</span>
                </li>

            </ul>
        </div>
    </div>

    @if ($booking->total_amount - $booking->paid_amount)
        <div class="float-end">
            <a href="{{ route('user.booking.payment', $booking->id) }}" class="btn btn-sm btn-outline--base mt-3">
                <i class="las la-money-bill-alt"></i> @lang('Pay Now')
            </a>
        </div>
    @endif
@endsection

@push('style')
    <style>
        .bg--date {
            background-color: #dadada !important;
            color: #656565 !important;
        }

        .custom--table thead th {
            background-color: var(--base-color);
            color: #fff !important;
        }

        .shadow {
            box-shadow: 0 1px 3px 0 #0000000f !important;
        }

        .custom--table tbody td:first-child {
            text-align: center;
        }

        .custom--table tbody td {
            padding: 0.3rem 0.5rem !important;
        }
    </style>
@endpush
