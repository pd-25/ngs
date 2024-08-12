@extends('receptionist.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Username') | @lang('Email')</th>
                                    <th>@lang('Room Qty') | @lang('Room Type')</th>
                                    <th>@lang('Check In') | @lang('Check Out')</th>
                                    <th>@lang('Fare /Night') | @lang('Total Fare')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookingRequests as $bookingRequest)
                                    <tr>
                                        <td data-label="@lang('Username') | @lang('Email')">
                                            <span class="fw-bold">{{ $bookingRequest->user->username }}</span>
                                            <br>
                                            <span>{{ $bookingRequest->user->email }}</span>
                                        </td>

                                        <td data-label="@lang('Room Qty') | @lang('Room Type')">
                                            <span class="text--info fw-bold">
                                                {{ $bookingRequest->number_of_rooms }}
                                            </span>
                                            <br>
                                            <span class="fw-bold">{{ __($bookingRequest->roomType->name) }}</span>
                                        </td>

                                        <td data-label="@lang('Check In') | @lang('Check Out')">
                                            {{ showDateTime($bookingRequest->check_in, 'd M, Y') }}
                                            <br>
                                            <span class="text--info">@lang('to')</span> {{ showDateTime($bookingRequest->check_out, 'd M, Y') }}
                                        </td>

                                        <td data-label="@lang('Fare/Night') | @lang('Total Fare')">
                                            {{ __($general->cur_sym) }}{{ showAmount($bookingRequest->unit_fare) }}
                                            <br>
                                            <span class="fw-bold">{{ __($general->cur_sym) }}{{ showAmount($bookingRequest->total_amount) }}</span>
                                        </td>


                                        <td data-label="@lang('Action')">
                                            <a href="{{ route('receptionist.booking.request.approve', $bookingRequest->id) }}" class="btn btn-sm btn-outline--success ms-1"><i class="las la-check"></i>@lang('Approve')</a>

                                            <button class="btn btn-sm btn-outline--danger confirmationBtn ms-1" data-question="@lang('Are you sure, you want to cancel this booking request?')" data-action="{{ route('receptionist.booking.request.cancel', $bookingRequest->id) }}">
                                                <i class="las la-times-circle"></i>@lang('Cancel')
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($bookingRequests->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($bookingRequests) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>

    {{-- detail modal --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Booking Details')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="d-flex justify-content-end flex-wrap">
        <form action="" method="GET" class="form-inline">
            <div class="input-group justify-content-end">
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Username / Email')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
@endpush
