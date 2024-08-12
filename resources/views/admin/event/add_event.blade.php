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
                                <th>@lang('Event')</th>
                                <!--<th>@lang('Description')</th>-->
                                <th>@lang('Image')</th>
                                <!--<th>@lang('Address')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Time')</th>-->
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
                                <td data-label="@lang('Event_name')">
                                    <strong>{{ __($item->Event_name) }}<br/></strong>
                                    {{ $item->address }}<br/>
                                    {{ __($item->date) }} | {{ __($item->time) }}
                                </td>
                                <!--<td data-label="@lang('description')">
                                    <span class="fw-bold">{{ __($item->description) }}</span>
                                </td>-->
                                <td data-label="@lang('image')">
                                    <img style="height: 100px;width:300px;" class="img-fluid"
                                        src="../assets/images/{{ __($item->image) }}">

                                </td>
                                <!--<td data-label="@lang('address')">
                                    {{ $item->address }}
                                </td>
                                <td data-label="@lang('date')">
                                    {{ __($item->date) }}
                                </td>
                                <td data-label="@lang('time')">
                                    {{ __($item->time) }}
                                </td>-->
                                <!-- <td data-label="@lang('Status')">
                                            @if ($item->status == 1)
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @else
                                                <span class="badge badge--danger">@lang('Disabled')</span>
                                            @endif
                                        </td> -->
                                <td data-label="@lang('Action')">
                                    <!-- <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                                    data-resource="{{ $item }}" data-modal_title="@lang('Update Event')"
                                                    data-edit="1" data-has_status="1">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </button> -->
                                    <div class="button--group">

                                        <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn"
                                            data-resource="{{ $item }}" data-modal_title="@lang('Update Event')"
                                            data-edit="1" data-has_status="1">
                                            <i class="la la-pencil"></i>@lang('Edit')
                                        </button>

                                        <button class="btn btn-sm btn-outline--danger confirmationBtn"
                                            data-action="{{ route('admin.event.remove',$item->id) }}"
                                            data-question="@lang('Are you sure to remove this item?')"><i
                                                class="la la-trash"></i> @lang('Remove')</button>
                                    </div>

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
            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label> @lang('Event Name')</label>
                        <input type="text" class="form-control" id="Event_name" name="Event_name" required>
                    </div>
                    <div class="form-group">
                        <label> @lang('Description')</label>
                        <textarea rows="8" class="form-control border-radius-5 nicEdit"
                            name="description">{{ old('description') }}</textarea>
                        {{-- <textarea type="text" class="form-control" id="description" name="description" required></textarea> --}}
                    </div>
                    <div class="form-group">
                        <label> @lang('Image')</label>
                        <input type="file" class="form-control" id="image" name="image" value="{{old('image')}}"
                            >
                    </div>
                    <div class="form-group">
                        <label> @lang('Address')</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label> @lang('Date')</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label> @lang('Time')</label>
                        <input type="time" class="form-control" id="time" name="time" required>
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

    <script src="{{ asset('assets/templates/basic/assetss/js/clone.js') }}"></script>



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
        data-modal_title="@lang('Add New Receptionist')">
        <i class="las la-plus"></i>@lang('Add New')
    </button>
</div>
@endpush