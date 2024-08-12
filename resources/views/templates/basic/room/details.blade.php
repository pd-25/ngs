i@extends($activeTemplate . 'layouts.frontend')


@section('content')
    <section class="section">
        <div class="container respons">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="room-details-head">
                        <div>
                            <h2 class="title">{{ __($roomType->name) }}</h2>
                            <div class="d-flex justify-content-center flex-wrap gap-3">
                                <span style="display:none;">
                                    @lang('Adult') &nbsp; {{ $roomType->total_adult }}
                                </span>

                                <span style="display:none;">
                                    @lang('Child') &nbsp; {{ $roomType->total_child }}
                                </span>
                            </div>
                        </div>
                        <div>
                            <h2 class="text--base fare">{{ __($general->cur_sym) }}{{ showAmount($roomType->fare) }}</h2>
                            <span class="text--base text-sm">/@lang('night')</span>
                        </div>
                    </div>

                    <div class="room-details-thumb-slider">
                        @foreach ($roomType->images as $roomTypeImage)
                            <div class="single-slide">
                                <div class="room-details-thumb">
                                    <img src="{{ getImage(getFilePath('roomTypeImage') . '/' . $roomTypeImage->image, getFileSize('roomTypeImage')) }}" alt="image">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($roomType->images->count() > 1)
                        <div class="room-details-nav-slider mt-4">
                            @foreach ($roomType->images as $roomTypeImage)
                                <div class="single-slide">
                                    <div class="room-details-nav-thumb">
                                        <img src="{{ getImage(getFilePath('roomTypeImage') . '/' . $roomTypeImage->image, getFileSize('roomTypeImage')) }}"
                                             alt="image">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="room-details-card mt-4">
                        <h5 class="title">@lang('Description')</h5>

                        <div class="body">
                            @php
                                echo $roomType->description;
                            @endphp
                        </div>
                    </div>

                    @if ($roomType->amenities)
                        <div class="room-details-card mt-4">
                            <h5 class="title">@lang('Amenities')</h5>

                            <div class="body">
                                <div class="d-inline-flex flex-md-row flex-column gap-md-5 flex-wrap gap-3">
                                    @foreach ($roomType->amenities as $amenity)
                                        <span class="me-2">
                                            @php echo $amenity->icon @endphp
                                            {{ __($amenity->title) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif


                    @if ($roomType->complements)
                        <div class="room-details-card mt-4">
                            <h5 class="title">@lang('Complements')</h5>
                            <div class="body">
                                <div class="d-inline-flex flex-md-row flex-column gap-md-5 flex-wrap gap-3">
                                    @foreach ($roomType->complements as $complement)
                                        <span class="me-2">
                                            <i class="las la-check-double"></i>
                                            {{ __($complement->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($roomType->beds)
                        <div class="room-details-card mt-4">
                            <h5 class="title">@lang('Beds')</h5>
                            <div class="body">
                                <div class="d-inline-flex flex-md-row flex-column gap-md-5 flex-wrap gap-3">
                                    @foreach ($roomType->beds as $bed)
                                        <span class="me-2"><i class="las la-check-double"></i>{{ __($bed) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-12">
                    <input type="text" name="room_type_id" form="confirmation-form" value="{{ $roomType->id }}" hidden>
                    <div class="room-booking-sidebar">
                        <div class="room-booking-widget">
                            <div class="room-booking-widget__body mt-0">
                                
                                
                                <div class="row text-center justify-content-center">
      <div class="col-lg-9">
        <h1 class="mb-0">ROOM BOOKING</h1>
        <h3 class="mb-3">Main Branch</h3>
        <p>Suspendisse eu risus urna mi enim, auctor nec fermentum libero.</p>
      </div>
    </div>
                                <div class="row ">
                                    
                                    
                                    
                                    
                                    
                                    
                                    <div class="col-lg-9">
                  <div class="row">
                    <!--<div class="col-lg-4">-->
                    <!--  <div class="form-group">-->
                    <!--    <label for="exampleFormControlSelect1">Guest Type</label>-->
                    <!--    <select class="form--control" name="guest_type" form="confirmation-form" required>-->
                    <!--      <option value="">select</option>-->
                    <!--      <option value="1">Walk-In Guest</option>-->
                    <!--      <option value="2">Existing Guest</option>-->
                    <!--    </select>-->
                    <!--  </div>-->
                    <!--</div>-->
                    <div class="col-lg-4">
  <div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form--control" form="confirmation-form" required @auth value="{{ auth()->user()->username }}" @endauth>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form--control" form="confirmation-form" required @auth value="{{ auth()->user()->email }}" @endauth>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label>Phone Number</label>
    <input type="number" name="mobile" class="form--control" form="confirmation-form" required @auth value="{{ auth()->user()->mobile }}" @endauth>
  </div>
</div>

                  </div>



                  <div class="row">
                    <!--<div class="col-lg-4">-->
                    <!--  <div class="form-group">-->
                    <!--    <label>Arrival Date</label>-->
                    <!--    <input type="date" class="form-control" id="arrival_date" name="arrival_date">-->
                    <!--  </div>-->
                    <!--</div>-->
                    

                    <div class="col-lg-4">
                      <div class="form-group">
                        <label>C.D.C No./INDOS No.</label>
                        <input type="text" name="c_d_c_number" class="form--control" form="confirmation-form" required>
                      </div>

                    </div>
                    
                    <div class="col-lg-8">
                      <div class="form-group">
                        <label>Address</label>
                        <textarea type="text" name="address" class="form--control" form="confirmation-form" required></textarea>
                      </div>

                    </div>



                  </div>

                  <!--{{-- <div class="row">-->
                  <!--  <div class="col-lg-12 board-cat-area">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Boarder Category</label><br>-->
                  <!--      <div class="form-check form-check-inline">-->
                  <!--        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1"-->
                  <!--          value="option1">-->
                  <!--        <label class="form-check-label" for="inlineRadio1">General</label>-->
                  <!--      </div>-->
                  <!--      <div class="form-check form-check-inline">-->
                  <!--        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2"-->
                  <!--          value="option2">-->
                  <!--        <label class="form-check-label" for="inlineRadio2">Trainning</label>-->
                  <!--      </div>-->
                  <!--      <div class="form-check form-check-inline">-->
                  <!--        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3"-->
                  <!--          value="option3">-->
                  <!--        <label class="form-check-label" for="inlineRadio3">Officer</label>-->
                  <!--      </div>-->
                  <!--      <div class="form-check form-check-inline">-->
                  <!--        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio4"-->
                  <!--          value="option3">-->
                  <!--        <label class="form-check-label" for="inlineRadio4">Other 1</label>-->
                  <!--      </div>-->
                  <!--      <div class="form-check form-check-inline">-->
                  <!--        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio5"-->
                  <!--          value="option3">-->
                  <!--        <label class="form-check-label" for="inlineRadio5">Other 1</label>-->
                  <!--      </div>-->
                  <!--      <div class="form-check form-check-inline">-->
                  <!--        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6"-->
                  <!--          value="option3">-->
                  <!--        <label class="form-check-label" for="inlineRadio6">Other 3</label>-->
                  <!--      </div>-->
                  <!--    </div>-->
                  <!--  </div>-->

                  <!--</div> --}}-->
                  
                  <div class="row">
                      <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                        <label>State</label>
                        <input type="text" name="state" class="form--control" form="confirmation-form" required>
                      </div>
                      </div>
                      <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                        <label>City</label>
                        <input type="text" name="city" class="form--control" form="confirmation-form" required>
                      </div>
                      </div>
                      <div class="col-md-4 col-lg-4">
                          <div class="form-group">
                        <label>Pin Code</label>
                        <input type="number" name="pin_code" class="form--control" form="confirmation-form" required>
                      </div>
                      </div>
                  </div>

                    <div class="row">
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>@lang('Check In Time')</label>
                                <!--<input type="datetime-local" class="form-control " name="cheak_in_time" placeholder="@lang('Select Time')" autocomplete="off" required>-->
                                <input type="datetime-local" class="form-control" form="confirmation-form" name="cheak_in_time" id="check_in_time" placeholder="@lang('Select Time')" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>@lang('Paying/Advance Amount')</label>
                                <input type="number" step="any" min="0" class="form-control" name="paid_amount" form="confirmation-form" placeholder="@lang('Paying Amount')">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                            <label for="payment-mode">@lang('Payment Mode')</label>
                            <select class="form--control" name="payment_mode" form="confirmation-form" required>
                                <option value="">@lang('Select Payment Mode')</option>
                                <option value="Cash">Cash</option>
                                <option value="UPI">UPI</option>
                                <option value="Credit Card">Credit Card</option>
                                <option value="Online">Online</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        </div>
                    </div>

                  <!--<div class="row">-->
                  <!--  {{-- <div class="col-lg-3">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>List Of Rooms</label>-->
                  <!--      <select class="form-control" id="exampleFormControlSelect2">-->
                  <!--       <option value="">select</option>-->
                  <!--        <option value="1">1</option>-->
                  <!--        <option value="2">2</option>-->
                  <!--        <option value="3">3</option>-->
                  <!--        <option value="4">4</option>-->
                  <!--        <option value="5">5</option>-->
                  <!--      </select>-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-lg-3">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Room No.</label>-->
                  <!--      <input id="form_room_no" type="text" name="form_room_no" class="form-control">-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-lg-3">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Bed No.</label>-->
                  <!--      <input id="form_Bed_no" type="text" name="form_Bed_no" class="form-control">-->
                  <!--    </div>-->
                  <!--  </div>-->
                  <!--  <div class="col-lg-3">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Bed Rate</label>-->
                  <!--      <input id="form_Bed_rate" type="text" name="form_Bed_rate" class="form-control">-->
                  <!--    </div>-->
                  <!--  </div>--}}-->



                  <!--  <div class="col-lg-4">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Date of Birth</label>-->
                  <!--      <input type="date" name="date_of_birth" class="form--control" form="confirmation-form" required>-->
                  <!--    </div>-->

                  <!--  </div>-->


                  <!--  <div class="col-lg-4">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Endorse No.</label>-->
                  <!--      <input  type="text" name="endorse_no" class="form--control" form="confirmation-form" required>-->
                  <!--    </div>-->

                  <!--  </div>-->

                  <!--      <div class="col-lg-4">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Article</label>-->
                  <!--      <select class="form--control" form="confirmation-form" name="article" required>-->
                  <!--         <option value="">select</option>-->
                  <!--        <option value="1">1</option>-->
                  <!--        <option value="2">2</option>-->
                  <!--        <option value="3">3</option>-->
                  <!--        <option value="4">4</option>-->
                  <!--        <option value="5">5</option>-->
                  <!--      </select>-->
                  <!--    </div>-->

                  <!--  </div>-->
                    

                  <!--</div>-->


                  <!--<div class="row">-->
                      
                  <!--  <div class="col-lg-12">-->
                  <!--    <div class="form-group">-->
                  <!--      <label>Remarks(If Any)</label>-->
                  <!--      <input type="text"  class="form--control" form="confirmation-form" name="remark" required>-->
                  <!--    </div>-->
                  <!--    {{-- <div class="form-group form-check">-->
                  <!--      <input type="checkbox" class="form-check-input" id="exampleCheck1">-->
                  <!--      <label class="form-check-label" for="exampleCheck1">Check Remarks</label>-->
                  <!--    </div> --}}-->

                  <!--  </div>-->
                  <!--</div>-->
                </div>
                
                <div class="col-lg-3 pf-img-box">
                  <h4><i class="fa fa-camera" aria-hidden="true"></i> Image of C.D.C. Holder</h4>
                  <!--<input type="file" name="image" class="form--control" form="confirmation-form" >-->
                  <input type='file' name="image" class="form--control" form="confirmation-form"  onchange="readURL(this);" required />

                  <div class="proimg-area">
                     <img name="image" form="confirmation-form" id="blah" src="../../assets/images/default.png" alt="your image" />
                  </div>
                </div>
                
                
                                    
                                    
                                    
                                    
                                    
                                    
                                <div class="col-lg-4 mb-3">
                                    <label class="">@lang('Check-In')</label>
                                    <div class="custom-icon-field">
                                        <input type="text" id="cheakin" name="check_in" form="confirmation-form" data-range="false" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form--control" data-date-format="mm/dd/yyyy" data-position='top left' placeholder="@lang('Month/Date/Year')" autocomplete="off">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div>

                                <div class="col-lg-4 mb-3">
                                    <label class="">@lang('Check-Out')</label>
                                    <div class="custom-icon-field">
                                        <input id="checkout" type="text" name="check_out" form="confirmation-form" data-range="false" data-multiple-dates-separator=" - " data-language="en" class="datepicker-here form--control" data-date-format="mm/dd/yyyy" data-position='top left' placeholder="@lang('Month/Date/Year')" autocomplete="off">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="bookingLimitationMsg text--warning"></div>
                                </div>


                                <div class=" col-lg-4 mb-3">
                                    <label class="">@lang('Rooms')</label>
                                    <input id="room" type="number" name="number_of_rooms" form="confirmation-form" class="form--control" placeholder="@lang('Number of Rooms')" >
                                </div>
                                      
                                                               
                                <!--<div class="col-lg-4 mb-3">-->
                                <!--    <label class="">@lang('fare')</label>-->
                                <!--    <div class="custom-icon-field">-->
                                <!--    <input type="text" id="type1" name="totalval" disabled="disabled" class="form--control rate_unit input" value="{{ __($general->cur_sym) }}{{ showAmount($roomType->fare) }}">-->
                                <!--    </div>-->
                                <!--</div>-->


                                    <div id="new_input_2" class="col-lg-4 d-none">
                      <div class="form-group">
                        <label>Payment Option</label>
                        <select class="form--control" form="confirmation-form" name="payment_option">
                           <option value="">select</option>
                          <option id="Part" value="1">Part Payment</option>
                          <option id="Full" value="2">Full Payment</option>
                        </select>
                      </div>

                    </div>
                    
                    
                                                        <div  class="col-lg-4 "></div>

                    
                    
                    
                                    <div  class="col-lg-3 parts">
                                    <label class="">@lang('First Deposit')</label>

                                <input type="text" id="type2" name="first_deposit" form="confirmation-form"  class=" form--control parts" >
                                <!--<input type="text" name="inideposit" class="form-control" id="inideposit" onchange="updateDue()">-->
                                 <!--<input type="text" id="type2" class="input">-->
                                </div>
                                
                           
                                
                                
                                
                                    <div  class="col-lg-3 parts">
                                    <label class="">@lang('Outstanding Amount')</label>
                                    <input class="form--control display" disabled></input>
                                                  <input class="form--control display d-none" form="confirmation-form" name="outstanding_amount"></input>

                                <!--<input type="text"  name="outstanding_amount"   class=" form--control parts">-->
                                 <!--<input type="text" name="remainingval" class="form-control" id="remainingval">-->
                                           

                                </div>
                                
                                 <div  class="col-lg-2 parts">
                                    <label class=""></label>
                                <div class="mt-2 parts">
                                <button class="btn btn-primary" id="button">Calculate</button>
                                
                                </div>
                                </div>
                                  
                                  
                                  
                                
                                <!--<input type="text" id="new_input_2" class="d-none">-->
                                
                                
<!--                               <form name="SumForm">-->
<!--<input type=text name="firstBox" value=""  onFocus="startCalc();" -->
<!--onBlur="stopCalc();"> - <input type=text name="secondBox" disabled value="500" onFocus="startCalc();" -->
<!--onBlur="stopCalc();"> = <input type=text name="thirdBox">-->
<!--</form>-->
                                
                                
                                
                                </div>
                                
                                
                    
              <!--<div class="row">-->
              <!--  <div class="col-lg-12">-->
              <!--    <h4>Receipt Details</h4>-->
              <!--  </div>-->

              <!--  <div class="col-lg-12">-->

                  <!--<table class="table regTable">-->
                  <!--  <thead class="thead-light">-->
                  <!--    <tr>-->
                  <!--      <th scope="col">Receipt Type</th>-->
                  <!--      <th scope="col">Receipt No.</th>-->
                  <!--      <th scope="col">Receipt Date</th>-->
                  <!--      <th scope="col">Amount</th>-->
                  <!--      <th scope="col"></th>-->
                  <!--    </tr>-->
                  <!--  </thead>-->
                  <!--  <tbody class="form-main">-->
                  <!--    <tr class="form-block">-->
                  <!--      <th scope="row">-->
                  <!--        <div class="form-check form-check-inline">-->
                  <!--          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6"-->
                  <!--            value="option1">-->
                  <!--          <label class="form-check-label" for="inlineRadio6">Advance</label>-->
                  <!--        </div>-->
                  <!--        <div class="form-check form-check-inline">-->
                  <!--          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6"-->
                  <!--            value="option2">-->
                  <!--          <label class="form-check-label" for="inlineRadio6">Sec Deposit</label>-->
                  <!--        </div>-->
                  <!--      </th>-->
                  <!--      <td><input id="" type="text" name="" class="form-control"></td>-->
                  <!--      <td><input type="date" id="birthday" name="birthday" class="form-control"></td>-->
                  <!--      <td><input id="" type="text" name="" class="form-control"></td>-->
                  <!--      <td>-->
                  <!--        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="plus"><a-->
                  <!--            class="add-more-btn"><i class="fa fa-plus col-red" aria-hidden="true"></i></a></span>-->
                  <!--        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Print"><i-->
                  <!--            class="fa fa-print pl-3 col-red" aria-hidden="true"></i></span>-->
                  <!--        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete"><i-->
                  <!--            class="fa fa-trash pl-3 col-red" aria-hidden="true"></i></span>-->

                  <!--      </td>-->
                  <!--    </tr>-->
                  <!--    {{-- <tr>-->
                  <!--      <th scope="row">-->
                  <!--        <div class="form-check form-check-inline">-->
                  <!--          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio6"-->
                  <!--            value="option3">-->
                  <!--          <label class="form-check-label" for="inlineRadio6">Advance</label>-->
                  <!--        </div>-->
                  <!--        <div class="form-check form-check-inline">-->
                  <!--          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio7"-->
                  <!--            value="option4">-->
                  <!--          <label class="form-check-label" for="inlineRadio7">Sec Deposit</label>-->
                  <!--        </div>-->
                  <!--      </th>-->
                  <!--      <td><input id="" type="text" name="" class="form-control"></td>-->
                  <!--      <td><input type="date" id="birthday" name="birthday" class="form-control"></td>-->
                  <!--      <td><input id="" type="text" name="" class="form-control"></td>-->
                  <!--      <td>-->
                  <!--        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Save"><i-->
                  <!--            class="fa fa-plus col-red" aria-hidden="true"></i></span>-->
                  <!--        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Print"><i-->
                  <!--            class="fa fa-print pl-3 col-red" aria-hidden="true"></i></span>-->
                  <!--        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete"><i-->
                  <!--            class="fa fa-trash pl-3 col-red" aria-hidden="true"></i></span>-->

                  <!--      </td>-->
                  <!--    </tr> --}}-->

                  <!--  </tbody>-->
                  <!--</table>-->

              <!--    <div class="row m-1">-->
              <!--      <table class="_table" id="tableId">-->
              <!--        <thead style="height: 40px;background-color: #002e5a;color:white;">-->
              <!--          <tr>-->
              <!--            <th>{{ __('Receipt Type') }}</th>-->
              <!--            {{-- <th>{{ __('Receipt No.') }}</th> --}}-->
              <!--            <th>{{ __(' Receipt Date') }}</th>-->
              <!--            <th>{{ __('Amount') }}</th>-->
              <!--            <th width="50px"></th>-->
              <!--          </tr>-->
              <!--        </thead>-->
              <!--        <tbody id="table_body">-->
              <!--          <tr style="border:1px solid bisque;height: 61px;" id="appendRow_0">-->
              <!--            <td scope="row" p="3">-->
              <!--<div class="form-check form-check-inline">-->
              <!--      <input class="form-check-input" type="radio" name="receipt_type[]" value="Advance" form="confirmation-form">-->
              <!--      <label class="form-check-label" for="inlineRadio6">Advance</label>-->
              <!--      </div>-->
              <!--      <div class="form-check form-check-inline">-->
              <!--      <input class="form-check-input" type="radio" name="receipt_type[]" value="Sec Deposit" form="confirmation-form">-->
              <!--      <label class="form-check-label" for="inlineRadio6">Sec Deposit</label>-->
              <!--      </div>-->
              <!--      <input type="radio" id="receiptAdvance_0"  value="Advance" name="receipt_type[]" form="confirmation-form">-->
              <!--      <label for="country1">Advance</label>-->
              <!--      <input type="radio" id="receiptSec_0" value="Sec Deposit" name="receipt_type[]" form="confirmation-form">-->
              <!--      <label for="country2">Sec Deposit</label>-->
              <!--      </td>-->
                          <!--<td>-->
                          <!--    <input type="date" class="form-control" id="date" name="date[]" value="{{ date('Y-m-d') }}" required>         -->
                          <!--</td>   -->
              <!--            {{-- <td>-->
              <!--              <input type="text" class="form--control" onBlur="calculateAmount(this.value,0);"-->
              <!--                placeholder="Quantity" id="quantity" name="quantity[]"-->
              <!--                onkeypress="javascript:return isNumber(event)" value="{{ old('quantity') }} " required>-->
              <!--            </td> --}}-->
              <!--            <td>-->
              <!--              <input type="date" class="form--control" onBlur="calculateAmount(this.value,0);"-->
              <!--                placeholder="Receipt Date" name="receipt_date[]"-->
              <!--                onkeypress="javascript:return isNumber(event)" value="{{ old('receipt_date') }}" form="confirmation-form" required>-->
              <!--            </td>-->
              <!--            <td>-->
              <!--              <input type="text" class="form--control amount" onblur="calculateSum()" placeholder="Amount"-->
              <!--                 name="receipt_amount[]" value="{{ old('receipt_amount') }}" form="confirmation-form" required>-->
              <!--            </td>-->
                          <!--<td>-->
                          <!--    <input type="file" class="form-control"  id="attachment" name="attachment[]" value="{{ old('attachment') }}" >         -->
                          <!--</td>                                        -->
              <!--            <td style="width: 92px;">-->
              <!--              <div class="action_container">-->
              <!--                <a type="button" class=" addmoreprodtxtbx" id="clonebtn"><i class="fa fa-plus"></i></a>-->
              <!--                <a class=" removeprodtxtbx" id="removerow"><i class="fa fa-trash"></i></a>-->
              <!--              </div>-->
              <!--            </td>-->
              <!--          </tr>-->
              <!--        </tbody>-->

              <!--      </table>-->
              <!--    </div>-->


              <!--  </div>-->

              <!--</div>-->


                                <div class="room-booking-widget__body">
                                    <ul class="room-booking-widget-list"></ul>
                                    <button type="button" class="btn btn--base w-100 confirmationBtn" data-action="{{ route('booking.request') }}" data-question="@lang('Are your sure, you want to book this room?')">@lang('SEND BOOKING REQUEST')</button>
                                </div>
                                
                                <div class="text-center">
                                    <img name="image" form="confirmation-form" id="blah" src="../../assets/images/qr.jpg" alt="Payment" style="height:500px;" />
                                    <p style="font-weight:bold;font-style: italic;color:red;">Please scan the QR code and do the payment. After payment, you have to show the receipt on the counter as the time of checkin.</p>
                                </div>

                            </div><!-- room-booking-widget end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- room details section end -->
    <x-confirmation-modal></x-confirmation-modal>
@endsection

@push('style')
    <style>
        #confirmationModal button {
            padding: 0.375rem 0.625rem;
            font-size: 0.875rem;
        }
        .respons{
            margin-top:70px;
        }
        label {
  color: #212121;
  margin-bottom: 8px;
  font-size: 15px;
  font-weight: 500;
  font-style: italic;
  font-family: 'ABeeZee', sans-serif;
}

.parts{
    display:none;
}
.fulls{
    display:none;
}
    </style>
@endpush

@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
    <script type="text/javascript">

</script>
@endpush

@push('script')

    <script>
    
    
    
    
//     var calc = document.getElementById("button");

// calc.addEventListener("click", calculate);

// function calculate(){
//   let type1 = document.getElementById("type1").value; 
//   let type2 = document.getElementById("type2").value;
//   let result = parseInt(type1) - parseInt(type2);
//   let display = document.getElementById("display");
//   display.value = result;
// }

    
    
    $(document).ready(function() {
  $("#button").click(function() {
    var type1 = $("#type1").val();
    var type2 = $("#type2").val();
    var result = parseInt(type1) - parseInt(type2);
    $(".display").val(result);
  });
});
    
    
    
    
    
    
    
    
    function updateDue() {

    var total = parseInt(document.getElementById("totalval").value);
    var val2 = parseInt(document.getElementById("inideposit").value);

    // to make sure that they are numbers
    if (!total) { total = 0; }
    if (!val2) { val2 = 0; }

    var ansD = document.getElementById("remainingval");
    ansD.value = total - val2;
}
    
    
    
    
    
    
    
    
    
    
    
    
    $(document).ready(function(){
  $("#Part").click(function(){
    $(".parts").show();
  });
  $("#Full").click(function(){
    $(".parts").hide();
  });
});
    

       "use strict";
        let maxRoomBookingLimit = 0;
        let btnRequest = $('.confirmationBtn');
        btnRequest.attr('disabled', true);

        $('.datepicker-here').on('focusout', function(e) {
            e.preventDefault();

            let data = {};

            data.check_in = $('input[name=check_in]').val();
            data.check_out = $('input[name=check_out]').val();
            data.room_type_id = $('input[name=room_type_id]').val();

            $('[name=number_of_rooms]').val('');

            if (!data.check_in || !data.check_out) {
                return;
            }

            $.ajax({
                type: "get",
                url: "{{ route('room.available.search') }}",
                data: data,
                success: function(response) {
                    let messageBox = $('.bookingLimitationMsg');
                    if (response.success) {
                        maxRoomBookingLimit = response.success;
                        messageBox.text(`@lang('You can book maximum ${response.success} rooms')`);
                        btnRequest.removeAttr('disabled');
                    } else {
                        notify('error', response.error);
                        messageBox.empty();
                        btnRequest.attr('disabled', true);
                        $('input[name=check_in]').val('');
                        $('input[name=check_out]').val('');
                    }
                }
            });
        });

        $('[name=number_of_rooms]').on('input', function() {
            $('.confirmationBtn').attr('disabled', false);
            if ($(this).val() > maxRoomBookingLimit) {
                btnRequest.attr('disabled', true);
                notify('error', "Number of rooms can't be greater than maximum allowed room");
            }
        });


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width("100%")
                        .height(290);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
        
        
//     $('#cheakin,#checkout,#room').blur(function(){
//     var cheakin = $('#cheakin').val();
//     var checkout = $('#checkout').val();
//     var room = $('#room').val();
//     if (cheakin && checkout && room != '') {
//         $('#new_input_1,#new_input_2').removeClass('d-none');
//     } else {
//         $('#new_input_1,#new_input_2').addClass('d-none');
//     }
// });


$(document).ready(function() {
  $('#cheakin, #checkout, #room').on('blur', function() {
    checkInputs();
  });
});

function checkInputs() {
  var firstValue = $('#cheakin').val();
  var secondValue = $('#checkout').val();
  var thirdValue = $('#room').val();
  
  if (firstValue !== '' && secondValue !== '' && thirdValue !== '') {
    $('#new_input_1,#new_input_2').show();
  } else {
    $('#new_input_1,#new_input_2').hide();
  }
}


  
</script>

@endpush


@push('style')
    <style>
        .main-wrapper {
            background-color: #fafafa
        }
    </style>
@endpush
