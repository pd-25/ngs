@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                                <th>@lang('S.N.')</th>
                                <th>@lang('Bed Type')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($bedTypeList as $item)
                            <tr>
                                <td data-label="@lang('S.N.')">{{ $bedTypeList->firstItem() + $loop->index }}</td>
                                <td data-label="@lang('Bed Type')">
                                    {{$item->name}}
                                </td>

                                <td data-label="@lang('Action')">
                                    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $item }}" data-modal_title="@lang('Update Bed Type')">
                                        <i class="la la-pencil"></i>@lang('Edit')
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn" data-question="@lang('Are you sure, you want to delete this bed type?')" data-action="{{ route('admin.hotel.bed.delete', $item->id) }}">
                                        <i class="la la-trash"></i>@lang('Delete')
                                    </button>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="100%" class="text-center text-muted">{{ __($emptyMessage) }}</td>
                            </tr>
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($bedTypeList->hasPages())
                <div class="card-footer py-4">
                    {{ paginateLinks($bedTypeList) }}
                </div>
                @endif
            </div>
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
                    <form action="{{ route('admin.hotel.bed.save')}}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label> @lang('Bed Type')</label>
                                <input type="text" class="form-control" name="name" value="{{old('type_name')}}" required>
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
        <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
<button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Bed Type')">
    <i class="las la-plus"></i>@lang('Add New ')
</button>
@endpush

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('#cuModal').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });

        })(jQuery);
    </script>
@endpush
