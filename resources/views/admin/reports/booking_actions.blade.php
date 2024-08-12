@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary mb-2" id="printButton">Print</button>
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <!-- Add an ID to the container div -->
                        <div id="printContainer">
                            <table class="table--light style--two table" id="printTable">
                                <thead>
                                    <tr>
                                        <th>@lang('Booking No.')</th>
                                        <th>@lang('Details')</th>
                                        <th>@lang('Action By')</th>
                                        <th>@lang('Date')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookingLog as $log)
                                        <tr>
                                            <td data-label="@lang('Booking No.')">
                                                <span class="fw-bold">{{ @$log->booking->booking_number }}</span>
                                            </td>
                                            <td data-label="@lang('Details')">
                                                @if ($log->details)
                                                    {{ __(keyToTitle($log->details)) }}
                                                @else
                                                    {{ __(keyToTitle($log->remark)) }}
                                                @endif
                                            </td>

                                            <td data-label="@lang('Action By')">
                                                @if ($log->receptionist_id)
                                                    <a href="{{ route('admin.receptionist.all') }}?search={{ $log->receptionist->name }}">{{ __($log->receptionist->name) }}</a>
                                                @else
                                                    {{ @$log->admin->name }}
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
                </div>
                @if ($bookingLog->hasPages())
                   <div class="card-footer py-4 no-print">
    {{ paginateLinks($bookingLog) }}
</div>


                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="float-sm-end form-search">
        <div class="d-flex justify-content-between gap-2">
            <select name="remark" class="form-control">
                <option value="">@lang('Select One')</option>
                @foreach ($remarks as $remark)
                    <option value="{{ $remark->remark }}">{{ __(keyToTitle($remark->remark)) }}</option>
                @endforeach
            </select>
            <div class="input-group">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Booking No.')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush

@push('script')
    <script>
        "use strict";

        $('[name=remark]').on('change', function() {
            $('.form-search').submit();
        })

        @if (request()->remark)
            let remark = @json(request()->remark);
            $(`[name=remark] option[value="${remark}"]`).prop('selected', true);
        @endif 
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
