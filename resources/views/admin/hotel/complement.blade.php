@extends('admin.layouts.app')
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
                                    <th>@lang('Complement')</th>
                                    <th>@lang('Item')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($complements as $complement)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $complements->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Complement')">
                                            {{ $complement->name }}
                                        </td>

                                        <td data-label="@lang('Item')">
                                            {{ implode(', ', $complement->item) }}
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <button class="btn btn-sm btn-outline--primary editBtn"
                                                    data-action="{{ route('admin.hotel.complement.save', $complement->id) }}"
                                                    data-complement="{{ $complement }}">
                                                <i class="la la-pencil"></i> @lang('Edit')
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
                @if ($complements->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($complements) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Add METHOD MODAL --}}
    <div id="addModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label> @lang('Complement Name')</label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="required"> @lang('Item')</label>
                            <div class="d-flex">
                                <div class="input-group row gx-0">
                                    <input type="text" class="form-control first-item" name=item[]" required>
                                </div>
                                <button type="button" class="btn btn--success input-group-text border-0 addItem flex-shrink-0 ms-4"><i class="las la-plus"></i></button>
                            </div>
                        </div>

                        <div class="append-item d-none"></div>
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
    <button type="button" class="btn btn-sm btn-outline--primary addBtn" data-action="{{ route('admin.hotel.complement.save') }}"> <i class="las la-plus"></i>@lang('Add New ')</button>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.addBtn').on('click', function() {
                var modal = $('#addModal');
                modal.find('.modal-title').text('@lang("Add Complement")');
                modal.find('form').attr('action', $(this).data('action'));
                var divName = modal.find('.append-item');
                divName.html('');
                divName.addClass('d-none');
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                var modal = $('#addModal');
                modal.find('.modal-title').text('@lang("Update Complement")')
                var complement = $(this).data('complement');
                modal.find('form').attr('action', $(this).data('action'));
                modal.find('input[name=name]').val(complement.name);

                var divName = modal.find('.append-item');
                divName.html('');
                divName.removeClass('d-none');

                $.each(complement.item, function(index, element) {
                    if (index == 0) {
                        modal.find('.first-item').val(element);
                    } else {
                        divName.append(`
                            <div class="form-group">
                                <div class="d-flex">
                                    <div class="input-group row gx-0">
                                        <input type="text" class="form-control" name=item[]" value="${element}" required>
                                    </div>
                                    <button type="button" class="btn btn--danger input-group-text border-0 removeItem flex-shrink-0 ms-4"><i class="las la-times"></i></button>
                                </div>
                            </div>
                        `);
                    }

                });
                modal.modal('show');
            });

            $(document).on('click', '.addItem', function() {
                var modal = $(this).parents('.modal');
                var div = modal.find('.append-item');
                div.append(`
                <div class="form-group">
                    <div class="d-flex">
                        <div class="input-group row gx-0">
                            <input type="text" class="form-control" name=item[]" required>
                        </div>
                        <button type="button" class="btn btn--danger input-group-text border-0 removeItem flex-shrink-0 ms-4"><i class="las la-times"></i></button>
                    </div>
                </div>
                `);
                div.removeClass('d-none');
            });

            $(document).on('click', '.removeItem', function() {
                $(this).parents('.form-group').remove();
            });

            $('#updateModal').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });

            $('#addModal').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });

        })(jQuery);
    </script>
@endpush
