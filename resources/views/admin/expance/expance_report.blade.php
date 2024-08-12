@php
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.app')

@section('panel')
<div class="row ">
    
    <div class="col-lg-12"  style="display-flex">
          <form  style="display: contents;" action="{{ route('admin.expance_report.filter_by_date') }}" method="post">
               @csrf
        <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here bg--white" data-position='bottom right' placeholder="@lang('From - To')" autocomplete="off" value="{{ request()->date }}">
       
        <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </form>
        
        <form  style="display: contents;" action="{{ route('admin.expance_report.filter_by_user') }}" method="post">
              @csrf
             <select style="margin-left: 20px; background-color: #ffff;"  id="expense_category" name="id" required="">
                        <option value="0" >Filter Receptionist-Wise</option>
                  @foreach($users as $user)      
                <option value="{{$user->id }} " <?php echo  ($user_id == $user->id)?'selected':''; ?> >{{$user->name }}</option>
           @endforeach

                </select>
                
                 <button class="btn btn--primary input-group-text"  type="submit"><i class="fa fa-search"></i></button>
               </form>  
               
                <form  style="display: contents;" action="{{ route('admin.expance_report.filter_by_customer') }}" method="post">
              @csrf
             <select style="margin-left: 20px; background-color: #ffff;"  id="expense_category" name="customer_id" required="">
                        <option disabled selected >Filter Customer-Wise</option>
                  @foreach($customer as $customers)      
                <option value="{{$customers->id }}"  <?php echo  ($customer_id == $customers->id)?'selected':''; ?>  ><?php echo isset($customers->guest_details->name) ? $customers->guest_details->name : '' ?></option>
     @endforeach

                </select>
                
                 <button class="btn btn--primary input-group-text"  type="submit"><i class="fa fa-search"></i></button>
               </form>  
               
               <a href="{{ route('admin.expance_report.all') }}" class="btn btn-primary mx-2" style="background:gray;border:gray" >Reset</a>
                 
        <button class="btn btn-primary" style="margin-left: 10px;" id="printButton">Print</button>
        <br/><br/>
    </div> 
    <div class="col-lg-12">
                
                   

        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table--light table" id="printTable">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th style="text-align:left;">@lang('Debit')</th>
                                <th style="text-align:left;">@lang('Credit')</th>
                                <th style="text-align:left;">@lang('Payment type')</th>
                                <th style="text-align:left;">@lang('Date')</th>
                                <th style="text-align:left;">@lang('Particulars')</th>
                                <th style="text-align:left;">@lang('Expense type')</th>
                                <th style="text-align:left;">@lang('Expense Category')</th>
                               
                                <!--<th>@lang('Action')</th>-->
                            </tr>
                        </thead>
<tbody>
    

    
    @php
  
     $Totalcredit =0;
     $Totaldebit = 0;
    $i = 1;
    $combinedData = $data->concat($table2Data);
    
    @endphp
    @forelse($combinedData as $item)
  
    @if($user_id == 0 && $customer_id == 0  && $item->particulars != 'test')
    <?php  ?>
   
    <tr>
        <td data-label="@lang('S.N.')">{{ $table2Data->firstItem() + $loop->index-1 }}</td>
        @if(isset($item->debit) && isset($item->credit))
        @php
        
             $Totalcredit +=  str_replace(',', '', $item->credit);
       
        $Totaldebit += str_replace(',', '', $item->debit);
        
        @endphp
            <td style="text-align:left;" data-label="@lang('Debit')">{{ $item->debit }}  </td>
            <td style="text-align:left;" data-label="@lang('Credit')">{{ $item->credit }}.00</td>
        @else
        
         @php
        
             $Totalcredit +=  str_replace(',', '', $item->paid_amount);
      
        $Totaldebit += str_replace(',', '', $item->total_amount);
        
        @endphp
        
            <td style="text-align:left;" data-label="@lang('Credit')">{{ number_format($item->total_amount, 2) }}</td>
            <td style="text-align:left;" data-label="@lang('Credit')">{{ number_format($item->paid_amount, 2) }}</td>
        @endif
        
        <td style="text-align:left;" data-label="@lang('payment')"> </td> 
        
<td style="text-align:left;" data-label="@lang('Date')">
    @if(!empty($item->booked_room_min_booked_for))
        {{ \Carbon\Carbon::parse($item->booked_room_min_booked_for)->format('d M, Y') }}
    @else
        {{ date('d M, Y', strtotime($item->date)) }}
    @endif
</td>









<td style="text-align:left;" data-label="@lang('Particulars')">
    @if(isset($item->booking_number) && isset($item->guest_details->name))
        {{ $item->booking_number }} | {{ $item->guest_details->name }}
    @endif
    {{ __($item->particulars) }}
