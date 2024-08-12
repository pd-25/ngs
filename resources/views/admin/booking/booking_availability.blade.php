
@extends('admin.layouts.app')

@section('panel')
<div class="container">
    <form action="{{ url('admin/booking_availability') }}" method="get">
    <div class="row">
        <div class="col-md-2 mb-2">
            <input type="date" class="form-control" name="selected_date">
        </div>  
        <div class="col-md-2 mb-2">
            <button type="submit" class="btn btn-primary btn-lg mt-1">Check Availability</button>
        </div>  
     
     <?php
     
     
     ?>
       <div class="col-md-9 mb-2">
      
            </div> 
            
                 
            
     
    </div>
    
          <div class="row">
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
    
     <div class="row ">
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
    <br>
    <div class="row">
        <h6>Booking Available</h6>
        @foreach($emptyRooms as $room)
        <div class="col-md-2 mb-2 mt-2">
            <div class="card">
                <div class="card-header text-center">
                    <h6>{{ $room->room_number }}</h6>
                </div>
                <div class="card-body text-center">
                    <p>{{ $room->roomType->name }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div></form>
</div>
@endsection



                    
                

