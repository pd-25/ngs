@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--info overflow-hidden">
                        <a href="{{ route('admin.booking.all') }}?search={{ $user->username }}" class="item-link"></a>
                        <div class="widget-two__icon b-radius--5 bg--info">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $widget['total_bookings'] }}</h3>
                            <p class="text-white">@lang('Total Bookings')</p>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--success overflow-hidden">
                        <a href="{{ route('admin.booking.active') }}?search={{ $user->username }}" class="item-link"></a>
                        <div class="widget-two__icon b-radius--5 bg--success">
                            <i class="las la-ban"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $widget['running_bookings'] }}</h3>
                            <p class="text-white">@lang('Running Bookings')</p>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--warning">
                        <a href="{{ route('admin.booking.request.all') }}?search={{ $user->username }}" class="item-link"></a>
                        <div class="widget-two__icon b-radius--5 bg--warning">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $widget['booking_requests'] }}</h3>
                            <p class="text-white">@lang('Booking Request')</p>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--3">
                        <a href="{{ route('admin.report.payments.received') }}?search={{ $user->username }}" class="item-link"></a>
                        <div class="widget-two__icon b-radius--5 bg--3">
                            <i class="las la-wallet"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ $general->cur_sym . showAmount($widget['total_payment']) }}</h3>
                            <p class="text-white">@lang('Total Payment')</p>
                        </div>
                    </div>
                </div><!-- dashboard-w1 end -->
            </div>

            <div class="row gy-4 justify-content-center mt-1" style="display:none;">

                <div class="col-sm-6 col-lg-4 col-xl-3 col-xxl-3">
                    <a href="{{ route('admin.users.notification.log', $user->id) }}" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3 col-xxl-3">
                    <a href="{{ route('admin.report.login.history') }}?search={{ $user->username }}" class="btn btn--info btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3 col-xxl-3">
                    <a href="{{ route('admin.users.login', $user->id) }}" target="_blank" class="btn btn--dark btn--shadow w-100 btn-lg">
                        <i class="las la-sign-in-alt"></i>@lang('Login as User')
                    </a>
                </div>

                <div class="col-sm-6 col-lg-4 col-xl-3 col-xxl-3">
                    @if ($user->status == 1)
                        <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-check"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>
            </div>


            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Full Name')</label>
                                    <input class="form-control" type="text" name="firstname" required value="{{ $user->firstname }}">
                                </div>
                            </div>

                            <div class="col-md-6" style="display:none;">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required value="{{ $user->lastname }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email" required value="{{ $user->email }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('DOB')</label>
                                    <input class="form-control" type="date" name="dob" required value="{{ $user->dob }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('C.D.C No./INDOS No.')</label>
                                    <input class="form-control" type="text" name="cdc" required value="{{ $user->cdc }}">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Rank')</label>
                                    <select class="form-control" name="rank" required id="rank">
                                    <option value="">Select Rank</option>
                                    <option value="OFFICER - MASTER" <?php if($user->rank == "OFFICER - MASTER") { echo 'selected'; } ?> >OFFICER - MASTER</option>
                                    <option value="OFFICER - CHIEF OFFICER" <?php if($user->rank == "OFFICER - CHIEF OFFICER") { echo 'selected'; } ?>>OFFICER - CHIEF OFFICER</option>
                                    <option value="OFFICER - 2ND OFFICER" <?php if($user->rank == "OFFICER - 2ND OFFICER") { echo 'selected'; } ?>>OFFICER - 2ND OFFICER</option>
                                    <option value="OFFICER - 3RD OFFICER" <?php if($user->rank == "OFFICER - 3RD OFFICER") { echo 'selected'; } ?>>OFFICER - 3RD OFFICER</option>
                                    <option value="OFFICER - OTHER OFFICER" <?php if($user->rank == "OFFICER - OTHER OFFICER") { echo 'selected'; } ?>>OFFICER - OTHER OFFICER</option>
                                    <option value="OFFICER - CHIEF ENGINEER" <?php if($user->rank == "OFFICER - CHIEF ENGINEER") { echo 'selected'; } ?>>OFFICER - CHIEF ENGINEER</option>
                                    <option value="OFFICER - 2ND ENGINEER" <?php if($user->rank == "OFFICER - 2ND ENGINEER") { echo 'selected'; } ?>>OFFICER - 2ND ENGINEER</option>
                                    <option value="OFFICER - 3RD ENGINEER" <?php if($user->rank == "OFFICER - 3RD ENGINEER") { echo 'selected'; } ?>>OFFICER - 3RD ENGINEER</option>
                                    <option value="OFFICER - 4TH ENGINEER" <?php if($user->rank == "OFFICER - 4TH ENGINEER") { echo 'selected'; } ?>>OFFICER - 4TH ENGINEER</option>
                                    <option value="OFFICER - OTHER ENGINEER" <?php if($user->rank == "OFFICER - OTHER ENGINEER") { echo 'selected'; } ?>>OFFICER - OTHER ENGINEER</option>
                                    <option value="TRAINEE - DECK CADET" <?php if($user->rank == "TRAINEE - DECK CADET") { echo 'selected'; } ?>>TRAINEE - DECK CADET</option>
                                    <option value="TRAINEE - ENGINE CADET" <?php if($user->rank == "TRAINEE - ENGINE CADET") { echo 'selected'; } ?>>TRAINEE - ENGINE CADET</option>
                                    <option value="CREW - BOSUN" <?php if($user->rank == "CREW - BOSUN") { echo 'selected'; } ?>>CREW - BOSUN</option>
                                    <option value="CREW - AB" <?php if($user->rank == "CREW - AB") { echo 'selected'; } ?>>CREW - AB</option>
                                    <option value="CREW - OS" <?php if($user->rank == "CREW - OS") { echo 'selected'; } ?>>CREW - OS</option>
                                    <option value="CREW - MOTORMAN / OILER" <?php if($user->rank == "CREW - MOTORMAN / OILER") { echo 'selected'; } ?>>CREW - MOTORMAN / OILER</option>
                                    <option value="CREW - WIPER" <?php if($user->rank == "CREW - WIPER") { echo 'selected'; } ?>>CREW - WIPER</option>
                                    <option value="CREW - TRAINEE RATINGS" <?php if($user->rank == "CREW - TRAINEE RATINGS") { echo 'selected'; } ?>>CREW - TRAINEE RATINGS</option>
                                    <option value="CREW - OTHER CREW" <?php if($user->rank == "CREW - OTHER CREW") { echo 'selected'; } ?>>CREW - OTHER CREW</option>
                                    <option value="CREW - CHIEF COOK" <?php if($user->rank == "CREW - CHIEF COOK") { echo 'selected'; } ?>>CREW - CHIEF COOK</option>
                                    <option value="CREW - 2ND COOK" <?php if($user->rank == "CREW - 2ND COOK") { echo 'selected'; } ?>>CREW - 2ND COOK</option>
                                    <option value="PASSENGER SHIP CREW" <?php if($user->rank == "PASSENGER SHIP CREW") { echo 'selected'; } ?>>PASSENGER SHIP CREW</option>
                                    <option value="TRAINEE - MAI" <?php if($user->rank == "TRAINEE - MAI") { echo 'selected'; } ?>>TRAINEE - MAI</option>
                                </select>
                                </div>
                            </div>
                            
                            
                        </div>


                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{ @$user->address->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{ @$user->address->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state" value="{{ @$user->address->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip" value="{{ @$user->address->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country')</label>
                                    <select name="country" class="form-control">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="row" style="display:none;">
                            <div class="form-group col-xl-6 col-md-6 col-sm-3 col-12">
                                <label>@lang('Email Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev"
                                       @if ($user->ev) checked @endif>

                            </div>

                            <div class="form-group col-xl-6 col-md-6 col-sm-3 col-12">
                                <label>@lang('Mobile Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                       data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv"
                                       @if ($user->sv) checked @endif>

                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn--primary w-100 h-45">@lang('Submit')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == 1)
                            <span>@lang('Ban User')</span>
                        @else
                            <span>@lang('Unban User')</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == 1)
                            <h4 class="mt-3 text-center">@lang('Are you sure to ban this user?')</h4>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span class="fw-bold">@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="mt-3 text-center">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == 1)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        (function($) {
            "use strict"

            let mobileElement = $('.mobile-code');
            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });
            $('select[name=country]').val('{{ @$user->country_code }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $user->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);
        })(jQuery);
    </script>
@endpush