</td>

        <td style="text-align:left;" data-label="@lang('Expense Type')">
            @if(isset($item->expense_type))
                {{ $item->expense_type }}
            @else
                Office
            @endif
        </td>
        <td style="text-align:left;" data-label="@lang('Expense Category')">
            @if(isset($item->expense_category))
                {{ $item->expense_category }}
            @else
                ""
            @endif
        </td>
    </tr>
    @elseif($user_id == $item->user_id && $customer_id == 0 && $item->particulars != 'test')
     <tr>
        <td data-label="@lang('S.N.')">{{ $table2Data->firstItem() + $loop->index-1 }}</td>
        @if(isset($item->debit) && isset($item->credit))
      
            <td style="text-align:left;" data-label="@lang('Debit')">{{ $item->debit }}</td>
            <td style="text-align:left;" data-label="@lang('Credit')">{{ $item->credit }}.00</td>
        @else
            <td style="text-align:left;" data-label="@lang('Credit')">{{ number_format($item->total_amount, 2) }}</td>
            <td style="text-align:left;" data-label="@lang('Credit')">{{ number_format($item->paid_amount, 2) }}</td>
        @endif
        
        
        
<td style="text-align:left;" data-label="@lang('Date')">
    @if(!empty($item->booked_room_min_booked_for))
        {{ \Carbon\Carbon::parse($item->booked_room_min_booked_for)->format('d M, Y') }}
    @else
        {{ date('d M, Y', strtotime($item->date)) }}
    @endif
</td>









<td style="text-align:left;" data-label="@lang('Particulars')">
    @if(isset($item->booking_number) && isset($item->guest_details->name))
        {{ $item->booking_number }} | {{ $item->guest_details->name }}
    @endif
    {{ __($item->particulars) }}
</td>

        <td style="text-align:left;" data-label="@lang('Expense Type')">
            @if(isset($item->expense_type))
                {{ $item->expense_type }}
            @else
                Office
            @endif
        </td>
        <td style="text-align:left;" data-label="@lang('Expense Category')">
            @if(isset($item->expense_category))
                {{ $item->expense_category }}
            @else
                ""
            @endif
        </td>
    </tr>
    
    
     @elseif($customer_id == $item->id && $user_id == 0  && $item->particulars != 'test')
     <tr>
        <td data-label="@lang('S.N.')">{{ $table2Data->firstItem() + $loop->index-1 }}</td>
        @if(isset($item->debit) && isset($item->credit))
      
            <td style="text-align:left;" data-label="@lang('Debit')">{{ $item->debit }}</td>
            <td style="text-align:left;" data-label="@lang('Credit')">{{ $item->credit }}.00</td>
        @else
            <td style="text-align:left;" data-label="@lang('Credit')">{{ number_format($item->total_amount, 2) }}</td>
            <td style="text-align:left;" data-label="@lang('Credit')">{{ number_format($item->paid_amount, 2) }}</td>
        @endif
        
        
        
<td style="text-align:left;" data-label="@lang('Date')">
    @if(!empty($item->booked_room_min_booked_for))
        {{ \Carbon\Carbon::parse($item->booked_room_min_booked_for)->format('d M, Y') }}
    @else
        {{ date('d M, Y', strtotime($item->date)) }}
    @endif
</td>









<td style="text-align:left;" data-label="@lang('Particulars')">
    @if(isset($item->booking_number) && isset($item->guest_details->name))
        {{ $item->booking_number }} | {{ $item->guest_details->name }}
    @endif
    {{ __($item->particulars) }}
</td>

        <td style="text-align:left;" data-label="@lang('Expense Type')">
            @if(isset($item->expense_type))
                {{ $item->expense_type }}
            @else
                Office
            @endif
        </td>
        <td style="text-align:left;" data-label="@lang('Expense Category')">
            @if(isset($item->expense_category))
                {{ $item->expense_category }}
            @else
                ""
            @endif
        </td>
    </tr>
    
    @endif
    @empty
    <tr>
        <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
    </tr>
    @endforelse
    
   
</tbody>

         

                    </table>
                    
                </div>
                
                
            </div>
            
            
            <div class="card-footer py-4">
                
                 <div>
        <span><b>Total Credit</b> : {{ $Totalcredit }}.00</span>
        <span class="mx-5"><b>Total Debit</b> : {{$Totaldebit }}.00</span><br>
        <span><b>Credit - Debit</b> :  <?php  echo  $Totalcredit  - $Totaldebit  ?>.00</span>
    </div>
    
              
            </div>
            
             @if ($table2Data->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($table2Data) }}
                    </div>
                @endif
        </div><!-- card end -->
    </div>
</div>
@endsection

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
    // Function to initiate the print action
    document.getElementById('printButton').addEventListener('click', function () {
       
      printTable();
    });

    // Function to print the table
    function printTable() {
        var credit = "<?php echo $Totalcredit; ?>";
        var debit = "<?php echo $Totaldebit; ?>";
        var total_credit_debit = "<?php echo $Totalcredit - $Totaldebit; ?>";
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
      printWindow.document.write('<br><div><span><b>Total Credit</b> : '+credit+'.00</span>&nbsp;&nbsp;&nbsp;<span><b>Total Debit</b> : '+debit+'.00</span><br><span><b>Credit - Debit</b> : '+total_credit_debit+'.00</span></div>');
      printWindow.document.write('</body></html>');
      printWindow.document.close();
      printWindow.print();
    }
  </script>
    <script>
        (function($) {
            "use strict";

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker({});
            }

        })(jQuery);
        </script>
@endpush
