@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
           <button class="btn btn-primary mb-2" id="printButton">Print</button>
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table" id="printTable">
                            <thead>
                                <tr>
                                    <th>@lang('Booking No.')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Issued By')</th>
                                    <th>@lang('Date')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($paymentLog as $log)
                                    <tr>
                                        <td data-label="@lang('Booking No.')">
                                            <span class="fw-bold">{{ @$log->booking->booking_number }}</span>
                                        </td>

                                        <td data-label="@lang('User')">
                                            @if (@$log->booking->user_id)
                                                {{ __($log->booking->user ? $log->booking->user->firstname : "") }}
                                                <br>
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $log->booking->user_id) }}"><span>@</span>{{ $log->booking->user ? $log->booking->user->username : "" }}</a>
                                                </span>
                                            @else
                                                {{ __($log->booking->guest_details->name) }}
                                                <br>
                                                <span class="small fw-bold">{{ $log->booking->guest_details->email }}</span>
                                            @endif
                                        </td>

                                        <td data-label="@lang('Amount')">
                                            <span class="fw-bold">{{ showAmount($log->amount) }} {{ __($general->cur_text) }}</span>
                                        </td>

                                        <td data-label="@lang('Issued By')">
                                            @if ($log->receptionist_id)
                                                <a href="{{ route('admin.receptionist.all') }}?search={{ $log->receptionist->name }}">{{ __($log->receptionist->name) }}</a>
                                            @elseif($log->admin_id)
                                                {{ __($log->admin->name) }}
                                            @else
                                                <span class="text--cyan">@lang('Direct Payment')</span>
                                            @endif
                                        </td>

                                        <td data-label="@lang('Date')">
                                            {{ showDateTime($log->created_at) }} <br>
                                            {{ diffForHumans($log->created_at) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($paymentLog->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($paymentLog) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end gap-2">
        <form action="" method="GET" class="form-search d-flex justify-content-between gap-2">
            <div class="input-group">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('User / Booking No.')" value="{{ request()->search }}">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="@lang('From - To')" autocomplete="off" value="{{ request()->date }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('script')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
    <script>
        "use strict";

        $('[name=type]').on('change', function() {
            $('.form-search').submit();
        })

        @if (request()->type)
            let type = @json(request()->type);
            $(`[name=type] option[value="${type}"]`).prop('selected', true);
        @endif
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
      var printContainer = document.getElementById('printTable').outerHTML;
      var printWindow = window.open('', '_blank');
      printWindow.document.write('<html><head><title>Booking Actions Report</title>');
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
