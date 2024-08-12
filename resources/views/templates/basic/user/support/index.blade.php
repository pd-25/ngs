@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-md-12">

        <div class="table-responsive--md">
            <table class="custom--table table">
                <thead>
                    <tr>
                        <th>@lang('Subject')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Priority')</th>
                        <th>@lang('Last Reply')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supports as $support)
                        <tr>
                            <td data-label="@lang('Subject')">
                                <a href="{{ route('ticket.view', $support->ticket) }}"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a>
                            </td>
                            <td data-label="@lang('Status')">
                                @if ($support->status == 0)
                                    <span class="badge badge--success">@lang('Open')</span>
                                @elseif($support->status == 1)
                                    <span class="badge badge--primary">@lang('Answered')</span>
                                @elseif($support->status == 2)
                                    <span class="badge badge--info">@lang('Customer Reply')</span>
                                @elseif($support->status == 3)
                                    <span class="badge badge--dark">@lang('Closed')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Priority')">
                                @if ($support->priority == 1)
                                    <span class="badge badge--dark">@lang('Low')</span>
                                @elseif($support->priority == 2)
                                    <span class="badge badge--secondary">@lang('Medium')</span>
                                @elseif($support->priority == 3)
                                    <span class="badge badge--primary">@lang('High')</span>
                                @endif
                            </td>
                            <td data-label="@lang('Last Reply')">{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                            <td data-label="@lang('Action')">
                                <a href="{{ route('ticket.view', $support->ticket) }}" class="btn btn-outline--base" data-bs-toggle="tooltip" data-bs-position="top" title="Ticket view">
                                    <i class="las la-desktop"></i> @lang('View')
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $supports->links() }}

    </div>
@endsection
