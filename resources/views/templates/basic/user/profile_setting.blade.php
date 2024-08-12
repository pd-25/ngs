@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card " style="margin-top:100px;">
        <div class="card-header">
            <h5 class="card-title">@lang('Profile Setting')</h5>
        </div>
        <div class="card-body">
            <form class="register" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row gy-4">
                    <div class="col-lg-6">
                        <label>@lang('First Name')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" name="firstname" value="{{ $user->firstname }}" placeholder="@lang('First Name')" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Last Name')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" name="lastname" value="{{ $user->lastname }}" placeholder="@lang('Last Name')" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Username')</label>
                        <div class="custom-icon-field">
                            <input class="form--control" value="{{ $user->username }}" readonly>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Email Address')</label>
                        <div class="custom-icon-field">
                            <input class="form--control" value="{{ $user->email }}" readonly>
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Mobile Number')</label>
                        <div class="custom-icon-field">
                            <input class="form--control" value="{{ $user->mobile }}" readonly>
                            <i class="fas fa-phone-alt"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Address')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" name="address" value="{{ @$user->address->address }}" placeholder="@lang('Your Address')">
                            <i class="fas fa-map-marked"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('State')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" name="state" value="{{ @$user->address->state }}" placeholder="@lang('State')">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Zip Code')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" name="zip" value="{{ @$user->address->zip }}" placeholder="@lang('Zip Code')">
                            <i class="fas fa-search-location"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('City')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" name="city" value="{{ @$user->address->city }}" placeholder="@lang('City')">
                            <i class="fas fa-city"></i>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label>@lang('Country')</label>
                        <div class="custom-icon-field">
                            <input type="text" class="form--control" value="{{ @$user->address->country }}" readonly>
                            <i class="fas fa-globe"></i>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn--base w-100">@lang('Submit Changes')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
