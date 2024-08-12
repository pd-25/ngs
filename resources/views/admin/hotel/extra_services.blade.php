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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Cost')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($extraServices as $extraService)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $extraServices->firstItem() + $loop->index }}</td>

                                        <td data-label="@lang('Name')">
                                            {{ $extraService->name }}
                                        </td>

                                        <td data-label="@lang('Cost')">
                                            {{ showAmount($extraService->cost) }} {{ __($general->cur_text) }}
                                        </td>
                                        
                                        <td data-label="@lang('Name')">
                                            {{ $extraService->qty }}
                                        </td>

                                        <td data-label="@lang('Status')">
                                            @php echo $extraService->statusBadge @endphp
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $extraService }}" data-modal_title="@lang('Update Extra Service')" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
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
                @if ($extraServices->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($extraServices) }}
                    </div>
                @endif
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
                <form action="{{ route('admin.hotel.extra_services.save') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> @lang('Service Name')</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label> @lang('Cost')</label>
                            <input type="number" step="0.00" class="form-control" name="cost" value="{{ old('cost') }}" required>
                        </div>
                        
                         <div class="form-group">
                            <label> @lang('Quantity')</label>
                            <input type="number" step="0.01" class="form-control" name="qty" value="{{ old('qty') }}" required>
                        </div>
                        <div class="status"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add Extra Service')">
        <i class="las la-plus"></i>@lang('Add New ')
    </button>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('#cuModal').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });

        })(jQuery);
    </script>
@endpush
