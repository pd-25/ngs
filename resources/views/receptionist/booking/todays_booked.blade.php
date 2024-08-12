@extends('receptionist.layouts.app')
@section('panel')

          <div class="row mb-4">
       
        <h6 class="mb-2">Booking Status</h6>
        <div class="col-md-4 mb-2">
            <div class="card bg-info text-white">
                <div class="card-header text-center">
                    <h6>{{ $totalRooms_1->name }}</h6>
                </div>
                <div class="card-body text-center">
                    <p><b>{{ $totalRooms_1->total_adult - $occupiedRooms_1 }}</b> out of <b>{{ $totalRooms_1->total_adult }}</b></p>
                </div>
            </div>
        </div>
        
         <div class="col-md-4 mb-2">
            <div class="card bg-info text-white">
                <div class="card-header text-center">
                    <h6>{{ $totalRooms_2->name }}</h6>
                </div>
                <div class="card-body text-center">
                    <p><b>{{ $totalRooms_2->total_adult - $occupiedRooms_2 }}</b> out of <b>{{ $totalRooms_2->total_adult }}</b></p>
                </div>
            </div>
        </div>
        
         <div class="col-md-4 mb-2">
            <div class="card bg-info text-white">
                <div class="card-header text-center">
                    <h6>{{ $totalRooms_3->name }}</h6>
                </div>
                <div class="card-body text-center">
                    <p><b>{{ $totalRooms_3->total_adult - $occupiedRooms_3}}</b> out of <b>{{ $totalRooms_3->total_adult }}</b></p>
                </div>
            </div>
        </div>
       
    </div>
    
      <div class="row mb-2">
         <h6>Inventory Stock</h6>
       @foreach($ExtraService as $Extra)
        <div class="col-md-4 mb-2 mt-2">
            <div class="card bg-info text-white">
                <?php
                    $UsedExtraServices =   DB::table('used_extra_services')->where('extra_service_id',$Extra->id)->where('service_date', $selectedDate)->get();
                    $quantity = 0;
                    if($UsedExtraServices){
                    foreach($UsedExtraServices as $UsedServices){
                        $quantity += $UsedServices->qty;
                    }
                    }
                ?>
                <div class="card-header text-center">
                    <h6>{{ $Extra->name }}</h6>
                </div>
                <div class="card-body text-center">
                    <p>{{ $Extra->qty - $quantity}}</b> out of <b>{{ $Extra->qty }}</b></p>
                </div>
            </div>
        </div>
       @endforeach
       
    </div>
    
<div class="row gy-4">
    @forelse($rooms as $room)
    <div class="col-xxl-3 col-xl-4 col-lg-6 col-md-6">
        <div class="widget-two box--shadow2 b-radius--5 bg--white">
            <div class="widget-two__icon b-radius--5 bg--dark">
                {{ $room->room->room_number }}
            </div>
            <div class="widget-two__content d-flex align-items-end justify-content-between flex-wrap">

                <div>
    @if ($room->booking)
        @if ($room->booking->user_id)
            <h3>
                <a href="{{ route('admin.users.detail', $room->booking->user_id) }}" class="f-size--18 text-center text--dark"><?php echo isset($room->booking->user->fullname)?$room->booking->user->fullname:''; ?></a>
            </h3>
        @else
            <h3 class="f-size--18 text--dark">{{ @$room->booking->guest_details->name }}</h3>
        @endif

        <div class="d-flex flex-column fw-bold w-100">
            <p class="text--muted text--small">@lang('Booking No.'): <span class="fw-bold">{{ $room->booking->booking_number }}</span></p>
            <p class="text--muted text--small">@lang('Room Type'): {{ __($room->room->roomType->name) }}</p>
        </div>
    @else
        <h3 class="f-size--18 text--dark">@lang('Booking Not Found')</h3>
    @endif
</div>


                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('receptionist.extra.service.add') }}?room={{ $room->room->room_number }}" class="btn btn--xs btn-outline--dark" data-services="{{ $room->extraServices }}"> <i class="la la-plus"></i>@lang('Add Service')</a>

                    <button type="button" class="btn btn--xs btn-outline--info btn-view" data-services="{{ $room->extraServices }}"> <i class="la la-eye"></i>@lang('View Services')</button>
                </div>
            </div>
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

@if($emptyRooms->count())
<h3 class="my-3">@lang('Available for Booking')</h3>
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
