@php
    use Carbon\Carbon;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $general->siteName('Invoice') }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ getImage(getFilePath('logoIcon') . '/favicon.png') }}">
</head>
<style>
    @page {
        size: 8.27in 11.7in;
        margin: .5in;
    }

    body {
        font-family: "Arial", sans-serif;
        font-size: 14px;
        line-height: 1.5;
    }

    /* Typography */
    .strong {
        font-weight: 700;
    }

    .fw-md {
        font-weight: 500;
    }

    .primary-text {
        color: #219ebc;
    }

    h1,
    .h1 {
        font-family: "Arial", sans-serif;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 67px;
        line-height: 1.2;
        font-weight: 500;
    }

    h2,
    .h2 {
        font-family: "Arial", sans-serif;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 50px;
        line-height: 1.2;
        font-weight: 500;
    }

    h3,
    .h3 {
        font-family: "Arial", sans-serif;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 38px;
        line-height: 1.2;
        font-weight: 500;
    }

    h4,
    .h4 {
        font-family: "Arial", sans-serif;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 28px;
        line-height: 1.2;
        font-weight: 500;
    }

    h5,
    .h5 {
        font-family: "Arial", sans-serif;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 20px;
        line-height: 1.2;
        font-weight: 500;
    }

    h6,
    .h6 {
        font-family: "Arial", sans-serif;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 16px;
        line-height: 1.2;
        font-weight: 500;
    }

    .text-uppercase {
        text-transform: uppercase;
    }

    .text-end {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    /* List Style */
    ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    /* Utilities */
    .d-block {
        display: block;
    }

    .mt-0 {
        margin-top: 0;
    }

    .m-0 {
        margin: 0;
    }

    .mt-3 {
        margin-top: 16px;
    }

    .mt-4 {
        margin-top: 24px;
    }

    .mb-3 {
        margin-bottom: 16px;
    }

    /* Title */
    .title {
        display: inline-block;
        letter-spacing: 0.05em;
    }

    /* Table Style */
    table {
        width: 7.27in;
        caption-side: bottom;
        border-collapse: collapse;
        border: 1px solid #eafbff;
        vertical-align: top;
    }

    table td {
        padding: 5px 15px;
    }

    table th {
        padding: 5px 15px;
    }

    table th:last-child {
        text-align: right !important;
    }

    .table> :not(caption)>*>* {
        padding: 12px 24px;
        border-bottom-width: 1px;
    }

    .table>tbody {
        vertical-align: inherit;
        border: 1px solid #eafbff;
    }

    .table>thead {
        vertical-align: bottom;
        color: white;
    }

    .table>thead th {
        font-family: "Arial", sans-serif;
        text-align: left;
        font-size: 16px;
        letter-spacing: 0.03em;
        font-weight: 500;
    }

    .table td:last-child {
        text-align: right;
    }

    .table th:last-child {
        text-align: right;
    }

    .table> :not(:first-child) {
        border-top: 0;
    }

    .table-sm> :not(caption)>*>* {
        padding: 5px;
    }

    .table-bordered tr {
        border: 1px solid #dee2e6;
    }

    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-bordered th {
        border: 1px solid #dee2e6;
    }


    /* Logo */
    .logo {
        display: flex;
        align-items: center;
        width: 150px;
        height: 50px;
        font-size: 24px;
        text-transform: capitalize;
    }

    .logo-img {
        max-width: 100%;
        height: auto;
        object-fit: contain;
        height: 60px;
    }

    .info {
        display: flex;
        justify-content: space-between;
        padding-top: 8px;
        padding-bottom: 8px;
    }

    .address {
        padding-bottom: 15px;
        border-bottom: 1px solid #ebebeb;
    }

    header {
        padding-top: 15px;
    }

    .body {
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .badge {
        display: inline-block;
        padding: 2px 15px;
        font-size: 10px;
        line-height: 1;
        border-radius: 15px;
    }

    .badge--success {
        color: white;
        background: #02c39a;
    }

    .badge--warning {
        color: white;
        background: #ffb703;
    }

    .badge--dark {
        background-color: rgba(0, 0, 0, 0.1);
        border: 1px solid #000000;
        color: #000000;
    }

    .align-items-center {
        align-items: center;
    }

    .list--row {
        overflow: auto
    }

    .list--row::after {
        content: '';
        display: block;
        clear: both;
    }

    .float-left {
        float: left;
    }

    .float-right {
        float: right;
    }

    .d-block {
        display: block;
    }

    .d-inline-block {
        display: inline-block;
    }

    .custom-table thead {
        background: #ab8a62;
    }

    .custom-table__subhead {
        background: #f1f0ff;
    }

    .custom-table .custom-table__payable td {
        color: #ea5455;
    }

    .custom-table__subtotal {
        background: #f1f0ff;
    }

    .custom-table th {
        padding: 10px 15px;
        font-size: 14px;
        color: #fff;
    }

    .custom-table td {
        padding: 10px 15px;
    }

    .fw-bold {
        font-weight: 700;
    }

    .text-start {
        text-align: left !important;
    }

    .mt-50 {
        margin-top: 50px;
    }
</style>

<body>
    @php
        $extraService = count($booking->usedExtraService);
       
    @endphp
    <header>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="list--row">
                        <div class="logo float-left">
                            <img src="{{ getImage(getFilePath('logoIcon') . '/logo.png') }}" alt="@lang('image')" class="logo-img">
                        </div>
                        <h6 class="float-right m-0" style="margin: 0;">Date: {{ date('d/m/Y') }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
       
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="address list--row">
                        <div class="address-to float-left">
                            <h5 class="primary-text d-block fw-md"></h5>
                            <ul class="list" style="--gap: 0.3rem">
                                <li>
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong"></span>
                                        <span style="font-size:20px;font-weight:bold;">NABIK GRIHA SAMITY</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('Address') :</span>
                                        <span>1/1 Taratala Road, Sahapur, Kolkata 700 038</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('Email') :</span>
                                        <span>nabikgriha@gmail.com</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('Mobile') :</span>
                                        <span>03323965558</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="address list--row">
                        <div class="address-to float-left">
                            <h5 class="primary-text d-block fw-md">@lang('Invoice To')</h5>
                            <ul class="list" style="--gap: 0.3rem">
                                <li>
                                    
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('Name') :</span>
                                        
                                        <span>{{ $booking->user ? $booking->user->fullname : $booking->guest_details->name }}</span>
                                    </div>
                                </li>
                                <li>
                                    
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('Email') :</span>
                                        <span>{{ $booking->user ? $booking->user->email : $booking->guest_details->email }}</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('Mobile') :</span>
                                        <span>{{ $booking->user ? $booking->user->mobile : $booking->guest_details->mobile }}</span>
                                    </div>
                                </li>
                                <li>
                                    
                                    <div class="list list--row" style="--gap: 0.5rem">
                                        <span class="strong">@lang('address') :</span>
                                        <span>
                                            @isset($booking->guest_details)
                                                {{ $booking->guest_details->address ?? '' }},<br/>
                                                {{ $booking->guest_details->state ?? '' }},
                                                {{ $booking->guest_details->city ?? '' }} -
                                                {{ $booking->guest_details->pincode ?? '' }}
                                            @endisset
                                        </span> 
                                    </div>
                                </li>
                              <li>




</li>


                               
                                
                               
                              
                            </ul>
                        </div>
                        <div class="address-form float-right">
                            <ul class="text-end">
                              
                                    <h5 class="primary-text d-block fw-md"> @lang('Bill Information') </h5>
                                </li>

                                <li>
                                    <span class="d-inline-block strong">@lang('Booking No.') :</span>
                                    <span class="d-inline-block">{{ $booking->booking_number }}</span>
                                </li>

                                @php
                                    $totalAmount = $booking->total_amount + $booking->used_extra_service_sum_total_amount
                                @endphp

                                <li>
                                    <span class="d-inline-block strong">@lang('Total Amount') :</span>
                                    <span class="d-inline-block">{{ showAmount($totalAmount) }}
                                        {{ __($general->cur_text) }}</span>
                                </li>
                                <li>
                                    <span class="d-inline-block strong">@lang('Paid Amount') :</span>
                                    <span class="d-inline-block">{{ showAmount($booking->paid_amount) }}
                                        {{ __($general->cur_text) }}</span>
                                </li>
                                <li>
                                    <span class="d-inline-block strong">@lang('Advance Amount') :</span>
                                    <span class="d-inline-block">{{ showAmount($booking->paid_amount) }}{{ __($general->cur_text) }}</span>
                                </li>
                                <li>
                                    <span class="d-inline-block strong">@lang('Stay Date') :</span>
                                   <!-- <span class="d-inline-block">{{ showDateTime($booking->booked_room_min_booked_for, 'd M, Y') }}
                                            <span class="text--info">@lang('to')</span>
                                            {{ showDateTime($booking->booked_room_max_booked_for, 'd M, Y') }}</span>-->
                                    <span class="d-inline-block">{{ showDateTime($mindate, 'd M, Y') }}
                                            <span class="text--info">@lang('to')</span>
                                            {{ showDateTime($maxdate, 'd M, Y') }}</span>
                                            
                                           
                                </li>
                                
                                 <?php 
                                            $startDate = Carbon::parse($mindate);
                                            $endDate = Carbon::parse($maxdate);
                                            
                                            // Calculate the difference between the two dates
                                            $numberOfDays = $startDate->diffInDays($endDate);
                                                                                        
                                            ?>
                                  <li>
                                    <span class="d-inline-block strong">@lang('Number of Days') :</span>
                                    <span class="d-inline-block">{{ $numberOfDays }}</span>
                                </li>
                                <li>
                                    <span class="d-inline-block strong">@lang('Bed Rates') :</span>
                                    <span class="d-inline-block">{{ showAmount($fare) }} {{ __($general->cur_text) }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if ($booking->usedExtraService->count())
                        <!--<div class="body">
                            <div class="mb-3 text-center">
                                <div class="title-inset">
                                    <h5 class="title text-uppercase m-0">@lang('Room\'s Details')</h5>
                                </div>
                            </div>
                            <table class="table-bordered custom-table table">
                                <thead>
                                    <tr>
                                        <th>@lang('Date | Room No.')</th>
                                        <th>@lang('Room Type')</th>
                                        <th>@lang('Fare')</th>
                                    </tr>
                                </thead>
                                @php
                                    $bookedRoom = $booking->bookedRoom->groupBy('booked_for');
                                @endphp

                                <tbody>
                                    @foreach ($bookedRoom as $key => $item)
                                        <tr class="custom-table__subhead">
                                            <td colspan="3" style="text-align: center;">
                                                {{ __(showDateTime($key, 'd M, Y')) }}
                                            </td>
                                        </tr>
                                        @foreach ($item as $booked)
                                            <tr>
                                                <td class="text-start">{{ __($booked->room->room_number) }}</td>
                                                <td>{{ __($booked->room->roomType->name) }}</td>
                                                <td>{{ __(showAmount($booked->fare)) }} {{ __($general->cur_text) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                    <tr class="custom-table__subhead">
                                        <td class="text-end" colspan="2">
                                            @lang('Sub Total')
                                        </td>
                                        <td>
                                            {{ showAmount($booking->bookedRoom->sum('fare')) }}{{ __($general->cur_text) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            @if ($extraService)
                                @php
                                    $extraServices = $booking->usedExtraService->groupBy('service_date');
                                @endphp
                              <!--  <div class="extra-service">
                                    <div class="mt-50 mb-3 text-center">
                                        <div class="title-inset">
                                            <h5 class="title text-uppercase">@lang('Service Details')</h5>
                                        </div>
                                    </div>
                                    <table class="table-bordered custom-table extra-service-table table">
                                        <thead>
                                            <tr>
                                                <th>@lang('Date | Room No.')</th>
                                                <th>@lang('Service')</th>
                                                <th>@lang('Quantity')</th>
                                                <th>@lang('Unit Price')</th>
                                                <th>@lang('Amount')</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($extraServices as $key => $serviceItems)
                                                <tr class="custom-table__subhead">
                                                    <td colspan="5" style="text-align: center;">
                                                        {{ __(showDateTime($key, 'd M, Y')) }}
                                                    </td>
                                                </tr>
                                                @foreach ($serviceItems as $service)
                                                    <tr>
                                                        <td>{{ __($service->room->room_number) }}
                                                        </td>
                                                        <td>{{ __($service->extraService->name) }}
                                                        </td>
                                                        <td>{{ __($service->qty) }}</td>
                                                        <td>
                                                            {{ showAmount($service->unit_price) }}
                                                            {{ __($general->cur_text) }}
                                                        </td>
                                                        <td>
                                                            {{ showAmount($service->total_amount) }}
                                                            {{ __($general->cur_text) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                            <tr class="custom-table__subhead">
                                                <td colspan="4" class="text-end">
                                                    @lang('Sub Total')
                                                </td>
                                                <td data-label="@lang('Amount')">
                                                    {{ showAmount($booking->used_extra_service_sum_total_amount) }} {{ __($general->cur_text) }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>-->
                    @endif
                    @php
                        $receivedPyaments = $booking->payments->where('type', 'RECEIVED');
                        $returnedPyaments = $booking->payments->where('type', 'RETURNED');

                    @endphp

                    @if ($receivedPyaments->count())
                        <div class="body">
                            <div class="mb-3 text-center">
                                <div class="title-inset">
                                    <h5 class="title text-uppercase m-0">@lang('Payments Received from You')</h5>
                                </div>
                            </div>
                            <table class="table-bordered custom-table table">
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
                                                {{ $payment->payment_mode }}

                                            </td>
                                            <td>{{ showAmount($payment->amount) }} {{ __($general->cur_text) }}</td>
                                        </tr>
                                    @endforeach

                                    <tr class="custom-table__subhead">
                                        <td class="text-end" colspan="2">
                                            @lang('Sub Total')
                                        </td>
                                        <td>
                                            {{ showAmount($receivedPyaments->sum('amount')) }}{{ __($general->cur_text) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($returnedPyaments->count())
                        <div class="body">
                            <div class="mb-3 text-center">
                                <div class="title-inset">
                                    <h5 class="title text-uppercase m-0">@lang('Payments Returned to You')</h5>
                                </div>
                            </div>
                            <table class="table-bordered custom-table table">
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

                                    <tr class="custom-table__subhead">
                                        <td class="text-end" colspan="2">
                                            @lang('Sub Total')
                                        </td>
                                        <td>
                                            {{ showAmount($returnedPyaments->sum('amount')) }}{{ __($general->cur_text) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
    <div class="text-center footer">This is computer generated invoice. No signature is required </div>
</body>

</html>
