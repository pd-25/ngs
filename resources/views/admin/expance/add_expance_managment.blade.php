@php
    use Carbon\Carbon;
@endphp
@extends('admin.layouts.app')

@section('panel')

<div class="row">
    <div class="col-lg-12">
        <div class="card b-radius--10">
            <div class="card-body p-0">
                <div class="table-responsive--md table-responsive">
                    <table class="table--light table">
                        <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th style="text-align:left;">@lang('Debit')</th>
                                <th style="text-align:left;">@lang('Credit')</th>
                                <th style="text-align:left;">@lang('Date')</th>
                                <th style="text-align:left;">@lang('Particulars')</th>
                                <th style="text-align:left;">@lang('Expense type')</th>
                                <th style="text-align:left;">@lang('Expense Category')</th>
                               
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $i=1
                            @endphp
                            @forelse($data as $item)
                            <tr>
                                <td data-label="@lang('S.N.')">{{ $i++ }}
                                </td>
                                <td style="text-align:left;" data-label="@lang('debit')">
                                    {{ __($item->debit) }} 
                                </td>
                                <td style="text-align:left;" data-label="@lang('credit')">
                                    {{ __($item->credit) }}
                                </td>
                                <td style="text-align:left;" data-label="@lang('date')">
                                    {{ Carbon::parse($item->date)->format('d/M/Y') }}
                                </td>
                                <td style="text-align:left;" data-label="@lang('particulars')">
                                    {{ __($item->particulars) }}
                                </td>
                                <td style="text-align:left;" data-label="@lang('expense_type')">
                                    {{ __($item->expense_type) }}
                                </td>
                                 <td>
            @foreach ($table2Data as $table2Item)
                @if ($table2Item->id == $item->expense_category)
                    {{ $table2Item->category_name }}
                @endif
            @endforeach
        </td>

                                
                                

                                

                                
                                <td data-label="@lang('Action')">
                                    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                        data-resource="{{ $item }}" data-modal_title="@lang('Update Expense')"
                                        data-edit="1" data-has_status="1">
                                        <i class="la la-pencil"></i>@lang('Edit')
                                    </button>
                                    <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                        data-action="{{ route('admin.expense_managment.remove',$item->id) }}"
                                        data-question="@lang('Are you sure to remove this item?')"><i
                                            class="la la-trash"></i> @lang('Remove')</button>


                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $emptyMessage }}</td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table><!-- table end -->
                </div>
            </div>
            <div class="card-footer py-4">
            </div>
        </div><!-- card end -->
    </div>
</div>

{{-- Add METHOD MODAL --}}
<div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('admin.expense_managment.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                     <div class="form-group">
                        <label> @lang('Date')</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
<div class="form-group">
    <label>@lang('Debit')</label>
    <input type="number" class="form-control" id="debit" name="debit" pattern="[0-9]*" inputmode="numeric" value="0" required>
</div>

<div class="form-group">
    <label>@lang('Credit')</label>
    <input type="number" class="form-control" id="credit" name="credit" pattern="[0-9]*" inputmode="numeric" value="0" required>
</div>

                   
                    
                    <div class="form-group">
                        <label for="expense_type">@lang('Expense type')</label>
                        <select class="form-control" id="expense_type" name="expense_type" required>
                            <option value="">@lang('Select Expense Type')</option>
                            <option value="Office">Office</option>
                            <option value="Employee">Employee</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="expense_type">@lang('Expense Category')</label>
                       <select class="form-control" id="expense_category" name="expense_category" required>
                        <option value="">Select</option>
@foreach ($table2Data as $item)
    <option value="{{ $item->id }}">{{ $item->category_name }}</option>
@endforeach

                </select>

                    </div>
                    <div class="form-group">
                        <label> @lang('Particulars')</label>
                        <textarea type="text" class="form-control" id="particulars" name="particulars"></textarea>
                    </div>
                    



                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<x-confirmation-modal></x-confirmation-modal>

@endsection

@push('breadcrumb-plugins')
<div class="d-flex justify-content-end flex-wrap gap-2">
    <form action="" method="GET" class="form-inline">
        <div class="input-group justify-content-end">
            <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Username / Name')"
                value="{{ request()->search }}">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>

    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
        data-modal_title="@lang('Add Expense Managment')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
</div>
@endpush

@section('script')
<script>
    $(document).ready(function() {
        $('#debit').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        });
    });
</script>

@endsection

