@extends('admin.layouts.app')
@section('panel')
   <form  style="display: flex;margin-bottom: 30px; margin-top: -73px; margin-left: 32%;" action="{{ route('admin.booking.filter_status') }}" method="post">
              @csrf
             <select style="margin-left: 0px; background-color: #ffff; width:30%"  id="expense_category" name="filter" required="">
                        <option value="0">Filter</option>
                    
                <option value="1">Active</option>
                <option value="9">Inactive </option>
   

                </select>
                
                 <button class="btn btn--primary input-group-text"  type="submit"><i class="fa fa-search"></i></button>
               </form>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Booking Number')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Room Number')</th>
                                    <th>@lang('Booked For')</th>
                                    <th>@lang('Total Fare') | @lang('Extra Service')</th>
                                    <th>@lang('Total Cost') | @lang('Paid')</th>
                                    <th>@lang('Due')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody style="background:#ffffff">
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>
                                           
                                            {{ $bookings->firstItem() + $loop->index }}
                                        </td>

                                        <td data-label="@lang('Booking Number')">
                                            <span class="fw-bold">{{ $booking->booking_number }}</span>
                                            <br>
                                            @if (now() >= $booking->booked_room_min_booked_for && $booking->status == 1)
                                                <small class="ms-2"><i class="fa fa-circle text--success" aria-hidden="true"></i> @lang('Running')</small>
                                            @elseif(now() < $booking->booked_room_min_booked_for && $booking->status == 1)
                                                <small class="ms-2"><i class="fa fa-circle text--warning" aria-hidden="true"></i> @lang('Upcoming')</small>
                                            @elseif($booking->status == 3)
                                                <small class="ms-2"><i class="fa fa-circle text--danger" aria-hidden="true"></i> @lang('Cancelled')</small>
                                            @else
                                                <small class="ms-2"><i class="fa fa-circle text--dark" aria-hidden="true"></i> @lang('Checked Out')</small>
                                            @endif
                                        </td>

                                        <td data-label="@lang('User')">
                                            @if ($booking->user_id)
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $booking->user_id) }}"><span></span><?php echo isset($booking->user->username)?$booking->user->username:$booking->guest_details->name ?? ""; ?></a>
                                                </span>
                                                <br>
                                                <span class="fw-bold"><?php echo isset($booking->user->email)?$booking->user->email:$booking->guest_details->email ?? ""; ?></span>
                                            @else
                                                <span class="small">{{ $booking->guest_details->name ?? "" }}</span>
                                                <br>
                                                <span class="fw-bold">{{ $booking->guest_details->email ?? "" }}</span>
                                              
                                            @endif
                                        </td>
                                        
                                        <td data-label="@lang('Room Number')">
                                           @if($booking->room_number) 
                                             <span class="sml">{{ strlen($booking->room_number) > 4 ? substr($booking->room_number, 0, 4) . '...' : $booking->room_number }}</span>
                                             @endif
                                            
                                        </td>

                                        <td data-label="@lang('Booked For')">
                                            {{ showDateTime($booking->booked_room_min_booked_for, 'd M, Y') }}
                                            <br>
                                            <span class="text--info">@lang('to')</span>
                                            {{ showDateTime($booking->booked_room_max_booked_for, 'd M, Y') }}
                                        </td>

                                        <td data-label="@lang('Total Fare') | @lang('Extra Service')">
                                            {{ $general->cur_sym }}{{ __(showAmount($booking->total_amount)) }}
                                            <br>
                                            {{ $general->cur_sym }}{{ showAmount($booking->used_extra_service_sum_total_amount ?? 0) }}
                                        </td>

                                        @php
                                            $totalCost = $booking->total_amount + $booking->used_extra_service_sum_total_amount;
                                            $due = $totalCost - $booking->paid_amount;
                                        @endphp 

                                        <td data-label="@lang('Total Cost') | @lang('Paid')">
                                            {{ $general->cur_sym }}{{ showAmount($totalCost) }}
                                            <br>
                                            <span class="@if ($due >= 0) text--success @else text--danger @endif">{{ $general->cur_sym }}{{ showAmount($booking->paid_amount) }}</span>
                                        </td>

                                        <td data-label="@lang('Due')" class="@if ($due < 0) text--danger @endif">
                                            {{ $general->cur_sym }}{{ showAmount($due) }}
                                        </td>

                                        <td data-label="@lang('Action')">

                                            <div class="d-flex justify-content-end flex-wrap gap-1">

                                                <a href="{{ route('admin.booking.details', $booking->id) }}" class="btn btn-sm btn-outline--primary">
                                                    <i class="las la-desktop"></i>@lang('Details')
                                                </a>

                                                <button type="button" class="btn btn-sm btn-outline--info" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="las la-ellipsis-v"></i>@lang('More')
                                                </button>

                                                <div class="dropdown-menu">

                                                    <a href="{{ route('admin.booking.service.details', $booking->id) }}" class="dropdown-item">
                                                        <i class="las la-server"></i> @lang('Extra Services')
                                                    </a>

                                                    @if ($booking->status == 1)
                                                        <a href="javascript:void(0)" class="dropdown-item mergeBookingBtn" data-id="{{ $booking->id }}" data-booking_number="{{ $booking->booking_number }}">
                                                            <i class="las la-object-group"></i> @lang('Merge Booking')
                                                        </a>

                                                        @if (now() < $booking->booked_room_min_booked_for)
                                                            <a href="javascript:void(0)"
                                                            class="dropdown-item confirmationBtn"
                                                            data-question="@lang('Are you sure, you want to cancel this booking?')
                                                            @if($booking->paid_amount > 0)
                                                            <br>
                                                            <small class='text--danger mt-3'> @lang('Please return the paid amount to the guest. The amount will be subtracted from this system automatically. If you click on the Yes button')</small>
                                                            @endif"
                                                            data-action="{{ route('admin.booking.cancel', $booking->id) }}">
                                                                <i class="las la-times-circle"></i> @lang('Cancel Booking')
                                                            </a>
                                                        @endif


                                                        @if ($due > 0)
                                                            <a href="javascript:void(0)" class="dropdown-item payBtn" data-total="{{ $due }}" data-id="{{ $booking->id }}">
                                                                <i class="las la-money-bill-alt"></i> @lang('Receive Payment')
                                                            </a>
                                                        @endif

                                                        @if ($due < 0)
                                                            <a href="javascript:void(0)" class="dropdown-item payBtn" data-total="{{ $due }}" data-id="{{ $booking->id }}">
                                                                <i class="las la-money-bill-alt"></i> @lang('Return Payment')
                                                            </a>
                                                        @endif

                                                        @if (now() >= $booking->booked_room_min_booked_for)
                                                            <a href="{{ route('admin.booking.checkout', $booking->id) }}" class="dropdown-item">
                                                                <i class="la la-sign-out"></i> @lang('Check Out')
                                                            </a>
                                                        @endif
                                                    @endif

                                                    <a href="{{ route('admin.booking.invoice', $booking->id) }}" class="dropdown-item" target="_blank"><i class="las la-print"></i> @lang('Print Invoice')</a>


                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($bookings->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($bookings) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Payment Modal --}}
    <div id="paymentModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Receive Payment')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <h6 class="text--warning total-amount mb-3"></h6>

                        <input type="hidden" name="type">
                        <div class="form-group">
                            <label for="payment-mode">@lang('Payment Mode')</label>
                            <select class="form-control" name="payment_mode" required>
                                <option value="">@lang('Select Payment Mode')</option>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Online">Online</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>


                            <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="input" min="0" step="any" class="form-control" name="amount" required>
                                <span class="input-group-text">{{ __($general->cur_text) }}</span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                                <label>@lang('Remark')</label>
                                <textarea type="text" class="form-control " name="remark" placeholder="@lang('Enter Remarks')" autocomplete="off"></textarea>
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

    {{-- Booking Merge Modal --}}
    <div id="mergeBooking" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Merging with'): <span class="booking-with"></span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="required">@lang('Booking Number')</label>
                            <div class="d-flex">
                                <div class="input-group row gx-0">
                                    <input type="text" class="form-control" name="booking_numbers[]" required>
                                </div>
                                <button type="button" class="btn btn--success input-group-text addMoreBookingBtn ms-4 flex-shrink-0 border-0">
                                    <i class="las la-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="more-bookings"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end align-items-center flex-wrap gap-2">
        <form action="" method="GET" class="d-flex justify-content-end align-items-center flex-wrap gap-2">
            <div class="input-group w-unset">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('User / Booking Number')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>

            <div class="input-group w-unset">
                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form-control bg--white" data-position='bottom right' placeholder="@lang('Check In - Check Out')" autocomplete="off" value="{{ request()->date }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush

@push('style')
    <style>
        .alertbox {
            border: 1px solid #ced4da;
        }

        .dropdown-menu {
            padding: 0 0;
        }

        .dropdown-item {
            padding: 0.4rem 0.8rem;
        }
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            if (!$('.datepicker-here').val()) {
                $('.datepicker-here').datepicker({});
            }

            $('.payBtn').on('click', function() {
                let total = $(this).data('total');
                let id = Number($(this).data('id'));
                let modal = $('#paymentModal');
                let action = `{{ route('admin.booking.payment.partial', '') }}/${id}`;
                let modalTitle = modal.find('.modal-title');
                let amountText = modal.find('.total-amount');

                if (total < 0) {
                    total = Math.abs(total);
                    modalTitle.text(`@lang('Return Payment to Guest')`);
                    amountText.text(`@lang('Returnable Amount'): ${total} {{ __($general->cur_text) }}`);
                    modal.find('[name=amount]').val(total);
                    modal.find('[name=type]').val('return');
                } else {
                    modalTitle.text(`@lang('Receive Payment')`);
                    amountText.text(`@lang('Receivable Amount'): ${total} {{ __($general->cur_text) }}`);
                    modal.find('[name=amount]').val('');
                    modal.find('[name=type]').val('receive');
                }

                modal.find('form').attr('action', action);
                modal.modal('show');
            });


            $('.mergeBookingBtn').on('click', function(e) {
                e.preventDefault();
                let modal = $('#mergeBooking');
                let orderNumber = $(this).data('booking_number');
                let form = modal.find('form')[0];
                form.action = `{{ route('admin.booking.merge', '') }}/${$(this).data('id')}`
                modal.find('.booking-with').text(
                    `${orderNumber}`
                );
                modal.modal('show');
            });

            // add more booking for merge
            $('.addMoreBookingBtn').on('click', function() {
                let addMoreBooking = $('.more-bookings');
                addMoreBooking.append(`
                    <div class="form-group">
                        <div class="d-flex">
                            <div class="input-group row gx-0">
                                <input type="text" class="form-control" name="booking_numbers[]" required>
                            </div>
                            <button type="button" class="input-group-text bg-danger border-0 btnRemove flex-shrink-0 ms-4"><i class="las la-times"></i></button>
                        </div>
                    </div>
                `);
            });

            $(document).on('click', '.btnRemove', function() {
                $(this).parents('.form-group').remove();
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .body-wrapper,
        .table-responsive {
            overflow: unset !important;
        }
    </style>
@endpush
