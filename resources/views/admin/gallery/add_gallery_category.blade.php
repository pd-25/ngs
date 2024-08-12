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
                                    <th>@lang('gallery_category')</th>
                                    <!-- <th>@lang('Status')</th> -->
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
                                     
                                        <td data-label="@lang('Gallery Category')">
                                            <span class="fw-bold">{{ __($item->gallery_category) }}</span>
                                        </td>
                                      
                                        <!-- <td data-label="@lang('Status')">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Disabled')</span>
                                            @endif
                                        </td> -->
                                        <td data-label="@lang('Action')">
                                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                    data-resource="{{ $item }}" data-modal_title="@lang('Update Event')"
                                                    data-edit="1" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button>
                                               
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                                data-action="{{ route('admin.gallery_category.remove',$item->id) }}"
                                                data-question="@lang('Are you sure to remove this item?')"><i class="la la-trash"></i> @lang('Remove')</button>
                                          
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
                <form action="{{ route('admin.gallery_category.save') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <!-- <div class="form-group">
                            <label> @lang('category_id')</label>
                            <input type="text" class="form-control" id="category_id" name="category_id" required>
                        </div> -->
                     
                        <div class="form-group">
                            <label> @lang('Gallery Category')</label>
                            <input type="text" class="form-control" id="gallery_category" name="gallery_category" required>
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
                <input type="text" name="search" class="form-control bg--white" placeholder="@lang('Username / Name')" value="{{ request()->search }}">
                <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>

        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add New Gallery')">
            <i class="las la-plus"></i>@lang('Add New')
        </button>
    </div>
@endpush
