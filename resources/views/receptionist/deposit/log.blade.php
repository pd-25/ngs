<!-- payment.blade.php -->

@php
    use Carbon\Carbon;
@endphp
@extends('receptionist.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
              <button class="btn btn-primary mb-2" id="printButton">Print</button>
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive" id="printContainer">
                        <table class="table--light table" id="printTable">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th style="text-align:left;">@lang('Booking Number')</th>
                                    <th style="text-align:left;">@lang('User')</th>
                                    <th style="text-align:left;">@lang('Booked For')</th>
                                    <th style="text-align:left; display:none;">@lang('Total Fare | Extra Service')</th>
                                    <th style="text-align:left; display:none;">@lang('Total Cost | Paid')</th>
                                    <th style="text-align:left;">@lang('Due')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    $totalDuePayment = 0;
                                @endphp
                                @forelse ($bookings as $item)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $i++ }}</td>
                                        <td style="text-align:left;" data-label="@lang('Booking Number')">
                                            {{ __($item->booking_number) }}
                                        </td>
                                        <td style="text-align:left;" data-label="@lang('User')">
                                            {{ $item->guest_details->name ?? '' }}<br>
                                            <a href="tel:{{ $item->guest_details->mobile ?? '' }}"><b>{{ $item->guest_details->mobile ?? '' }}</b></a>
                                        </td>
                                        <td style="text-align:left;" data-label="@lang('Booked For')">
                                            {{ showDateTime($item->booked_room_min_booked_for, 'd M, Y') }}<br>
                                            <span class="text--info">@lang('to')</span>
                                            {{ showDateTime($item->booked_room_max_booked_for, 'd M, Y') }}
                                        </td>
                                        <td style="text-align: left; display:none;"
                                            data-label="@lang('Total Fare | Extra Service')">
                                            {{ number_format($item->total_amount, 2) }}
                                        </td>
                                        <td style="text-align: left; display:none;" data-label="@lang('Total Cost | Paid')">
                                            {{ number_format($item->paid_amount, 2) }}
                                        </td>
                                        <td style="text-align: left;" data-label="@lang('Due')">
                                            <span class="due-amount" data-total="{{ $item->total_amount }}"
                                                data-paid="{{ $item->paid_amount }}"></span>
                                        </td>
                                    </tr>
                                    @php
                                        $totalDuePayment += $item->total_amount - $item->paid_amount;
                                    @endphp
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <span style="float:right;" class="text--info pr-70">@lang('Total Due Payment') = {{ number_format($totalDuePayment, 2) }}</span>
                        <!-- table end -->
                    </div>
                </div>
                <div class="card-footer py-4"></div>
            </div>
            <!-- card end -->
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>

    @push('breadcrumb-plugins')
        <div class="d-flex justify-content-end flex-wrap gap-2">
            <form action="" method="GET" class="form-inline">
                <div class="input-group justify-content-end">
                    <input type="text" name="search" class="form-control bg--white"
                        placeholder="@lang('Username / Name')" value="{{ request()->search }}">
                    <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="@lang('From - To')" autocomplete="off" value="{{ request()->date }}">
                    <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
        <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
        <script>
            // jQuery code to calculate and display the due amount for each item
            $(document).ready(function() {
                $(".due-amount").each(function() {
                    var totalAmount = parseFloat($(this).data("total"));
                    var paidAmount = parseFloat($(this).data("paid"));
                    var dueAmount = totalAmount - paidAmount;
                    $(this).text(dueAmount.toFixed(2));
                });
            });
        </script>
        <script>
        (function($) {
            "use strict";

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker({});
            }

        })(jQuery);
        </script>
         <script>
    // Function to initiate the print action
    document.getElementById('printButton').addEventListener('click', function () {
      printTable();
    });

    // Function to print the table
    function printTable() {
      var printContainer = document.getElementById('printContainer').outerHTML;
      var printWindow = window.open('', '_blank');
      printWindow.document.write('<html><head><title>Panding Payment Report</title>');
      printWindow.document.write('<style>');
      printWindow.document.write('table, th, td { border: 1px solid black;border-collapse:collapse; }');
      printWindow.document.write('table { width: 100%; }');
      printWindow.document.write('@media print { table { border-collapse: collapse; width: 100%; } }');
      printWindow.document.write('</style>');
      printWindow.document.write('</head><body>');
      printWindow.document.write(printContainer);
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    }
  </script>
    @endpush
@endsection
