@extends('admin.layouts.app')
@section('panel')

@php
    $availableOnly = request()->type && request()->type == 'not_booked';
@endphp

@if(!($availableOnly))
<div class="row gy-4">
    @forelse($rooms as $room)
    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <div class="widget-two__icon b-radius--5 bg--dark">
                {{ $room->room->room_number }}
            </div>
            <div class="widget-two__content d-flex align-items-center justify-content-between flex-wrap">

                @if ($room->booking->user_id)
                <h3>
                    <a href="{{ route('admin.users.detail', $room->booking->user_id) }}" class="f-size--18 text-center text--dark">{{ $room->booking->user->fullname }}</a>
                </h3>
                @else
                    <h3 class="f-size--18 text--dark">{{ @$room->booking->guest_details->name }}</h3>
                @endif

                <div class="d-flex flex-column fw-bold w-100">
                    <p class="text--muted text--small">@lang('Booking No.'): <span class="fw-bold">{{ $room->booking->booking_number }}</span></p>

                    <p class="text--muted text--small">@lang('Room Type'): {{ __($room->room->roomType->name) }}</p>
                </div>

            </div>

            <button type="button" class="widget-two__btn border--dark btn-outline--dark border btn-view" data-services="{{ $room->extraServices }}"> @lang('View Services')</button>

        </div>
    </div>
    @empty
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="text--muted">@lang('No Room Booked Yet')</h4>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endif

@if($emptyRooms->count())

@if(!($availableOnly))
<h3 class="mt-5 mb-4">@lang('Available for Booking')</h3>
@endif
    <div class="row gy-4">
        @foreach ($emptyRooms as $room)
        <div class="col-xxl-2 col-sm-2 col-3">

            <div class="bg--white p-3 rounded text-center">
                <span class="d-block fw-bold">
                    {{ $room->room_number }}
                </span>

                <span class="text--small">{{ __($room->roomType->name) }}</span>
            </div>
        </div>
        @endforeach
    </div>
@endif


<!-- Modal -->
<div class="modal fade" id="extraServices" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Extra Services')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 class="text--center">@lang('No extra service yet.')</h5>
            </div>
        </div>
    </div>
</div>

@endsection


@push('script')
    <script>
        (function($){
        'use strict';
            $('.btn-view').on('click', function (){
               let modal = $('#extraServices');
               let services = $(this).data('services');
               let content = ``;
               if(services.length){
                   content += `<ul class="list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span class="w-25">@lang('Name')</span>
                        <span class="w-25 text-center">@lang('Qty')</span>
                        <span class="w-25 text-center">@lang('Price')</span>
                        <span class="w-25 text-end">@lang('Total')</span>
                    </li>
                    `;

                   services.forEach((element, i) => {
                    content += `<li class="list-group-item d-flex justify-content-between">
                            <span class="w-25">${i+1}. ${element.extra_service.name}</span>
                            <span class="w-25 text-center">${element.qty}</span>
                            <span class="w-25 text-center">{{ $general->cur_sym }}${parseFloat(element.unit_price)}</span>
                            <span class="w-25 text-end">{{ $general->cur_sym }}${parseFloat(element.total_amount)}</span>
                        </li>`;
                   });

                   content += `</ul>`;
                }else{
                    content = `<h4 class="text-center">@lang('No service used yet')</h4>`;
                }
                modal.find('.modal-body').html(content);

               modal.modal('show');
            });

        })(jQuery);
    </script>


@endpush
