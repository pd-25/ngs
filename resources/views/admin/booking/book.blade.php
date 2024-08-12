@extends('admin.layouts.app')
@section('panel')
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.room.search') }}" method="get" class="formRoomSearch">
                        <div class="d-flex justify-content-between align-items-end flex-wrap gap-2">
                            <div class="form-group flex-fill">
                                <label>@lang('Bed Type')</label>
                                <select name="room_type" class="form-control" required>
                                    <option value="">@lang('Select One')</option>
                                    @foreach ($roomTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group flex-fill">
                                <label>@lang('Check In - Check Out Date')</label>
                                <input name="date" type="text" data-range="true" data-multiple-dates-separator=" To "
                                    data-language="en" class="datepicker-here form-control bg--white"
                                    data-position='bottom left' placeholder="@lang('Select Date')" autocomplete="off" required>
                            </div>


                            <div class="form-group flex-fill">
                                <label>@lang('Bed')</label>
                                <input name="rooms" class="form-control" type="text" placeholder="@lang('How many bed?')"
                                    required>
                            </div>

                            <div class="form-group flex-flex">
                                <button type="submit" class="btn btn--primary w-100 h-45"><i
                                        class="la la-search"></i>@lang('Search')</button>
                                <span id="clear-btn" class="cursor-pointer"><i class="la la-close"></i></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row booking-wrapper d-none">
        <div class="col-lg-8 mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title d-flex justify-content-between booking-info-title mb-0">
                        <h5>@lang('Booking Information')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="pb-3">
                        <span class="fas fa-circle text--danger" disabled></span>
                        <span class="mr-5">@lang('Booked')</span>
                        <span class="fas fa-circle text--success"></span>
                        <span class="mr-5">@lang('Selected')</span>
                        <span class="fas fa-circle text--primary"></span>
                        <span>@lang('Available')</span>
                    </div>
                    <div class="alert alert-info room-assign-alert p-3" role="alert">
                    </div>
                    <div class="bookingInfo">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mt-3">
            <div class="card">
                <div class="card-header">
                    <div class="card-title mb-0">
                        <h5>@lang('Book Room/Bedss')</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.room.book') }}" method="POST" class="booking-form" id="booking-form"
                        enctype="multipart/form-data">
                        @csrf
                        <input type ="hidden" value="{{ auth()->guard('admin')->id() }}" name="booked_user_id">
                        <input type="hidden" value="0" name="guest_type" id="guest_type">
                        <div class="row">
                            {{-- <div class="form-group flex-fill">
                                <label>@lang('Guest Type')</label>
                                <select name="guest_type" class="form-control">
                                    <option value="0" selected>@lang('Walk-In Guest')</option>
                                    <option value="1">@lang('Existing Guest')</option>

                                </select>
                            </div> --}}
                            <div class="form-group guestInputDiv">
                                <label>@lang('Phone Number')</label>
                                <input type="number" class="form-control " name="mobile" id="mobile" required>
                            </div>

                            <div class="form-group ">
                                <label>C.D.C No./INDOS No.</label>
                                <input type="text" class="form-control" name="c_d_c_number" id="c_d_c_number" required>
                            </div>

                            <div class="form-group guestInputDiv">
                                <label>@lang('Name')</label>
                                <input type="text" class="form-control forGuest" name="guest_name" id="guest_name"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>@lang('Email')</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>

                            

                            <div class="form-group">
                                <label>@lang('Date Of Birth')</label>

                                <input type="date" class="form-control" name="dob" id="dob"
                                    placeholder="@lang('DOB')" autocomplete="off" required>
                            </div>

                           

                            <div class="form-group">
                                <label for="payment-mode">@lang('Rank')</label>
                                <select class="form-control" name="rank" id="rank" required>
                                    <option value="">@lang('Select Rank')</option>
                                    <option value="OFFICER - MASTER">OFFICER - MASTER</option>
                                    <option value="OFFICER - CHIEF OFFICER">OFFICER - CHIEF OFFICER</option>
                                    <option value="OFFICER - 2ND OFFICER">OFFICER - 2ND OFFICER</option>
                                    <option value="OFFICER - 3RD OFFICER">OFFICER - 3RD OFFICER</option>
                                    <option value="OFFICER - OTHER OFFICER">OFFICER - OTHER OFFICER</option>
                                    <option value="OFFICER - CHIEF ENGINEER">OFFICER - CHIEF ENGINEER</option>
                                    <option value="OFFICER - 2ND ENGINEER">OFFICER - 2ND ENGINEER</option>
                                    <option value="OFFICER - 3RD ENGINEER">OFFICER - 3RD ENGINEER</option>
                                    <option value="OFFICER - 4TH ENGINEER">OFFICER - 4TH ENGINEER</option>
                                    <option value="OFFICER - OTHER ENGINEER">OFFICER - OTHER ENGINEER</option>
                                    <option value="TRAINEE - DECK CADET">TRAINEE - DECK CADET</option>
                                    <option value="TRAINEE - ENGINE CADET">TRAINEE - ENGINE CADET</option>
                                    <option value="CREW - BOSUN">CREW - BOSUN</option>
                                    <option value="CREW - AB">CREW - AB</option>
                                    <option value="CREW - OS">CREW - OS</option>
                                    <option value="CREW - MOTORMAN / OILER">CREW - MOTORMAN / OILER</option>
                                    <option value="CREW - WIPER">CREW - WIPER</option>
                                    <option value="CREW - TRAINEE RATINGS">CREW - TRAINEE RATINGS</option>
                                    <option value="CREW - OTHER CREW">CREW - OTHER CREW</option>
                                    <option value="CREW - CHIEF COOK">CREW - CHIEF COOK</option>
                                    <option value="CREW - 2ND COOK">CREW - 2ND COOK</option>
                                    <option value="PASSENGER SHIP CREW">PASSENGER SHIP CREW</option>
                                    <option value="TRAINEE - MAI">TRAINEE - MAI</option>
                                </select>
                            </div>

                            <!--<div class="form-group ">-->
                            <!--    <label>INDOS No.</label>-->
                            <!--    <input type="text" class="form-control " name="indos_number" required>-->
                            <!--</div>-->

                            <div class="form-group ">
                                <label1>Address</label1>
                                <textarea type="text" class="form-control " name="address" id="address" required></textarea>
                            </div>
                            <div class="form-group ">
                                <label1>State</label1>
                                <input type="text" class="form-control " name="state" id="state" required>
                            </div>
                            <div class="form-group ">
                                <label1>City</label1>
                                <input type="text" class="form-control " name="city" id="city" required>
                            </div>
                            <div class="form-group ">
                                <label1>Pincode</label1>
                                <input type="number" class="form-control " name="pincode" id="pincode" required>
                            </div>
                            <div class="form-group">
                                <label>@lang('Check In Time')</label>
                                <!--<input type="datetime-local" class="form-control " name="cheak_in_time" placeholder="@lang('Select Time')" autocomplete="off" required>-->
                                <input type="datetime-local" class="form-control" name="cheak_in_time"
                                    id="check_in_time" placeholder="@lang('Select Time')" autocomplete="off" required>
                            </div>


                            <div class="orderList d-none">
                                <ul class="list-group list-group-flush orderItem">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <h6>@lang('Room/Bed')</h6>
                                        <h6>@lang('Days')</h6>
                                        <span>
                                            <h6>@lang('Fare')</h6>
                                        </span>
                                        <span>
                                            <h6>@lang('Sub Total')</h6>
                                        </span>
                                    </li>
                                </ul>
                                <div class="d-flex justify-content-between align-items-center border-top p-3">
                                    <span>@lang('Total Fare')</span>
                                    <span class="totalFare" data-amount="0" id="totalFare"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <span>@lang('Total Fare')</span>
                                <input type="text" name="total_amount" id="total_amount" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>@lang('Paying/Advance Amount')</label>
                                <input type="number" step="any" min="0" class="form-control"
                                    name="paid_amount" placeholder="@lang('Paying Amount')">
                            </div>

                            <span class="extraservices"></span>

                            <div class="form-group">
                                <label for="payment-mode">@lang('Payment Mode')</label>
                                <select class="form-control" name="payment_mode" required>
                                    <option value="">@lang('Select Payment Mode')</option>
                                    <option value="Cash">Cash</option>
                                    <option value="UPI">UPI</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Online">Online</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Image')</label>
                                <img name="image" form="confirmation-form" id="blah"
                                    src="../../assets/images/default.png" alt="your image" />
                                Select image to upload:
                                <input type='file' name="file" id="file" class="form--control"
                                    form="confirmation-form" onchange="readURL(this);" required />
                            </div>

                            <div class="form-group mb-0">
                                <button type="button"
                                    class="btn btn--primary h-45 w-100 btn-book confirmBookingBtn">@lang('Book Now')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="confirmBookingModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Confirmation Alert!')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('Are you sure to book this room/Bed?')</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                    <button type="button" class="btn btn--primary btn-confirm"
                        data-bs-dismiss="modal">@lang('Yes')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/vendor/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/vendor/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/global/js/custom.js') }}"></script>
@endpush

@push('style')
    <style>
        .booking-table td {
            white-space: unset;
        }
    </style>
@endpush

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeInput = document.querySelector('input[name="time"]');

            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const currentTime = `${hours}:${minutes}`;

            timeInput.value = currentTime;
        });


        "use strict";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $('[name=guest_type]').on('change', function() {
            if ($(this).val() == 1) {
                $('.guestInputDiv').addClass('d-none');
                $('.forGuest').attr("required", false);
            } else {
                $('.guestInputDiv').removeClass('d-none');
                $('.forGuest').attr("required", true);
            }
        });

        $('.formRoomSearch').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            let url = $(this).attr('action');
            let submitButton = $(this).find('button[type="submit"]');

            // Disable the submit button and show loading text
            submitButton.prop('disabled', true).html("<i class='la la-spinner la-spin'></i> @lang('Loading...')");
            $.ajax({
                type: "get",
                url: url,
                data: formData,
                success: function(response) {
                    $('.bookingInfo').html('');
                    $('.booking-wrapper').addClass('d-none');
                    if (response.error) {
                        notify('error', response.error);
                    } else if (response.html.error) {
                        notify('error', response.html.error);
                    } else {
                        $('.bookingInfo').html(response.html);
                        $('.extraservices').html(response.services);
                        $('.booking-wrapper').removeClass('d-none');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notify('error', '@lang('An error occurred.Please try again.')');
                },
                complete: function() {
                    // Re-enable the submit button and reset the text
                    submitButton.prop('disabled', false).html(
                        '<i class="la la-search"></i> @lang('Search')');
                }
            });
        });
        $(document).on('click', '#clear-btn', function() {
            $('form.formRoomSearch')[0].reset();
            $('.datepicker-here').datepicker().data('datepicker').clear();
            $('.bookingInfo').html('');
            $('.booking-wrapper').addClass('d-none');
        });
        $(document).on('click', '.confirmBookingBtn', function() {
            var modal = $('#confirmBookingModal');
            modal.modal('show');
        });

        $('.btn-confirm').on('click', function() {
            $('.booking-form').submit();
        });

        $('.booking-form').on('submit', function(e) {
            e.preventDefault();
            /* let formData = $(this).serialize();*/

            let url = $('.booking-form').attr('action');

            var formData = $('.booking-form').serializeArray();
            var fileInput = $('#file')[0];

            // If a file is selected, include it in the serialized data

            if (fileInput.files.length > 0) {
                var fileName = fileInput.files[0].name;
                formData.push({
                    name: 'file',
                    value: fileName
                });
            }

            $.ajax({
                type: "POST",
                url: url,
                data: formData,
                success: function(response) {
                    if (response.success) {
                        notify('success', response.success);
                        $('.bookingInfo').html('');
                        $('.booking-wrapper').addClass('d-none');
                        $(document).find('.orderListItem').remove();
                        $('.orderList').addClass('d-none');
                        $('.formRoomSearch').trigger('reset');
                        window.location.href = "{{ route('admin.booking.all') }}";

                    } else {
                        notify('error', response.error);
                    }
                },
            });
        })


        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width("100%")
                        .height(290);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        // Function to format the current date and time as a string compatible with datetime-local input
        function getCurrentDateTimeString() {
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString().padStart(2, '0');
            const hours = currentDate.getHours().toString().padStart(2, '0');
            const minutes = currentDate.getMinutes().toString().padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        // Set the value of the "Check In Time" input with the current date and time on page load
        document.getElementById('check_in_time').value = getCurrentDateTimeString();
    </script>

    <script>
        var total_amount = document.getElementById('total_amount');
        var totalFare = document.getElementById('totalFare');

        function updateVal() {
            totalFare.innerHTML = total_amount.value;
        }

        total_amount.addEventListener("input", updateVal);


        // $("#c_d_c_number").keyup(function(e){
        //     var cdc = $("#c_d_c_number").val();
        //     $.ajax({
        //         url: '{{ route('admin.users.get.cdc') }}?cdc='+cdc,
        //         type: "GET",
        //         success: function (data) {
        //             var user = JSON.parse(data);
        //             $("#guest_name").val(user.firstname+ +user.lastname);
        //             $("#email").val(user.email);
        //             $("#mobile").val(user.mobile);
        //             $("#dob").val(user.dob);
        //             $("#rank").val(user.rank);
        //             $("#address").html(user.address.address);
        //             $("#state").val(user.address.state);
        //             $("#pincode").val(user.address.zip);
        //             $("#city").val(user.address.city);
        //         }
        //     });
        $("#mobile").keyup(function(e) {
            console.log($("#mobile").val());
            var mobile = $("#mobile").val();
            if (mobile.length > 9) {
                $.ajax({
                    url: '{{ route('admin.get.mobile') }}?mobile=' + mobile,
                    type: "GET",
                    success: function(data) {
                        var user = JSON.parse(data);
                        console.log(user);
                        if (user) {
                            $("#guest_name").val(user.firstname + +user.lastname).prop('readonly',
                                true);
                            $("#email").val(user.email).prop('readonly', true);
                            $("#email").val(user.email).prop('readonly', true);
                            $("#c_d_c_number").val(user.cdc).prop('readonly', true);
                            $("#dob").val(user.dob).prop('readonly', true);
                            $("#rank").val(user.rank).prop('readonly', true);
                            $("#address").val(user.address).prop('readonly', true);
                            $("#state").val(user.address.state);
                            $("#pincode").val(user.address.zip);
                            $("#city").val(user.address.city);

                            $("#c_d_c_number").prop('readonly', true);
                            $("#email").prop('readonly', true);
                            $("#guest_type").val('1');

                        }else{
                            $("#guest_name").val(user.firstname + +user.lastname).prop('readonly',
                                false);
                            $("#email").val(user.email).prop('readonly', false);
                            $("#email").val(user.email).prop('readonly', false);
                            $("#c_d_c_number").val(user.cdc).prop('readonly', false);
                            $("#dob").val(user.dob).prop('readonly', false);
                            $("#rank").val(user.rank).prop('readonly', false);
                            $("#address").val(user.address).prop('readonly', false);
                            $("#state").val(user.address.state);
                            $("#pincode").val(user.address.zip);
                            $("#city").val(user.address.city);

                            $("#c_d_c_number").prop('readonly', false);
                            $("#email").prop('readonly', false);
                            $("#guest_type").val('0');
                        }

                    }
                });
            }



        });
    </script>
@endpush
