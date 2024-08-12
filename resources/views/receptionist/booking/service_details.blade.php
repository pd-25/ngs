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
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Date')</th>
                                    <th>@lang('Room Number')</th>
                                    <th>@lang('Service')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Cost')</th>
                                    <th>@lang('Total')</th>
                                    @isset($delete)
                                        <th>@lang('Delete')</th>
                                    @endisset
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td>
                                            {{ $services->firstItem() + $loop->index }}
                                        </td>

                                        <td data-label="@lang('Date')">
                                            <span class="fw-bold">{{ showDateTime($service->service_date, 'd M, Y') }}</span>
                                        </td>

                                        <td data-label="@lang('Room Number')">
                                            <span class="fw-bold">{{ $service->room->room_number }}</span>
                                        </td>

                                        <td data-label="@lang('Service')">
                                            {{ __($service->extraService->name) }}
                                        </td>

                                        <td data-label="@lang('Quantity')">
                                            {{ $service->qty }}
                                        </td>
                                        <td data-label="@lang('Cost')">
                                            {{ $general->cur_sym }}{{ showAmount($service->unit_price) }}
                                        </td>
                                        <td data-label="@lang('Total')">
                                            {{ $general->cur_sym }}{{ showAmount($service->total_amount) }}
                                        </td>

                                        @isset($delete)
                                            <td>
                                                <button class="btn btn--sm btn-outline--danger confirmationBtn" data-question="@lang('Are you sure, you want to cancel this booking?')" data-action="{{ route('receptionist.extra.service.delete', $service->id) }}">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </button>
                                            </td>
                                        @endisset
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
                @if ($services->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($services) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>

    {{-- detail modal --}}
    <div id="detailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <th>@lang('Name')</th>
                            <th>@lang('Quantity')</th>
                            <th>@lang('Room No.')</th>
                            <th>@lang('Cost')</th>
                            <th>@lang('Total')</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('receptionist.booking.all') }}" class="btn btn-sm btn-outline--primary"> <i class="las la-undo"></i>@lang('Back')</a>
@endpush
