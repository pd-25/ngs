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
                                    <th>@lang('Type')</th>
                                    <th>@lang('Room/Bed Number')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rooms as $room)
                                    <tr>
                                        <td data-label="@lang('S.N.')">
                                            {{ $rooms->firstItem() + $loop->index }}
                                        </td>

                                        <td data-label="@lang('Type')">
                                            {{ __($room->roomType->name) }}
                                        </td>

                                        <td data-label="@lang('Room Number')">
                                            {{ $room->room_number }}
                                        </td>

                                        <td data-label="@lang('Status')">
                                            @php echo $room->statusBadge @endphp
                                        </td>

                                        <td data-label="@lang('Action')">
                                            @if ($room->status == 1)
                                            <button type="button" class="btn btn-sm btn-outline--danger confirmationBtn" data-question="@lang('Are your to enable this room?')" data-action="{{ route('admin.hotel.room.status', $room->id) }}">
                                                <i class="la la-eye-slash"></i>@lang('Disable')
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-sm btn-outline--success confirmationBtn" data-question="@lang('Are your to disable this room?')" data-action="{{ route('admin.hotel.room.status', $room->id) }}">
                                                <i class="la la-eye"></i>@lang('Enable')
                                            </button>
                                            @endif
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
                @if ($rooms->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($rooms) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <form action="" method="GET" class="d-flex justify-content-end flex-wrap gap-2 filter-room">
        <div class="input-group w-unset">
            <select name="room_type" class="form-control">
                <option value="">@lang('Select One')</option>
                @foreach ($roomTypes as $type)
                <option value="{{ $type->id }}">{{ __($type->name) }}</option>
                @endforeach
            </select>
        </div>

        <div class="input-group w-unset">
            <select name="status" class="form-control">
                <option value="">@lang('Select One')</option>
                <option value="active" @if (request()->status == 'active') selected @endif>@lang('Active')</option>
                <option value="disabled" @if (request()->status == 'disabled') selected @endif>@lang('Disabled')</option>
            </select>
        </div>
        <div class="input-group w-unset">
            <input type="text" name="room_number" class="form-control bg--white" placeholder="@lang('Room Number')" value="{{ request()->room_number }}" id="room_number">
            <button class="btn btn--primary input-group-text" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </form>
@endpush

@push('script')
    <script>
        @if(request()->room_type)
            let selectedRoomType = @json(request()->room_type);
            $(`[name=room_type] option[value="${selectedRoomType}"]`).prop('selected', true);
        @endif
        
        $('select').on('change', function(){
            let form = $('.filter-room');
            form.submit();
        });
    </script>
@endpush
