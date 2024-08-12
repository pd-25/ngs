<div class="table-responsive--md" style="margin-top:106px;">
    <table class="custom--table head--base table">
        <thead>
            <tr>
                <th>@lang('Booking Number')</th>
                <th>@lang('Booked For')</th>
                <th>@lang('Total Charge')</th>
                <th>@lang('Paid') | @lang('Due')</th>
                <th>@lang('Action')</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($bookings as $booking)
                <tr>

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


                    <td data-label="@lang('Booked For')">
                        {{ showDateTime($booking->booked_room_min_booked_for, 'd M, Y') }}
                        <br>
                        <span class="text--info">@lang('to')</span>
                        {{ showDateTime($booking->booked_room_max_booked_for, 'd M, Y') }}
                    </td>

                    <td data-label="@lang('Total Charge')">
                        <span title="@lang('Room Fare')" data-bs-toggle="tooltip">
                            {{ $general->cur_sym }}{{ __(showAmount($booking->total_amount)) }}
                        </span>
                        <br>
                        <span title="@lang('Extra Service Cost')" data-bs-toggle="tooltip">
                            {{ $general->cur_sym }}{{ showAmount($booking->used_extra_service_sum_total_amount ?? 0) }}
                        </span>
                    </td>

                    @php
                        $totalCost = $booking->total_amount + $booking->used_extra_service_sum_total_amount;
                        $due = $totalCost - $booking->paid_amount;
                    @endphp


                    <td data-label="@lang('Paid') | @lang('Due')">
                        {{ $general->cur_sym }}{{ showAmount($booking->paid_amount) }}
                        <br>
                        <span class="text--danger">{{ $general->cur_sym }}{{ showAmount($due) }}</span>
                    </td>

                    <td data-label="@lang('Action')">

                        <a href="{{ route('user.booking.payment', $booking->id) }}" class="btn btn-sm btn-outline--info ms-1 @if ($booking->status != 1) disabled @endif">
                            <i class="las la-money-bill-alt"></i> @lang('Pay Now')
                        </a>

                        <a href="{{ route('user.booking.details', $booking->id) }}" class="btn btn-sm btn-outline--base ms-1">
                            <i class="las la-desktop"></i> @lang('Details')
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>


@if ($bookings->hasPages())
    {{ paginateLinks($bookings) }}
@endif
