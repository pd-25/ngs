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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Fare')</th>
                                    <th>@lang('Rooms/Beds')</th>
                                    <th>@lang('Adult')</th>
                                    <!--<th>@lang('Child')</th>-->
                                    <th>@lang('Feature Status')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($typeList as $type)
                                    <tr>
                                        <td data-label="@lang('S.N.')">{{ $typeList->firstItem() + $loop->index }}</td>
                                        <td data-label="@lang('Name')">
                                            {{ $type->name }}
                                        </td>

                                        <td data-label="@lang('Fare')">
                                            <span class="fw-bold">
                                                {{ showAmount($type->fare) }} {{ __($general->cur_text) }}
                                            </span>
                                        </td>

                                        <td data-label="@lang('Rooms')">
                                            {{ $type->rooms_count }}
                                        </td>
                                        <td data-label="@lang('Adult')">
                                            {{ $type->total_adult }}
                                        </td>

                                        <!--<td data-label="@lang('Child')">-->
                                        <!--    {{ $type->total_child }}-->
                                        <!--</td>-->

                                        <td data-label="@lang('Feature Status')">
                                            @php echo $type->featureBadge  @endphp
                                        </td>

                                        <td data-label="@lang('Status')">
                                            @php echo $type->statusBadge  @endphp
                                        </td>

                                        <td data-label="@lang('Action')">
                                            <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.hotel.room.type.edit', $type->id) }}"> <i class="la la-pencil"></i> @lang('Edit')
                                            </a>

                                            @if ($type->status == 0)
                                                <button class="btn btn-sm btn-outline--success ms-1 confirmationBtn" data-question="@lang('Are you sure to enable this room type?')" data-action="{{ route('admin.hotel.room.type.status', $type->id) }}">
                                                    <i class="la la-eye"></i>@lang('Enable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm btn-outline--danger ms-1 confirmationBtn" data-question="@lang('Are you sure to disable this room type?')" data-action="{{ route('admin.hotel.room.type.status', $type->id) }}">
                                                    <i class="la la-eye-slash"></i>@lang('Disable')
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
                @if ($typeList->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($typeList) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.hotel.room.type.create') }}" class="btn btn-sm btn-outline--primary"><i class="las la-plus"></i>@lang('Add New')</a>
@endpush
